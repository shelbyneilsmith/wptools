<?php
require_once('wfDB.php');
require_once('wfUtils.php');
require_once('wfBrowscap.php');
class wfLog {
	private $hitsTable = '';
	private $apiKey = '';
	private $wp_version = '';
	private $db = false;
	private $googlePattern = '/\.(?:googlebot\.com|google\.[a-z]{2,3}|google\.[a-z]{2}\.[a-z]{2}|1e100\.net)$/i';
	private static $gbSafeCache = array();
	public function __construct($apiKey, $wp_version){
		$this->apiKey = $apiKey;
		$this->wp_version = $wp_version;
		global $wpdb;
		$this->hitsTable = $wpdb->base_prefix . 'wfHits';
		$this->loginsTable = $wpdb->base_prefix . 'wfLogins';
		$this->blocksTable = $wpdb->base_prefix . 'wfBlocks';
		$this->lockOutTable = $wpdb->base_prefix . 'wfLockedOut';
		$this->leechTable = $wpdb->base_prefix . 'wfLeechers';
		$this->badLeechersTable = $wpdb->base_prefix . 'wfBadLeechers';
		$this->scanTable = $wpdb->base_prefix . 'wfScanners';
		$this->throttleTable = $wpdb->base_prefix . 'wfThrottleLog';
		$this->statusTable = $wpdb->base_prefix . 'wfStatus';
	}
	public function logLogin($action, $fail, $username){
		$user = get_user_by('login', $username);
		$userID = 0;
		if($user){
			$userID = $user->ID;
		}
		$this->getDB()->query("insert into " . $this->loginsTable . " (ctime, fail, action, username, userID, IP, UA) values (%f, %d, '%s', '%s', %s, %s, '%s')", 
			sprintf('%.6f', microtime(true)),
			$fail,
			$action,
			$username,
			$userID,
			wfUtils::inet_aton(wfUtils::getIP()),
			(isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '')
			);
	}
	private function getCurrentUserID(){
		$id = get_current_user_id();
		return $id ? $id : 0;
	}
	private function getPagename(){
		global $wp_query;
		$post = $wp_query->get_queried_object();
		$pagename = $post->post_name;
		return $pagename;
	}
	public function logLeechAndBlock($type){ //404 or hit
		$IP = wfUtils::getIP();
		if($this->isWhitelisted($IP)){
			return;
		}
		if($type == '404'){
			$table = $this->scanTable;
		} else if($type == 'hit'){
			$table = $this->leechTable;
		} else {
			wordfence::status(1, 'error', "Invalid type to logLeechAndBlock(): $type");
			return;
		}
		$this->getDB()->query("insert into $table (eMin, IP, hits) values (floor(unix_timestamp() / 60), %s, 1) ON DUPLICATE KEY update hits = IF(@wfcurrenthits := hits + 1, hits + 1, hits + 1)", wfUtils::inet_aton($IP)); 
		$hitsPerMinute = $this->getDB()->querySingle("select @wfcurrenthits");
		if(wfConfig::get('firewallEnabled')){
			if(wfConfig::get('blockFakeBots')){
				if(wfCrawl::isGooglebot() && (! wfCrawl::verifyCrawlerPTR($this->googlePattern, $IP) )){
					wordfence::status(2, 'info', "Blocking fake Googlebot at IP $IP");
					$this->blockIP($IP, "Fake Google crawler automatically blocked");
				}
			}

			if(wfConfig::get('maxGlobalRequests') != 'DISABLED' && $hitsPerMinute > wfConfig::get('maxGlobalRequests')){ //Applies to 404 or pageview
				$this->takeBlockingAction('maxGlobalRequests', "Exceeded the maximum global requests per minute for crawlers or humans.");
			}
			if($type == '404'){
				global $wpdb; $p = $wpdb->base_prefix;
				if(wfConfig::get('other_WFNet')){
					$this->getDB()->query("insert IGNORE into $p"."wfNet404s (sig, ctime, URI) values (UNHEX(MD5('%s')), unix_timestamp(), '%s')", $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_URI']);
				}
				$pat = wfConfig::get('vulnRegex');
				if($pat){
					$URL = wfUtils::getRequestedURL();
					if(preg_match($pat, $URL)){
						$this->getDB()->query("insert IGNORE into $p"."wfVulnScanners (IP, ctime, hits) values (INET_ATON('%s'), unix_timestamp(), 1) ON DUPLICATE KEY UPDATE ctime = unix_timestamp, hits = hits + 1", $IP);
						if(wfConfig::get('maxScanHits') != 'DISABLED'){
							if( empty($_SERVER['HTTP_REFERER'] )){
								$this->getDB()->query("insert into " . $this->badLeechersTable . " (eMin, IP, hits) values (floor(unix_timestamp() / 60), %s, 1) ON DUPLICATE KEY update hits = IF(@wfblcurrenthits := hits + 1, hits + 1, hits + 1)", wfUtils::inet_aton($IP)); 
								$BL_hitsPerMinute = $this->getDB()->querySingle("select @wfblcurrenthits");
								if($BL_hitsPerMinute > wfConfig::get('maxScanHits')){
									$this->takeBlockingAction('maxScanHits', "Exceeded the maximum number of 404 requests per minute for a known security vulnerability.");
								}
							}
						}
					}
				}
			}
			if(wfCrawl::isCrawler($_SERVER['HTTP_USER_AGENT'])){
				if($type == 'hit' && wfConfig::get('maxRequestsCrawlers') != 'DISABLED' && $hitsPerMinute > wfConfig::get('maxRequestsCrawlers')){
					$this->takeBlockingAction('maxRequestsCrawlers', "Exceeded the maximum number of requests per minute for crawlers."); //may not exit
				} else if($type == '404' && wfConfig::get('max404Crawlers') != 'DISABLED' && $hitsPerMinute > wfConfig::get('max404Crawlers')){
					$this->takeBlockingAction('max404Crawlers', "Exceeded the maximum number of page not found errors per minute for a crawler.");
				}
			} else {
				if($type == 'hit' && wfConfig::get('maxRequestsHumans') != 'DISABLED' && $hitsPerMinute > wfConfig::get('maxRequestsHumans')){
					$this->takeBlockingAction('maxRequestsHumans', "Exceeded the maximum number of page requests per minute for humans.");
				} else if($type == '404' && wfConfig::get('max404Humans') != 'DISABLED' && $hitsPerMinute > wfConfig::get('max404Humans')){
					$this->takeBlockingAction('max404Humans', "Exceeded the maximum number of page not found errors per minute for humans.");
				}
			}
		}
	}
	public function isWhitelisted($IP){
		//We now whitelist all RFC1918 IP addresses and loopback
		if(strpos($IP, '127.') === 0 || strpos($IP, '10.') === 0 || strpos($IP, '192.168.') === 0 || strpos($IP, '172.') === 0){
			if(strpos($IP, '172.') === 0){
				$parts = explode('.', $IP);
				if($parts[1] >= 16 && $parts[1] <= 31){
					return true;
				}
			} else {
				return true;
			}
		}
		$list = wfConfig::get('whitelisted');
		if(! $list){ return false; }
		$list = explode(',', $list);
		if(sizeof($list) < 1){ return false; }
		foreach($list as $whiteIP){
			if(preg_match('/\[\d+\-\d+\]/', $whiteIP)){
				$IPparts = explode('.', $IP);
				$whiteParts = explode('.', $whiteIP);
				$mismatch = false;
				for($i = 0; $i <= 3; $i++){
					if(preg_match('/^\[(\d+)\-(\d+)\]$/', $whiteParts[$i], $m)){
						if($IPparts[$i] < $m[1] || $IPparts[$i] > $m[2]){
							$mismatch = true;
						}
					} else if($whiteParts[$i] != $IPparts[$i]){
						$mismatch = true;
					}
				}
				if($mismatch === false){
					return true; //Is whitelisted because we did not get a mismatch
				}
			} else if($whiteIP == $IP){
				return true;
			}
		}
		return false;
	}
	public function unblockAllIPs(){
		$this->getDB()->query("delete from " . $this->blocksTable);
	}
	public function unlockAllIPs(){
		$this->getDB()->query("delete from " . $this->lockOutTable);
	}
	public function unblockIP($IP){
		$this->getDB()->query("delete from " . $this->blocksTable . " where IP=%s", wfUtils::inet_aton($IP));
	}
	public function blockIP($IP, $reason, $wfsn = false, $permanent = false){ //wfsn indicates it comes from Wordfence secure network
		if($this->isWhitelisted($IP)){ return false; }
		$wfsn = $wfsn ? 1 : 0;
		if($permanent){
			//Insert permanent=1 or update existing perm or non-per block to be permanent
			$this->getDB()->query("insert into " . $this->blocksTable . " (IP, blockedTime, reason, wfsn, permanent) values (%s, unix_timestamp(), '%s', %d, %d) ON DUPLICATE KEY update blockedTime=unix_timestamp(), reason='%s', wfsn=%d, permanent=%d",
				wfUtils::inet_aton($IP),
				$reason,
				$wfsn,
				1,
				$reason,
				$wfsn,
				1
				);
		} else {
			//insert perm=0 but don't update and make perm blocks non-perm. 
			$this->getDB()->query("insert into " . $this->blocksTable . " (IP, blockedTime, reason, wfsn, permanent) values (%s, unix_timestamp(), '%s', %d, %d) ON DUPLICATE KEY update blockedTime=unix_timestamp(), reason='%s', wfsn=%d",
				wfUtils::inet_aton($IP),
				$reason,
				$wfsn,
				0,
				$reason,
				$wfsn
				);
		}
		return true;
	}
	public function lockOutIP($IP, $reason){
		if($this->isWhitelisted($IP)){ return false; }
		$this->getDB()->query("insert into " . $this->lockOutTable . " (IP, blockedTime, reason) values(%s, unix_timestamp(), '%s') ON DUPLICATE KEY update blockedTime=unix_timestamp(), reason='%s'",
			wfUtils::inet_aton($IP),
			$reason,
			$reason
			);
		return true;
	}
	public function unlockOutIP($IP){
		$this->getDB()->query("delete from " . $this->lockOutTable . " where IP=%s", wfUtils::inet_aton($IP));
	}
	public function isIPLockedOut($IP){
		if($this->getDB()->querySingle("select IP from " . $this->lockOutTable . " where IP=%s and blockedTime + %s > unix_timestamp()", wfUtils::inet_aton($IP), wfConfig::get('loginSec_lockoutMins') * 60)){
			$this->getDB()->query("update " . $this->lockOutTable . " set blockedHits = blockedHits + 1, lastAttempt = unix_timestamp() where IP=%s", wfUtils::inet_aton($IP));
			return true;
		} else {
			return false;
		}
	}
	public function getThrottledIPs(){
		$res = $this->getDB()->query("select IP, startTime, endTime, timesThrottled, lastReason, unix_timestamp() - startTime as startTimeAgo, unix_timestamp() - endTime as endTimeAgo from " . $this->throttleTable . " order by endTime desc limit 50");
		$results = array();
		while($elem = mysql_fetch_assoc($res)){			
			$elem['startTimeAgo'] = wfUtils::makeTimeAgo($elem['startTimeAgo']);
			$elem['endTimeAgo'] = wfUtils::makeTimeAgo($elem['endTimeAgo']);
			array_push($results, $elem);
		}
		$this->resolveIPs($results);
		foreach($results as &$elem){
			$elem['IP'] = wfUtils::inet_ntoa($elem['IP']);
		}
		return $results;
	}
	public function getLockedOutIPs(){
		$res = $this->getDB()->query("select IP, unix_timestamp() - blockedTime as createdAgo, reason, unix_timestamp() - lastAttempt as lastAttemptAgo, lastAttempt, blockedHits, (blockedTime + %s) - unix_timestamp() as blockedFor from " . $this->lockOutTable . " where blockedTime + %s > unix_timestamp() order by blockedTime desc", wfConfig::get('loginSec_lockoutMins'), wfConfig::get('loginSec_lockoutMins'));
		$results = array();
		while($elem = mysql_fetch_assoc($res)){			
			$elem['lastAttemptAgo'] = $elem['lastAttempt'] ? wfUtils::makeTimeAgo($elem['lastAttemptAgo']) : '';
			$elem['blockedForAgo'] = wfUtils::makeTimeAgo($elem['blockedFor']);
			array_push($results, $elem);
		}
		$this->resolveIPs($results);
		foreach($results as &$elem){
			$elem['IP'] = wfUtils::inet_ntoa($elem['IP']);
		}
		return $results;
	}
	public function getBlockedIPs(){
		$res = $this->getDB()->query("select IP, unix_timestamp() - blockedTime as createdAgo, reason, unix_timestamp() - lastAttempt as lastAttemptAgo, lastAttempt, blockedHits, (blockedTime + %s) - unix_timestamp() as blockedFor, permanent from " . $this->blocksTable . " where (permanent=1 OR (blockedTime + %s > unix_timestamp())) order by blockedTime desc", wfConfig::get('blockedTime'), wfConfig::get('blockedTime'));
		$results = array();
		while($elem = mysql_fetch_assoc($res)){			
			$lastHitAgo = 0;
			$totalHits = 0;
			$lastLeech = $this->getDB()->querySingleRec("select unix_timestamp() as serverTime, max(eMin) * 60 as lastHit, sum(hits) as totalHits from " . $this->leechTable . " where IP=%s", $elem['IP']);
			if($lastLeech){ $totalHits += $lastLeech['totalHits']; $lastHitAgo = $lastLeech['serverTime'] - $lastLeech['lastHit']; }
			$lastScan = $this->getDB()->querySingleRec("select unix_timestamp() as serverTime, max(eMin) * 60 as lastHit, sum(hits) as totalHits from " . $this->scanTable . " where IP=%s", $elem['IP']);
			if($lastScan){ 
				$totalHits += $lastScan['totalHits'];
				$ago = $lastScan['serverTime'] - $lastScan['lastHit']; 
				if($ago < $lastHitAgo){
					$lastHitAgo = $ago;
				}
			}
			$elem['totalHits'] = $totalHits;
			$elem['lastHitAgo'] = $lastHitAgo ? wfUtils::makeTimeAgo($lastHitAgo) : '';
			$elem['lastAttemptAgo'] = $elem['lastAttempt'] ? wfUtils::makeTimeAgo($elem['lastAttemptAgo']) : '';
			$elem['blockedForAgo'] = wfUtils::makeTimeAgo($elem['blockedFor']);
			array_push($results, $elem);
		}
		$this->resolveIPs($results);
		foreach($results as &$elem){
			$elem['blocked'] = 1;
			$elem['IP'] = wfUtils::inet_ntoa($elem['IP']);
		}
		return $results;
	}
	public function getLeechers($type){
		if($type == 'topScanners'){
			$table = $this->scanTable;
		} else if($type == 'topLeechers'){
			$table = $this->leechTable;
		} else {
			wordfence::status(1, 'error', "Invalid type to getLeechers(): $type");
			return false;
		}
		$res = $this->getDB()->query("select IP, sum(hits) as totalHits from $table where eMin > ((unix_timestamp() - 86400) / 60) group by IP order by totalHits desc limit 20");
		$results = array();
		while($elem = mysql_fetch_assoc($res)){			
			array_push($results, $elem);
		}
		$this->resolveIPs($results);
		foreach($results as &$elem){
			$elem['timeAgo'] = wfUtils::makeTimeAgo($this->getDB()->querySingle("select unix_timestamp() - (eMin * 60) from $table where IP=%s", $elem['IP']));
			$elem['blocked'] = $this->getDB()->querySingle("select blockedTime from " . $this->blocksTable . " where IP=%s and ((blockedTime + %s > unix_timestamp()) OR permanent = 1)", $elem['IP'], wfConfig::get('blockedTime'));
			//take action
			$elem['IP'] = wfUtils::inet_ntoa($elem['IP']);
		}
		return $results;
	}
	public function logHit(){
		if(! wfConfig::get('liveTrafficEnabled')){ return; }	
		$headers = array();
		foreach($_SERVER as $h=>$v){
			if(preg_match('/^HTTP_(.+)$/', $h, $matches) ){
				$headers[$matches[1]] = $v;
			}
		}
		$this->getDB()->query("insert into " . $this->hitsTable . " (ctime, is404, isGoogle, IP, userID, newVisit, URL, referer, UA) values (%f, %d, %d, %s, %s, %d, '%s', '%s', '%s')", 
			sprintf('%.6f', microtime(true)),
			(is_404() ? 1 : 0),
			(wfCrawl::isGoogleCrawler() ? 1 : 0),
			wfUtils::inet_aton(wfUtils::getIP()),
			$this->getCurrentUserID(),
			(wordfence::$newVisit ? 1 : 0),
			wfUtils::getRequestedURL(),
			(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''),
			(isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '')
			);
		return $this->getDB()->querySingle("select last_insert_id()");
	}
	public function getHits($hitType /* 'hits' or 'logins' */, $type, $afterTime, $limit = 50, $IP = false){
		$serverTime = $this->getDB()->querySingle("select unix_timestamp()");
		$IPSQL = "";
		if($IP){
			$IPSQL = " and IP=INET_ATON('" . mysql_real_escape_string($IP) . "') ";
		}
		if($hitType == 'hits'){
			if($type == 'hit'){
				$typeSQL = " ";
			} else if($type == 'crawler'){
				$now = time();
				$typeSQL = " and jsRun = 0 and $now - ctime > 30 ";
			} else if($type == 'gCrawler'){
				$typeSQL = " and isGoogle = 1 ";
			} else if($type == '404'){
				$typeSQL = " and is404 = 1 ";
			} else if($type == 'human'){
				$typeSQL = " and jsRun = 1 ";
			} else if($type == 'ruser'){
				$typeSQL = " and userID > 0 ";
			} else {
				wordfence::status(1, 'error', "Invalid log type to wfLog: $type");
				return false;
			}

			$r1 = $this->getDB()->query("select * from " . $this->hitsTable . " where ctime > %f $IPSQL $typeSQL order by ctime desc limit %s", 
				$afterTime,
				$limit
				);

		} else if($hitType == 'logins'){
			$r1 = $this->getDB()->query("select * from " . $this->loginsTable . " where ctime > %f $IPSQL order by ctime desc limit %s", 
				$afterTime,
				$limit
				);

		} else {
			wordfence::status(1, 'error', "getHits got invalid hitType: $hitType");
			return false;
		}
		$results = array();
		while($res = mysql_fetch_assoc($r1)){
			array_push($results, $res);
		}
		$this->resolveIPs($results);
		$ourURL = parse_url(site_url());
		$ourHost = strtolower($ourURL['host']);
		$ourHost = preg_replace('/^www\./i', '', $ourHost);
		$browscap = new wfBrowscap();
		foreach($results as &$res){ 
			$res['type'] = $type;
			$res['timeAgo'] = wfUtils::makeTimeAgo($serverTime - $res['ctime']);
			$res['blocked'] = $this->getDB()->querySingle("select blockedTime from " . $this->blocksTable . " where IP=%s and (permanent = 1 OR (blockedTime + %s > unix_timestamp()))", $res['IP'], wfConfig::get('blockedTime'));
			$res['IP'] = wfUtils::inet_ntoa($res['IP']); 
			$res['extReferer'] = false;
			if($res['referer']){
				$refURL = parse_url($res['referer']);
				if(is_array($refURL) && $refURL['host']){
					$refHost = strtolower(preg_replace('/^www\./i', '', $refURL['host']));
					if($refHost != $ourHost){
						$res['extReferer'] = true;
						//now extract search terms
						$q = false;
						if(preg_match('/(?:google|bing|alltheweb|aol|ask)\./i', $refURL['host'])){
							$q = 'q';
						} else if(stristr($refURL['host'], 'yahoo.')){
							$q = 'p';
						} else if(stristr($refURL['host'], 'baidu.')){
							$q = 'wd';
						}
						if($q){
							$queryVars = array();
							parse_str($refURL['query'], $queryVars);
							if(isset($queryVars[$q])){
								$res['searchTerms'] = $queryVars[$q];
							}
						}
					}
				}
				if($res['extReferer']){
					if ( stristr( $referringPage['host'], 'google.' ) )
					{
						parse_str( $referringPage['query'], $queryVars );
						echo $queryVars['q']; // This is the search term used
					}
				}
			}
			$res['browser'] = false;
			if($res['UA']){
				$b = $browscap->getBrowser($res['UA']);
				if($b){
					$res['browser'] = array(
						'browser' => $b['Browser'],
						'version' => $b['Version'],
						'platform' => $b['Platform'],
						'isMobile' => $b['isMobileDevice'],
						'isCrawler' => $b['Crawler']
						);
				}
			}

						
			if($res['userID']){
				$ud = get_userdata($res['userID']);
				if($ud){
					$res['user'] = array(
						'editLink' => wfUtils::editUserLink($res['userID']),
						'display_name' => $ud->display_name,
						'ID' => $res['userID']
						);
					$res['user']['avatar'] = get_avatar($res['userID'], 16);
				}
			} else {
				$res['user'] = false;
			}
		}
		return $results;
	}
	public function resolveIPs(&$results){
		if(sizeof($results) < 1){ return; }
		$IPs = array();
		foreach($results as &$res){
			if($res['IP']){ //Can also be zero in case of non IP events
				$IPs[] = $res['IP'];
			}
		}
		$IPLocs = wfUtils::getIPsGeo($IPs); //Creates an array with IP as key and data as value

		foreach($results as &$res){
			if(isset($IPLocs[$res['IP']])){
				$res['loc'] = $IPLocs[$res['IP']];
			} else {
				$res['loc'] = false;
			}
		}
	}
	public function logHitOK(){
		if(stristr($_SERVER['REQUEST_URI'], 'wp-admin/admin-ajax.php')){ return false; } //Don't log wordpress ajax requests.
		if(is_admin()){ return false; } //Don't log admin pageviews
		if(preg_match('/WordPress\/' . $this->wp_version . '/i', $_SERVER['HTTP_USER_AGENT'])){ return false; } //Ignore requests generated by WP UA.
		if($userID = get_current_user_id()){
			if(wfConfig::get('liveTraf_ignorePublishers') && (current_user_can('publish_posts') || current_user_can('publish_pages')) ){ return false; } //User is logged in and can publish, so we don't log them. 
			$user = get_userdata($userID);
			if($user){
				if(wfConfig::get('liveTraf_ignoreUsers')){
					foreach(explode(',', wfConfig::get('liveTraf_ignoreUsers')) as $ignoreLogin){
						if($user->user_login == $ignoreLogin){
							return false;
						}
					}
				}
			}
		}
		if(wfConfig::get('liveTraf_ignoreIPs')){
			$IPs = explode(',', wfConfig::get('liveTraf_ignoreIPs'));
			$IP = wfUtils::getIP();
			foreach($IPs as $ignoreIP){
				if($ignoreIP == $IP){
					return false;
				}
			}
		}
		if(wfConfig::get('liveTraf_ignoreUA')){
			if($_SERVER['HTTP_USER_AGENT'] == wfConfig::get('liveTraf_ignoreUA')){
				return false;
			}
		}

		return true;
	}
	private function getDB(){
		if(! $this->db){
			$this->db = new wfDB();
		}
		return $this->db;
	}
	public function firewallBadIPs(){
		$blockedCountries = wfConfig::get('cbl_countries', false);
		$bareRequestURI = wfUtils::extractBareURI($_SERVER['REQUEST_URI']);
		$bareBypassRedirURI = wfUtils::extractBareURI(wfConfig::get('cbl_bypassRedirURL', ''));
		$skipCountryBlocking = false;

		if($bareBypassRedirURI && $bareRequestURI == $bareBypassRedirURI){ //Run this before country blocking because even if the user isn't blocked we need to set the bypass cookie so they can bypass future blocks.
			$bypassRedirDest = wfConfig::get('cbl_bypassRedirDest', '');
			if($bypassRedirDest){
				self::setCBLCookieBypass();
				$this->redirect($bypassRedirDest); //exits
			}
		}
		$bareBypassViewURI = wfUtils::extractBareURI(wfConfig::get('cbl_bypassViewURL', ''));
		if($bareBypassViewURI && $bareBypassViewURI == $bareRequestURI){
			self::setCBLCookieBypass();
			$skipCountryBlocking = true;
		}
			

		if((! $skipCountryBlocking) && $blockedCountries && wfConfig::get('isPaid') && (! self::isCBLBypassCookieSet()) ){
			if(is_user_logged_in() && (! wfConfig::get('cbl_loggedInBlocked', false)) ){ //User is logged in and we're allowing logins
				//Do nothing
			} else if(strpos($_SERVER['REQUEST_URI'], '/wp-login.php') !== false && (! wfConfig::get('cbl_loginFormBlocked', false))  ){ //It's the login form and we're allowing that
				//Do nothing 
			} else {
				if($country = wfUtils::IP2Country(wfUtils::getIP()) ){
					foreach(explode(',', $blockedCountries) as $blocked){
						if(strtoupper($blocked) == strtoupper($country)){ //At this point we know the user has been blocked
							if(wfConfig::get('cbl_action') == 'redir'){
								$redirURL = wfConfig::get('cbl_redirURL');
								if(wfUtils::extractBareURI($redirURL) == $bareRequestURI){ //Is this the URI we want to redirect to, then don't block it
									//Do nothing
								/* Uncomment the following if page components aren't loading for the page we redirect to.
								   Uncommenting is not recommended because it means that anyone from a blocked country
								   can crawl your site by sending the page blocked users are redirected to as the referer for every request.
								   But it's your call.
								} else if(wfUtils::extractBareURI($_SERVER['HTTP_REFERER']) == $redirURL){ //If the referer the page we want to redirect to? Then this might be loading as a component so don't block.
									//Do nothing	
								*/
								} else {
									$this->redirect(wfConfig::get('cbl_redirURL'));
								}
							} else {
								$this->do503(3600, "Access from your area has been temporarily limited for security reasons");
							}
						}
					}
				}
			}
		}

		$IP = wfUtils::inet_aton(wfUtils::getIP());
		if($rec = $this->getDB()->querySingleRec("select blockedTime, reason from " . $this->blocksTable . " where IP=%s and (permanent=1 OR (blockedTime + %s > unix_timestamp()))", $IP, wfConfig::get('blockedTime'))){
			$this->getDB()->query("update " . $this->blocksTable . " set lastAttempt=unix_timestamp(), blockedHits = blockedHits + 1 where IP=%s", $IP);
			$now = $this->getDB()->querySingle("select unix_timestamp()");
			$secsToGo = ($rec['blockedTime'] + wfConfig::get('blockedTime')) - $now;
			$this->do503($secsToGo, $rec['reason']); 
		}
	}
	public function getCBLCookieVal(){
		$val = wfConfig::get('cbl_cookieVal', false);
		if(! $val){
			$val = uniqid();
			wfConfig::set('cbl_cookieVal', $val);
		}
		return $val;
	}
	public function setCBLCookieBypass(){
		@setcookie('wfCBLBypass', self::getCBLCookieVal(), time() + (86400 * 365), '/');
	}
	public function isCBLBypassCookieSet(){
		if(isset($_COOKIE['wfCBLBypass']) && $_COOKIE['wfCBLBypass'] == wfConfig::get('cbl_cookieVal')){
			return true;
		}
		return false;
	}
	private function takeBlockingAction($configVar, $reason){
		if($this->googleSafetyCheckOK()){
			$action = wfConfig::get($configVar . '_action');
			if(! $action){
				//error_log("Wordfence action missing for configVar: $configVar");
				return;
			}
			$secsToGo = 0;
			if($action == 'block'){
				$IP = wfUtils::getIP();
				if(wfConfig::get('alertOn_block')){
					wordfence::alert("Blocking IP $IP", "Wordfence has blocked IP address $IP.\nThe reason is: \"$reason\".", $IP);
				}
				wordfence::status(2, 'info', "Blocking IP $IP. $reason");
				$this->blockIP($IP, $reason);
				$secsToGo = wfConfig::get('blockedTime');
			} else if($action == 'throttle'){
				$IP = wfUtils::inet_aton(wfUtils::getIP());
				$this->getDB()->query("insert into " . $this->throttleTable . " (IP, startTime, endTime, timesThrottled, lastReason) values (%s, unix_timestamp(), unix_timestamp(), 1, '%s') ON DUPLICATE KEY UPDATE endTime=unix_timestamp(), timesThrottled = timesThrottled + 1, lastReason='%s'", $IP, $reason, $reason);
				wordfence::status(2, 'info', "Throttling IP $IP. $reason");
				$secsToGo = 60;
			}
			$this->do503($secsToGo, $reason);
		} else {
			return;
		}
	}
	private function do503($secsToGo, $reason){
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Status: 503 Service Temporarily Unavailable');
		if($secsToGo){
			header('Retry-After: ' . $secsToGo);
		}
		require_once('wf503.php');
		exit();
	}
	private function redirect($URL){
		wp_redirect($URL, 302);
		exit();
	}
	private function googleSafetyCheckOK(){ //returns true if OK to block. Returns false if we must not block.
		$cacheKey = md5($_SERVER['HTTP_USER_AGENT'] . ' ' . wfUtils::getIP());
		//Cache so we can call this multiple times in one request
		if(! isset(self::$gbSafeCache[$cacheKey])){
			$nb = wfConfig::get('neverBlockBG');
			if($nb == 'treatAsOtherCrawlers'){
				self::$gbSafeCache[$cacheKey] = true; //OK to block because we're treating google like everyone else
			} else if($nb == 'neverBlockUA' || $nb == 'neverBlockVerified'){
				if(wfCrawl::isGoogleCrawler()){ //Check the UA using regex
					if($nb == 'neverBlockVerified'){
						if(wfCrawl::isGooglebot()){ //UA is the one, the only, the original Googlebot
							if(wfCrawl::verifyCrawlerPTR($this->googlePattern, wfUtils::getIP())){ //UA check passed, now verify using PTR if configured to
								self::$gbSafeCache[$cacheKey] = false; //This is a verified Google crawler, so no we can't block it
							} else {
								self::$gbSafeCache[$cacheKey] = true; //This is a crawler claiming to be Google but it did not verify
							}
						} else { //UA isGoogleCrawler, but is not Googlebot itself. E.g. feedreader, google-site-verification, etc.
							self::$gbSafeCache[$cacheKey] = false; //This is a crawler with a google UA, but it's not Googlebot, so we don't block for safety. We can't verify these because they don't have a PTR record. e.g. Feedreader.
						}
							
					} else { //neverBlockUA
						self::$gbSafeCache[$cacheKey] = false; //User configured us to only do a UA check and this claims to be google so don't block
					}
				} else {
					self::$gbSafeCache[$cacheKey] = true; //This isn't a Google UA, so it's OK to block
				}
			} else {
				//error_log("Wordfence error: neverBlockBG option is not set.");
				self::$gbSafeCache[$cacheKey] = false; //Oops the config option is not set. This should never happen because it's set on install. So we return false to indicate it's not OK to block just for safety.
			}
		}
		if(! isset(self::$gbSafeCache[$cacheKey])){
			//error_log("Wordfence assertion fail in googleSafetyCheckOK: cached value is not set.");
			return false; //for safety
		}
		return self::$gbSafeCache[$cacheKey]; //return cached value
	}
	public function addStatus($level, $type, $msg){
		//$msg = '[' . sprintf('%.2f', memory_get_usage(true) / (1024 * 1024)) . '] ' . $msg;
		$this->getDB()->query("insert into " . $this->statusTable . " (ctime, level, type, msg) values (%s, %d, '%s', '%s')", sprintf('%.6f', microtime(true)), $level, $type, $msg);
	}
	public function getStatusEvents($lastCtime){
		if($lastCtime < 1){
			$lastCtime = $this->getDB()->querySingle("select ctime from " . $this->statusTable . " order by ctime desc limit 1000,1");
			if(! $lastCtime){
				$lastCtime = 0;
			}
		}
		$res = $this->getDB()->query("select ctime, level, type, msg from " . $this->statusTable . " where ctime > %f order by ctime asc", $lastCtime);
		$results = array();
		$lastTime = false;
		$timeOffset = 3600 * get_option('gmt_offset');
		while($rec = mysql_fetch_assoc($res)){
			//$rec['timeAgo'] = wfUtils::makeTimeAgo(time() - $rec['ctime']);
			$rec['date'] = date('M d H:i:s', $rec['ctime'] + $timeOffset);
			array_push($results, $rec);
		}
		return $results;
	}
	public function getSummaryEvents(){
		$res = $this->getDB()->query("select ctime, level, type, msg from " . $this->statusTable . " where level = 10 order by ctime desc limit 100");
		$results = array();
		$lastTime = false;
		$timeOffset = 3600 * get_option('gmt_offset');
		while($rec = mysql_fetch_assoc($res)){
			$rec['date'] = date('M d H:i:s', $rec['ctime'] + $timeOffset);
			array_push($results, $rec);
			if(strpos($rec['msg'], 'SUM_PREP:') === 0){
				break;
			}
		}
		return array_reverse($results);
	}

}

?>
