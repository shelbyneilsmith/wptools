<?php
require_once('wfConfig.php');
require_once('wfCountryMap.php');
class wfUtils {
	private static $isWindows = false;
	public static $scanLockFH = false;
	private static $lastErrorReporting = false;
	private static $lastDisplayErrors = false;
	public static function makeTimeAgo($secs, $noSeconds = false) {
		if($secs < 1){
			return "a moment";
		}
		$months = floor($secs / (86400 * 30));
		$days = floor($secs / 86400);
		$hours = floor($secs / 3600);
		$minutes = floor($secs / 60);
		if($months) {
			$days -= $months * 30;
			return self::pluralize($months, 'month', $days, 'day');
		} else if($days) {
			$hours -= $days * 24;
			return self::pluralize($days, 'day', $hours, 'hour');
		} else if($hours) {
			$minutes -= $hours * 60;
			return self::pluralize($hours, 'hour', $minutes, 'min');
		} else if($minutes) {
			$secs -= $minutes * 60;
			return self::pluralize($minutes, 'min');
		} else {
			if($noSeconds){
				return "less than a minute";
			} else {
				return floor($secs) . " secs";
			}
		}
	}
	public static function pluralize($m1, $t1, $m2 = false, $t2 = false) {
		if($m1 != 1) {
			$t1 = $t1 . 's';
		}
		if($m2 != 1) {
			$t2 = $t2 . 's';
		}
		if($m1 && $m2){
			return "$m1 $t1 $m2 $t2";
		} else {
			return "$m1 $t1";
		}
	}
	public static function formatBytes($bytes, $precision = 2) { 
		$units = array('B', 'KB', 'MB', 'GB', 'TB'); 

		$bytes = max($bytes, 0); 
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
		$pow = min($pow, count($units) - 1); 

		// Uncomment one of the following alternatives
		$bytes /= pow(1024, $pow);
		// $bytes /= (1 << (10 * $pow)); 

		return round($bytes, $precision) . ' ' . $units[$pow]; 
	} 
	public static function inet_ntoa($ip){
		$long = 4294967295 - ($ip - 1);
		return long2ip(-$long);
	}
	public static function inet_aton($ip){
		return sprintf("%u", ip2long($ip));
	}
	public static function getBaseURL(){
		return plugins_url() . '/wordfence/';
	}
	public static function getPluginBaseDir(){
		return WP_CONTENT_DIR . '/plugins/';
		//return ABSPATH . 'wp-content/plugins/';
	}
	public static function getIP(){
		$IP = 0;
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
			if(is_array($IP) && isset($IP[0])){ $IP = $IP[0]; } //It seems that some hosts may modify _SERVER vars into arrays.
		}
		if((! preg_match('/(\d+)\.(\d+)\.(\d+)\.(\d+)/', $IP)) && isset($_SERVER['HTTP_X_REAL_IP'])){
			$IP = $_SERVER['HTTP_X_REAL_IP'];
			if(is_array($IP) && isset($IP[0])){ $IP = $IP[0]; } //It seems that some hosts may modify _SERVER vars into arrays.
		}
		if((! preg_match('/(\d+)\.(\d+)\.(\d+)\.(\d+)/', $IP)) && isset($_SERVER['REMOTE_ADDR'])){
			$IP = $_SERVER['REMOTE_ADDR'];
			if(is_array($IP) && isset($IP[0])){ $IP = $IP[0]; } //It seems that some hosts may modify _SERVER vars into arrays.
		}
		if(preg_match('/,/', $IP)){
			$parts = explode(',', $IP); //Some users have "unknown,100.100.100.100" for example so we take the first thing that looks like an IP.
			foreach($parts as $part){
				if(preg_match('/(\d+)\.(\d+)\.(\d+)\.(\d+)/', $part)){
					$IP = trim($part);
					break;
				}
			}
		}
		if(preg_match('/:\d+$/', $IP)){
			$IP = preg_replace('/:\d+$/', '', $IP);
		}
		if(self::isValidIP($IP)){
			return $IP;
		} else {
			$msg = "Wordfence can't get the IP of clients and therefore can't operate. We received IP: $IP. X-Forwarded-For was: " . $_SERVER['HTTP_X_FORWARDED_FOR'] . " REMOTE_ADDR was: " . $_SERVER['REMOTE_ADDR'];
			$possible = array();
			foreach($_SERVER as $key => $val){
				if(is_string($val) && preg_match('/^\d+\.\d+\.\d+\.\d+/', $val) && strlen($val) < 255){
					if($val != '127.0.0.1'){
						$possible[$key] = $val;
					}
				}
			}
			if(sizeof($possible) > 0){
				$msg .= "  Report the following on the Wordfence forums and they may be able to help. Headers that may contain the client IP: ";
				foreach($possible as $key => $val){
					$msg .= "$key => $val   ";
				}
			}
			wordfence::status(1, 'error', $msg);
			return false;
		}
	}
	public static function isValidIP($IP){
		if(preg_match('/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/', $IP, $m)){
			if(
				$m[0] >= 0 && $m[0] <= 255 &&
				$m[1] >= 0 && $m[1] <= 255 &&
				$m[2] >= 0 && $m[2] <= 255 &&
				$m[3] >= 0 && $m[3] <= 255
			){
				return true;
			}
		}
		return false;
	}
	public static function getRequestedURL(){
		return (@$_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	}

	public static function editUserLink($userID){
		return get_admin_url() . 'user-edit.php?user_id=' . $userID;
	}
	public static function tmpl($file, $data){
		extract($data);
		ob_start();
		include $file;
		return ob_get_contents() . (ob_end_clean() ? "" : "");
	}
	public static function bigRandomHex(){
		return dechex(rand(0, 2147483647)) . dechex(rand(0, 2147483647)) . dechex(rand(0, 2147483647));
	}
	public static function encrypt($str){
		$key = wfConfig::get('encKey');
		if(! $key){
			wordfence::status(1, 'error', "Wordfence error: No encryption key found!");
			return false;
		}
		$db = new wfDB();
		return $db->querySingle("select HEX(AES_ENCRYPT('%s', '%s')) as val", $str, $key);
	}
	public static function decrypt($str){
		$key = wfConfig::get('encKey');
		if(! $key){
			wordfence::status(1, 'error', "Wordfence error: No encryption key found!");
			return false;
		}
		$db = new wfDB();
		return $db->querySingle("select AES_DECRYPT(UNHEX('%s'), '%s') as val", $str, $key);
	}
	public static function lcmem(){
		$trace=debug_backtrace(); 
		$caller=array_shift($trace); 
		$c2 = array_shift($trace);
		$mem = memory_get_usage(true);
		error_log("$mem at " . $caller['file'] . " line " . $caller['line']);
	}
	public static function logCaller(){
		$trace=debug_backtrace(); 
		$caller=array_shift($trace); 
		$c2 = array_shift($trace);
		error_log("Caller for " . $caller['file'] . " line " . $caller['line'] . " is " . $c2['file'] . ' line ' . $c2['line']);
	}
	public static function getWPVersion(){
		global $wp_version;
		global $wordfence_wp_version;
		if(isset($wordfence_wp_version)){
			return $wordfence_wp_version;
		} else {
			return $wp_version;
		}
	}
	public static function isAdminPageMU(){
		if(preg_match('/^[\/a-zA-Z0-9\-\_\s\+\~\!\^\.]*\/wp-admin\/network\//', $_SERVER['REQUEST_URI'])){ 
			return true; 
		}
		return false;
	}
	public static function getSiteBaseURL(){
		return rtrim(site_url(), '/') . '/';
	}
	public static function longestLine($data){
		$lines = preg_split('/[\r\n]+/', $data);
		$max = 0;
		foreach($lines as $line){
			$len = strlen($line);
			if($len > $max){
				$max = $len;
			}
		}
		return $max;
	}
	public static function longestNospace($data){
		$lines = preg_split('/[\r\n\s\t]+/', $data);
		$max = 0;
		foreach($lines as $line){
			$len = strlen($line);
			if($len > $max){
				$max = $len;
			}
		}
		return $max;
	}
	public static function requestMaxMemory(){
		if(wfConfig::get('maxMem', false) && (int) wfConfig::get('maxMem') > 0){
			$maxMem = (int) wfConfig::get('maxMem');
		} else {
			$maxMem = 256;
		}
		if( function_exists('memory_get_usage') && ( (int) @ini_get('memory_limit') < $maxMem ) ){
			self::iniSet('memory_limit', $maxMem . 'M');
		}
	}
	public static function isAdmin(){
		if(is_multisite()){
			if(current_user_can('manage_network')){
				return true;
			}
		} else {
			if(current_user_can('manage_options')){
				return true;
			}
		}
		return false;
	}
	public static function isWindows(){
		if(! self::$isWindows){
			if(preg_match('/^win/i', PHP_OS)){
				self::$isWindows = 'yes';
			} else {
				self::$isWindows = 'no';
			}
		}
		return self::$isWindows == 'yes' ? true : false;
	}
	public static function getScanLock(){
		//Windows does not support non-blocking flock, so we use time. 
		$scanRunning = wfConfig::get('wf_scanRunning');
		if($scanRunning && time() - $scanRunning < WORDFENCE_MAX_SCAN_TIME){
			return false;
		}
		wfConfig::set('wf_scanRunning', time());
		return true;
	}
	public static function clearScanLock(){
		wfConfig::set('wf_scanRunning', '');
	}
	public static function isScanRunning(){
		$scanRunning = wfConfig::get('wf_scanRunning');
		if($scanRunning && time() - $scanRunning < WORDFENCE_MAX_SCAN_TIME){
			return true;
		} else {
			return false;
		}
	}
	public static function getIPGeo($IP){ //Works with int or dotted
		
		$locs = self::getIPsGeo(array($IP));
		if(isset($locs[$IP])){
			return $locs[$IP];
		} else {
			return false;
		}
	}
	public static function getIPsGeo($IPs){ //works with int or dotted. Outputs same format it receives.
		$IPs = array_unique($IPs);
		$isInt = false;
		if(strpos($IPs[0], '.') === false){
			$isInt = true;
		}
		$toResolve = array();
		$db = new wfDB();
		global $wp_version;
		global $wpdb;
		$locsTable = $wpdb->base_prefix . 'wfLocs';
		$IPLocs = array();
		foreach($IPs as $IP){
			$r1 = $db->query("select IP, ctime, failed, city, region, countryName, countryCode, lat, lon, unix_timestamp() - ctime as age from " . $locsTable . " where IP=%s", ($isInt ? $IP : self::inet_aton($IP)) );
			if($r1){
				if($row = mysql_fetch_assoc($r1)){
					if($row['age'] > WORDFENCE_MAX_IPLOC_AGE){
						$db->query("delete from " . $locsTable . " where IP=%s", $row['IP']);
					} else {
						if($row['failed'] == 1){
							$IPLocs[$IP] = false;
						} else {
							if(! $isInt){
								$row['IP'] = self::inet_ntoa($row['IP']);
							}
							$IPLocs[$IP] = $row;
						}
					}
				}
			}
			if(! isset($IPLocs[$IP])){
				$toResolve[] = $IP;
			}
		}
		if(sizeof($toResolve) > 0){
			$api = new wfAPI(wfConfig::get('apiKey'), $wp_version); 
			try {
				$freshIPs = $api->call('resolve_ips', array(), array(
					'ips' => implode(',', $toResolve)
					));
				if(is_array($freshIPs)){
					foreach($freshIPs as $IP => $value){
						if($value == 'failed'){
							$db->query("insert IGNORE into " . $locsTable . " (IP, ctime, failed) values (%s, unix_timestamp(), 1)", ($isInt ? $IP : self::inet_aton($IP)) );
							$IPLocs[$IP] = false;
						} else {
							$db->query("insert IGNORE into " . $locsTable . " (IP, ctime, failed, city, region, countryName, countryCode, lat, lon) values (%s, unix_timestamp(), 0, '%s', '%s', '%s', '%s', %s, %s)", 
								($isInt ? $IP : self::inet_aton($IP)),
								$value[3], //city
								$value[2], //region
								$value[1], //countryName
								$value[0],//countryCode
								$value[4],//lat
								$value[5]//lon
								);
							$IPLocs[$IP] = array(
								'IP' => $IP,
								'city' => $value[3],
								'region' => $value[2],
								'countryName' => $value[1],
								'countryCode' => $value[0],
								'lat' => $value[4],
								'lon' => $value[5]
								);
						}
					}
				}
			} catch(Exception $e){
				wordfence::status(2, 'error', "Call to Wordfence API to resolve IPs failed: " . $e->getMessage());
				return array();
			}
		}
		return $IPLocs;
	}
	public function reverseLookup($IP){
		$db = new wfDB();
		global $wpdb;
		$reverseTable = $wpdb->base_prefix . 'wfReverseCache';
		$IPn = wfUtils::inet_aton($IP);
		$host = $db->querySingle("select host from " . $reverseTable . " where IP=%s and unix_timestamp() - lastUpdate < %d", $IPn, WORDFENCE_REVERSE_LOOKUP_CACHE_TIME);
		if(! $host){
			$ptr = implode(".", array_reverse(explode(".",$IP))) . ".in-addr.arpa";
			$host = @dns_get_record($ptr, DNS_PTR);
			if($host == null){
				$host = 'NONE';
			} else {
				$host = $host[0]['target'];
			}
			$db->query("insert into " . $reverseTable . " (IP, host, lastUpdate) values (%s, '%s', unix_timestamp()) ON DUPLICATE KEY UPDATE host='%s', lastUpdate=unix_timestamp()", $IPn, $host, $host);
		}
		if($host == 'NONE'){
			return '';
		} else {
			return $host;
		}
	}
	public static function errorsOff(){
		self::$lastErrorReporting = @ini_get('error_reporting');
		@error_reporting(0);
		self::$lastDisplayErrors = @ini_get('display_errors');
		self::iniSet('display_errors', 0);
		if(class_exists('wfScan')){ wfScan::$errorHandlingOn = false; }
	}
	public static function errorsOn(){
		@error_reporting(self::$lastErrorReporting);
		self::iniSet('display_errors', self::$lastDisplayErrors);
		if(class_exists('wfScan')){ wfScan::$errorHandlingOn = true; }
	}
	public static function fileTooBig($file){ //Deals with files > 2 gigs on 32 bit systems which are reported with the wrong size due to integer overflow
		wfUtils::errorsOff();
		$fh = @fopen($file, 'r');
		wfUtils::errorsOn();
		if(! $fh){ return false; }
		$offset = WORDFENCE_MAX_FILE_SIZE_TO_PROCESS + 1; 
		$tooBig = false;
		if(fseek($fh, $offset, SEEK_SET) === 0){
			if(strlen(fread($fh, 1)) === 1){
				$tooBig = true;
			}
		} //Otherwise we couldn't seek there so it must be smaller
		fclose($fh);
		return $tooBig;
	}
	public static function fileOver2Gigs($file){
		$fh = @fopen($file, 'r');
		if(! $fh){ return false; }
		$offset = 2147483647; 
		$tooBig = false;
		if(fseek($fh, $offset, SEEK_SET) === 0){
			if(strlen(fread($fh, 1)) === 1){
				$tooBig = true;
			}
		} //Otherwise we couldn't seek there so it must be smaller
		fclose($fh);
		return $tooBig;
	}
	public static function countryCode2Name($code){
		if(isset(wfCountryMap::$map[$code])){
			return wfCountryMap::$map[$code];
		} else {
			return '';
		}
	}
	public static function extractBareURI($URL){
		$URL = preg_replace('/^https?:\/\/[^\/]+/i', '', $URL); //strip of method and host
		$URL = preg_replace('/\#.*$/', '', $URL); //strip off fragment
		$URL = preg_replace('/\?.*$/', '', $URL); //strip off query string
		return $URL;
	}
	public static function IP2Country($IP){
		if(! (function_exists('geoip_open') && function_exists('geoip_country_code_by_addr'))){
			require_once('wfGeoIP.php');
		}
		$gi = geoip_open(dirname(__FILE__) . "/GeoIP.dat",GEOIP_STANDARD);
		$country = geoip_country_code_by_addr($gi, $IP);
		geoip_close($gi);
		return $country ? $country : '';
	}
	public static function siteURLRelative(){
		if(is_multisite()){
			$URL = network_site_url();
		} else {
			$URL = site_url();
		}
		$URL = preg_replace('/^https?:\/\/[^\/]+/i', '', $URL);
		$URL = rtrim($URL, '/') . '/';
		return $URL;
	}
	public static function localHumanDate(){
		return date('l jS \of F Y \a\t h:i:s A', time() + (3600 * get_option('gmt_offset')));
	}
	public static function funcEnabled($func){
		if(! function_exists($func)){ return false; }
		$disabled = explode(',', ini_get('disable_functions'));
		foreach($disabled as $f){
			if($func == $f){ return false; }
		}
		return true;
	}
	public static function iniSet($key, $val){
		if(self::funcEnabled('ini_set')){
			@ini_set($key, $val);
		}
	}
}


?>
