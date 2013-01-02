<?php
class wfConfig {
	private static $table = false;
	private static $cache = array();
	private static $DB = false;
	private static $tmpFileHeader = "<?php\n/* Wordfence temporary file security header */\necho \"Nothing to see here!\\n\"; exit(0);\n?>";
	private static $tmpDirCache = false;
	public static $securityLevels = array(
		array( //level 0
			"checkboxes" => array(
				"alertOn_critical" => false,
				"alertOn_warnings" => false,
				"alertOn_throttle" => false,
				"alertOn_block" => false,
				"alertOn_loginLockout" => false,
				"alertOn_lostPasswdForm" => false,
				"alertOn_adminLogin" => false,
				"alertOn_nonAdminLogin" => false,
				"liveTrafficEnabled" => true,
				"liveTraf_ignorePublishers" => true,
				"scheduledScansEnabled" => false,
				"scansEnabled_public" => false,
				"scansEnabled_core" => false,
				"scansEnabled_themes" => false,
				"scansEnabled_plugins" => false,
				"scansEnabled_malware" => false,
				"scansEnabled_fileContents" => false,
				"scansEnabled_posts" => false,
				"scansEnabled_comments" => false,
				"scansEnabled_passwds" => false,
				"scansEnabled_diskSpace" => false,
				"scansEnabled_dns" => false,
				"scansEnabled_oldVersions" => false,
				"firewallEnabled" => false,
				"blockFakeBots" => false,
				"autoBlockScanners" => false,
				"loginSecurityEnabled" => false,
				"loginSec_lockInvalidUsers" => false,
				"loginSec_maskLoginErrors" => false,
				"other_hideWPVersion" => false,
				"other_noAnonMemberComments" => false,
				"other_scanComments" => false,
				"other_pwStrengthOnUpdate" => false,
				"other_WFNet" => true,
				"other_scanOutside" => false,
				"deleteTablesOnDeact" => false,
				"debugOn" => false
			),
			"otherParams" => array(
				'securityLevel' => '0',
				"alertEmails" => "", "liveTraf_ignoreUsers" => "", "liveTraf_ignoreIPs" => "", "liveTraf_ignoreUA" => "", "apiKey" => "", "maxMem" => '256', 'whitelisted' => '',
				"neverBlockBG" => "neverBlockVerified",
				"loginSec_countFailMins" => "5",
				"loginSec_lockoutMins" => "5",
				'loginSec_maxFailures' => "500",
				'loginSec_maxForgotPasswd' => "500",
				'maxGlobalRequests' => "DISABLED",
				'maxGlobalRequests_action' => "throttle",
				'maxRequestsCrawlers' => "DISABLED",
				'maxRequestsCrawlers_action' => "throttle",
				'maxRequestsHumans' => "DISABLED",
				'maxRequestsHumans_action' => "throttle",
				'max404Crawlers' => "DISABLED",
				'max404Crawlers_action' => "throttle",
				'max404Humans' => "DISABLED",
				'max404Humans_action' => "throttle",
				'maxScanHits' => "DISABLED",
				'maxScanHits_action' => "throttle",
				'blockedTime' => "300"
			)
		),
		array( //level 1
			"checkboxes" => array(
				"alertOn_critical" => true,
				"alertOn_warnings" => false,
				"alertOn_throttle" => false,
				"alertOn_block" => false,
				"alertOn_loginLockout" => false,
				"alertOn_lostPasswdForm" => false,
				"alertOn_adminLogin" => false,
				"alertOn_nonAdminLogin" => false,
				"liveTrafficEnabled" => true,
				"liveTraf_ignorePublishers" => true,
				"scheduledScansEnabled" => true,
				"scansEnabled_public" => false,
				"scansEnabled_core" => true,
				"scansEnabled_themes" => false,
				"scansEnabled_plugins" => false,
				"scansEnabled_malware" => true,
				"scansEnabled_fileContents" => true,
				"scansEnabled_posts" => true,
				"scansEnabled_comments" => true,
				"scansEnabled_passwds" => true,
				"scansEnabled_diskSpace" => true,
				"scansEnabled_dns" => true,
				"scansEnabled_oldVersions" => true,
				"firewallEnabled" => false,
				"blockFakeBots" => false,
				"autoBlockScanners" => true,
				"loginSecurityEnabled" => true,
				"loginSec_lockInvalidUsers" => false,
				"loginSec_maskLoginErrors" => true,
				"other_hideWPVersion" => true,
				"other_noAnonMemberComments" => true,
				"other_scanComments" => true,
				"other_pwStrengthOnUpdate" => true,
				"other_WFNet" => true,
				"other_scanOutside" => false,
				"deleteTablesOnDeact" => false,
				"debugOn" => false
			),
			"otherParams" => array(
				'securityLevel' => '1',
				"alertEmails" => "", "liveTraf_ignoreUsers" => "", "liveTraf_ignoreIPs" => "", "liveTraf_ignoreUA" => "",  "apiKey" => "", "maxMem" => '256', 'whitelisted' => '',
				"neverBlockBG" => "neverBlockVerified",
				"loginSec_countFailMins" => "5",
				"loginSec_lockoutMins" => "5",
				'loginSec_maxFailures' => "50",
				'loginSec_maxForgotPasswd' => "50",
				'maxGlobalRequests' => "DISABLED",
				'maxGlobalRequests_action' => "throttle",
				'maxRequestsCrawlers' => "DISABLED",
				'maxRequestsCrawlers_action' => "throttle",
				'maxRequestsHumans' => "DISABLED",
				'maxRequestsHumans_action' => "throttle",
				'max404Crawlers' => "DISABLED",
				'max404Crawlers_action' => "throttle",
				'max404Humans' => "DISABLED",
				'max404Humans_action' => "throttle",
				'maxScanHits' => "DISABLED",
				'maxScanHits_action' => "throttle",
				'blockedTime' => "300"
			)
		),
		array( //level 2
			"checkboxes" => array(
				"alertOn_critical" => true,
				"alertOn_warnings" => true,
				"alertOn_throttle" => false,
				"alertOn_block" => false,
				"alertOn_loginLockout" => false,
				"alertOn_lostPasswdForm" => false,
				"alertOn_adminLogin" => false,
				"alertOn_nonAdminLogin" => false,
				"liveTrafficEnabled" => true,
				"liveTraf_ignorePublishers" => true,
				"scheduledScansEnabled" => true,
				"scansEnabled_public" => false,
				"scansEnabled_core" => true,
				"scansEnabled_themes" => false,
				"scansEnabled_plugins" => false,
				"scansEnabled_malware" => true,
				"scansEnabled_fileContents" => true,
				"scansEnabled_posts" => true,
				"scansEnabled_comments" => true,
				"scansEnabled_passwds" => true,
				"scansEnabled_diskSpace" => true,
				"scansEnabled_dns" => true,
				"scansEnabled_oldVersions" => true,
				"firewallEnabled" => false,
				"blockFakeBots" => false,
				"autoBlockScanners" => true,
				"loginSecurityEnabled" => true,
				"loginSec_lockInvalidUsers" => false,
				"loginSec_maskLoginErrors" => true,
				"other_hideWPVersion" => true,
				"other_noAnonMemberComments" => true,
				"other_scanComments" => true,
				"other_pwStrengthOnUpdate" => true,
				"other_WFNet" => true,
				"other_scanOutside" => false,
				"deleteTablesOnDeact" => false,
				"debugOn" => false
			),
			"otherParams" => array(
				'securityLevel' => '2',
				"alertEmails" => "", "liveTraf_ignoreUsers" => "", "liveTraf_ignoreIPs" => "", "liveTraf_ignoreUA" => "",  "apiKey" => "", "maxMem" => '256', 'whitelisted' => '',
				"neverBlockBG" => "neverBlockVerified",
				"loginSec_countFailMins" => "240",
				"loginSec_lockoutMins" => "240",
				'loginSec_maxFailures' => "20",
				'loginSec_maxForgotPasswd' => "20",
				'maxGlobalRequests' => "DISABLED",
				'maxGlobalRequests_action' => "throttle",
				'maxRequestsCrawlers' => "DISABLED",
				'maxRequestsCrawlers_action' => "throttle",
				'maxRequestsHumans' => "DISABLED",
				'maxRequestsHumans_action' => "throttle",
				'max404Crawlers' => "DISABLED",
				'max404Crawlers_action' => "throttle",
				'max404Humans' => "DISABLED",
				'max404Humans_action' => "throttle",
				'maxScanHits' => "DISABLED",
				'maxScanHits_action' => "throttle",
				'blockedTime' => "300"
			)
		),
		array( //level 3
			"checkboxes" => array(
				"alertOn_critical" => true,
				"alertOn_warnings" => true,
				"alertOn_throttle" => false,
				"alertOn_block" => false,
				"alertOn_loginLockout" => false,
				"alertOn_lostPasswdForm" => false,
				"alertOn_adminLogin" => false,
				"alertOn_nonAdminLogin" => false,
				"liveTrafficEnabled" => true,
				"liveTraf_ignorePublishers" => true,
				"scheduledScansEnabled" => true,
				"scansEnabled_public" => false,
				"scansEnabled_core" => true,
				"scansEnabled_themes" => false,
				"scansEnabled_plugins" => false,
				"scansEnabled_malware" => true,
				"scansEnabled_fileContents" => true,
				"scansEnabled_posts" => true,
				"scansEnabled_comments" => true,
				"scansEnabled_passwds" => true,
				"scansEnabled_diskSpace" => true,
				"scansEnabled_dns" => true,
				"scansEnabled_oldVersions" => true,
				"firewallEnabled" => true,
				"blockFakeBots" => false,
				"autoBlockScanners" => true,
				"loginSecurityEnabled" => true,
				"loginSec_lockInvalidUsers" => false,
				"loginSec_maskLoginErrors" => true,
				"other_hideWPVersion" => true,
				"other_noAnonMemberComments" => true,
				"other_scanComments" => true,
				"other_pwStrengthOnUpdate" => true,
				"other_WFNet" => true,
				"other_scanOutside" => false,
				"deleteTablesOnDeact" => false,
				"debugOn" => false
			),
			"otherParams" => array(
				'securityLevel' => '3',
				"alertEmails" => "", "liveTraf_ignoreUsers" => "", "liveTraf_ignoreIPs" => "", "liveTraf_ignoreUA" => "",  "apiKey" => "", "maxMem" => '256', 'whitelisted' => '',
				"neverBlockBG" => "neverBlockVerified",
				"loginSec_countFailMins" => "1440",
				"loginSec_lockoutMins" => "1440",
				'loginSec_maxFailures' => "10",
				'loginSec_maxForgotPasswd' => "10",
				'maxGlobalRequests' => "960",
				'maxGlobalRequests_action' => "throttle",
				'maxRequestsCrawlers' => "960",
				'maxRequestsCrawlers_action' => "throttle",
				'maxRequestsHumans' => "60",
				'maxRequestsHumans_action' => "throttle",
				'max404Crawlers' => "60",
				'max404Crawlers_action' => "throttle",
				'max404Humans' => "60",
				'max404Humans_action' => "throttle",
				'maxScanHits' => "30",
				'maxScanHits_action' => "throttle",
				'blockedTime' => "1800"
			)
		),
		array( //level 4
			"checkboxes" => array(
				"alertOn_critical" => true,
				"alertOn_warnings" => true,
				"alertOn_throttle" => false,
				"alertOn_block" => false,
				"alertOn_loginLockout" => false,
				"alertOn_lostPasswdForm" => false,
				"alertOn_adminLogin" => false,
				"alertOn_nonAdminLogin" => false,
				"liveTrafficEnabled" => true,
				"liveTraf_ignorePublishers" => true,
				"scheduledScansEnabled" => true,
				"scansEnabled_public" => false,
				"scansEnabled_core" => true,
				"scansEnabled_themes" => false,
				"scansEnabled_plugins" => false,
				"scansEnabled_malware" => true,
				"scansEnabled_fileContents" => true,
				"scansEnabled_posts" => true,
				"scansEnabled_comments" => true,
				"scansEnabled_passwds" => true,
				"scansEnabled_diskSpace" => true,
				"scansEnabled_dns" => true,
				"scansEnabled_oldVersions" => true,
				"firewallEnabled" => true,
				"blockFakeBots" => true,
				"autoBlockScanners" => true,
				"loginSecurityEnabled" => true,
				"loginSec_lockInvalidUsers" => true,
				"loginSec_maskLoginErrors" => true,
				"other_hideWPVersion" => true,
				"other_noAnonMemberComments" => true,
				"other_scanComments" => true,
				"other_pwStrengthOnUpdate" => true,
				"other_WFNet" => true,
				"other_scanOutside" => false,
				"deleteTablesOnDeact" => false,
				"debugOn" => false
			),
			"otherParams" => array(
				'securityLevel' => '4',
				"alertEmails" => "", "liveTraf_ignoreUsers" => "", "liveTraf_ignoreIPs" => "", "liveTraf_ignoreUA" => "",  "apiKey" => "", "maxMem" => '256', 'whitelisted' => '',
				"neverBlockBG" => "neverBlockVerified",
				"loginSec_countFailMins" => "1440",
				"loginSec_lockoutMins" => "1440",
				'loginSec_maxFailures' => "5",
				'loginSec_maxForgotPasswd' => "5",
				'maxGlobalRequests' => "960",
				'maxGlobalRequests_action' => "throttle",
				'maxRequestsCrawlers' => "960",
				'maxRequestsCrawlers_action' => "throttle",
				'maxRequestsHumans' => "30",
				'maxRequestsHumans_action' => "block",
				'max404Crawlers' => "30",
				'max404Crawlers_action' => "block",
				'max404Humans' => "60",
				'max404Humans_action' => "block",
				'maxScanHits' => "10",
				'maxScanHits_action' => "block",
				'blockedTime' => "7200"
			)
		)
	);
	public static function setDefaults(){
		foreach(self::$securityLevels[2]['checkboxes'] as $key => $val){
			if(self::get($key) === false){
				self::set($key, $val ? '1' : '0');
			}
		}
		foreach(self::$securityLevels[2]['otherParams'] as $key => $val){
			if(self::get($key) === false){
				self::set($key, $val);
			}
		}
		self::set('encKey', substr(wfUtils::bigRandomHex(),0 ,16) );
		if(self::get('maxMem', false) === false ){
			self::set('maxMem', '256');
		}
		if(self::get('other_scanOutside', false) === false){
			self::set('other_scanOutside', 0);
		}
	}
	public static function parseOptions(){
		$ret = array();
		foreach(self::$securityLevels[2]['checkboxes'] as $key => $val){ //value is not used. We just need the keys for validation
			$ret[$key] = isset($_POST[$key]) ? '1' : '0';
		}
		foreach(self::$securityLevels[2]['otherParams'] as $key => $val){
			if(isset($_POST[$key])){
				$ret[$key] = $_POST[$key];
			} else {
				error_log("Missing options param \"$key\" when parsing parameters.");
			}
		}
		/* for debugging only:
		foreach($_POST as $key => $val){
			if($key != 'action' && $key != 'nonce' && (! array_key_exists($key, self::$checkboxes)) && (! array_key_exists($key, self::$otherParams)) ){
				error_log("Unrecognized option: $key");
			}
		}
		*/
		return $ret;
	}
	public static function setArray($arr){
		foreach($arr as $key => $val){
			self::set($key, $val);
		}
	}
	public static function clearCache(){
		self::$cache = array();
	}
	public static function getHTML($key){
		return htmlspecialchars(self::get($key));
	}
	public static function set($key, $val){
		if(is_array($val)){
			$msg = "wfConfig::set() got an array as second param with key: $key and value: " . var_export($val, true);
			wordfence::status(1, 'error', $msg);
			return;
		}

		self::getDB()->query("insert into " . self::table() . " (name, val) values ('%s', '%s') ON DUPLICATE KEY UPDATE val='%s'", $key, $val, $val);
		self::$cache[$key] = $val;
	}
	public static function get($key, $default = false){
		if(! isset(self::$cache[$key])){ 
			$val = self::getDB()->querySingle("select val from " . self::table() . " where name='%s'", $key);
			if(isset($val)){
				self::$cache[$key] = $val;
			} else {
				self::$cache[$key] = $default;
			}
		}
		return self::$cache[$key];
	}
	public static function get_ser($key, $default, $canUseDisk = false){ //When using disk, reading a value deletes it.
		//If we can use disk, check if there are any values stored on disk first and read them instead of the DB if there are values
		if($canUseDisk){
			$filename = 'wordfence_tmpfile_' . $key . '.php';
			$dir = self::getTempDir();
			if($dir){
				$obj = false;
				$foundFiles = false;
				$fullFile = $dir . $filename;
				if(file_exists($fullFile)){
					wordfence::status(4, 'info', "Loading serialized data from file $fullFile");
					$obj = unserialize(substr(file_get_contents($fullFile), strlen(self::$tmpFileHeader))); //Strip off security header and unserialize
					if(! $obj){
						wordfence::status(2, 'error', "Could not unserialize file $fullFile");
					}
					self::deleteOldTempFile($fullFile);
				}
				if($obj){ //If we managed to deserialize something, clean ALL tmp dirs of this file and return obj
					return $obj;
				}
			}
		}
		self::getDB()->reconnect();
		//We do our own query handling here because we are dealing with some very big strings
		$dbh = self::getDB()->getDBH();
		$res = mysql_query("select val from " . self::table() . " where name='" . mysql_real_escape_string($key) . "'", $dbh);
		$err = mysql_error();
		if($err){
			$trace=debug_backtrace(); 
			$caller=array_shift($trace); 
			wordfence::status(2, 'error', "Wordfence DB error in " . $caller['file'] . " line " . $caller['line'] . ": $err");
			return false;
		}

		if(mysql_num_rows($res) > 0){
			$row = mysql_fetch_row($res);
			return unserialize($row[0]);
		}
		return $default;
	}
	public static function set_ser($key, $val, $canUseDisk = false){
		//We serialize some very big values so this is ultra-memory efficient. We don't make any copies of $val and don't use ON DUPLICATE KEY UPDATE
		// because we would have to concatenate $val twice into the query which could also exceed max packet for the mysql server
		self::getDB()->reconnect();
		$dbh = self::getDB()->getDBH();
		$serialized = serialize($val);
		$tempFilename = 'wordfence_tmpfile_' . $key . '.php';
		if((strlen($serialized) * 1.1) > self::getDB()->getMaxAllowedPacketBytes()){ //If it's greater than max_allowed_packet + 10% for escaping and SQL
			if($canUseDisk){
				$dir = self::getTempDir();					
				if($dir){
					$fh = false;
					$fullFile = $dir . $tempFilename;
					self::deleteOldTempFile($fullFile);
					$fh = fopen($fullFile, 'w');
					if($fh){ 
						wordfence::status(4, 'info', "Serialized data for $key is " . strlen($serialized) . " bytes and is greater than max_allowed packet so writing it to disk file: " . $fullFile);
					} else {
						wordfence::status(1, 'error', "Your database doesn't allow big packets so we have to use files to store temporary data and Wordfence can't find a place to write them. Either ask your admin to increase max_allowed_packet on your MySQL database, or make one of the following directories writable by your web server: " . implode(', ', $dirs));
						return false;
					}
					fwrite($fh, self::$tmpFileHeader);
					fwrite($fh, $serialized);
					fclose($fh);
					return true;
				} else {
					wordfence::status(1, 'error', "Wordfence tried to save a variable with name '$key' and your database max_allowed_packet is set to be too small. We then tried to save it to disk, but you don't have a temporary directory that is writable. You can fix this by making the /wp-content/plugins/wordfence/tmp/ directory writable by your web server. Or by increasing your max_allowed_packet configuration variable in your mysql database.");
					return false;
				}
					
			} else {
				wordfence::status(1, 'error', "Wordfence tried to save a variable with name '$key' and your database max_allowed_packet is set to be too small. This particular variable can't be saved to disk. Please ask your administrator to increase max_allowed_packet and also report this in the Wordfence forums because it may be a bug. Thanks.");
				return false;
			}
		} else {
			//Delete temp files on disk or else the DB will be written to but get_ser will see files on disk and read them instead
			$tempDir = self::getTempDir();
			if($tempDir){
				self::deleteOldTempFile($tempDir . $tempFilename);
			}
			$exists = self::getDB()->querySingle("select name from " . self::table() . " where name='%s'", $key);
			if($exists){
				$res = mysql_query("update " . self::table() . " set val='" . mysql_real_escape_string($serialized) . "' where name='" . mysql_real_escape_string($key) . "'", $dbh);
			} else {
				$res = mysql_query("insert IGNORE into " . self::table() . " (name, val) values ('" . mysql_real_escape_string($key) . "', '" . mysql_real_escape_string($serialized) . "')", $dbh);
			}
			$err = mysql_error();
			if($err){
				$trace=debug_backtrace(); 
				$caller=array_shift($trace); 
				wordfence::status(2, 'error', "Wordfence DB error in " . $caller['file'] . " line " . $caller['line'] . ": $err");
				return false;
			}
		}
		return true;
	}
	private static function deleteOldTempFile($filename){
		if(file_exists($filename)){
			unlink($filename);
		}
	}
	private static function getTempDir(){
		if(! self::$tmpDirCache){
			$dirs = array(wfUtils::getPluginBaseDir() . 'wordfence/tmp/', sys_get_temp_dir(), ABSPATH . 'wp-content/uploads/');
			$finalDir = 'notmp';
			wfUtils::errorsOff();
			foreach($dirs as $dir){
				$dir = rtrim($dir, '/') . '/';
				$fh = @fopen($dir . 'wftmptest.txt', 'w');
				if(! $fh){ continue; }
				$bytes = @fwrite($fh, 'test');
				if($bytes != 4){ @fclose($fh); continue; }
				@fclose($fh);
				if(! @unlink($dir . 'wftmptest.txt')){ continue; }
				$finalDir = $dir;
				break;
			}
			wfUtils::errorsOn();
			self::$tmpDirCache = $finalDir;
		}
		if(self::$tmpDirCache == 'notmp'){
			return false;
		} else {
			return self::$tmpDirCache;
		}
	}
	public static function f($key){
		echo esc_attr(self::get($key));
	}
	public static function cb($key){
		if(self::get($key)){
			echo ' checked ';
		}
	}
	public static function sel($key, $val, $isDefault = false){
		if((! self::get($key)) && $isDefault){ echo ' selected '; }
		if(self::get($key) == $val){ echo ' selected '; }
	}
	public static function getArray(){
		$ret = array();
		$q = self::getDB()->query("select name, val from " . self::table());
		while($row = mysql_fetch_assoc($q)){
			self::$cache[$row['name']] = $row['val'];
		}
		return self::$cache;
	}
	private static function getDB(){
		if(! self::$DB){ 
			self::$DB = new wfDB();
		}
		return self::$DB;
	}
	private static function table(){
		if(! self::$table){
			global $wpdb;
			self::$table = $wpdb->base_prefix . 'wfConfig';
		}
		return self::$table;
	}
	public static function haveAlertEmails(){
		$emails = self::getAlertEmails();
		return sizeof($emails) > 0 ? true : false;
	}
	public static function getAlertEmails(){
		$dat = explode(',', self::get('alertEmails'));
		$emails = array();
		foreach($dat as $email){
			if(preg_match('/\@/', $email)){
				$emails[] = trim($email);
			}
		}
		return $emails;
	}
	public static function getAlertLevel(){
		if(self::get('alertOn_warnings')){
			return 2;
		} else if(self::get('alertOn_critical')){
			return 1;
		} else {
			return 0;
		}
	}
}
?>
