<?php
require_once('wfDB.php');
class wfSchema {
	private $tables = array(
"wfBadLeechers" => "(
	eMin int UNSIGNED NOT NULL,
	IP int UNSIGNED NOT NULL,
	hits int UNSIGNED NOT NULL,
	PRIMARY KEY k1(eMin, IP)
) default charset=latin1",
"wfVulnScanners" => "(
	IP int UNSIGNED PRIMARY KEY,
	ctime int UNSIGNED NOT NULL,
	hits int UNSIGNED NOT NULL
)",
"wfBlocks" => "(
	IP int UNSIGNED PRIMARY KEY,
	blockedTime int UNSIGNED NOT NULL,
	reason varchar(255) NOT NULL,
	lastAttempt int UNSIGNED default 0,
	blockedHits int UNSIGNED default 0,
	wfsn tinyint UNSIGNED default 0,
	permanent tinyint UNSIGNED default 0,
	KEY k1(wfsn)
) default charset=utf8",
"wfConfig" => "(
	name varchar(100) PRIMARY KEY NOT NULL,
	val longblob
) default charset=utf8",
"wfCrawlers" => "(
	IP INT UNSIGNED NOT NULL,
	patternSig binary(16) NOT NULL,
	status char(8) NOT NULL,
	lastUpdate int UNSIGNED NOT NULL,
	PTR varchar(255) default '',
	PRIMARY KEY k1(IP, patternSig)
) default charset=latin1",
"wfFileChanges" => "(
	filenameHash char(64) NOT NULL PRIMARY KEY,
	file varchar(1000) NOT NULL,
	md5 char(32) NOT NULL
) default charset=utf8",
"wfHits" => "(
	id int UNSIGNED auto_increment PRIMARY KEY,
	ctime DOUBLE(17,6) UNSIGNED NOT NULL,
	IP int UNSIGNED NOT NULL,
	jsRun tinyint default 0,
	is404 tinyint NOT NULL,
	isGoogle tinyint NOT NULL,
	userID int UNSIGNED NOT NULL,
	newVisit tinyint UNSIGNED NOT NULL,
	URL text,
	referer text,
	UA text,
	KEY k1(ctime),
	KEY k2(IP, ctime)
) default charset=latin1",
"wfIssues" => "(
	id int UNSIGNED NOT NULL auto_increment PRIMARY KEY,
	time int UNSIGNED NOT NULL,
	status varchar(10) NOT NULL,
	type varchar(20) NOT NULL,
	severity tinyint UNSIGNED NOT NULL,
	ignoreP char(32) NOT NULL,
	ignoreC char(32) NOT NULL,
	shortMsg varchar(255) NOT NULL,
	longMsg text,
	data text
) default charset=utf8",
"wfLeechers" => "(
	eMin int UNSIGNED NOT NULL,
	IP int UNSIGNED NOT NULL,
	hits int UNSIGNED NOT NULL,
	PRIMARY KEY k1(eMin, IP)
) default charset=latin1",
"wfLockedOut" => "(
	IP int UNSIGNED PRIMARY KEY,
	blockedTime int UNSIGNED NOT NULL,
	reason varchar(255) NOT NULL,
	lastAttempt int UNSIGNED default 0,
	blockedHits int UNSIGNED default 0
) default charset=utf8",
"wfLocs" => "(
	IP int UNSIGNED NOT NULL PRIMARY KEY,
	ctime int UNSIGNED NOT NULL,
	failed tinyint UNSIGNED NOT NULL,
	city varchar(255) default '',
	region varchar(255) default '',
	countryName varchar(255) default '',
	countryCode char(2) default '',
	lat float(10,7) default 0,
	lon float(10,7) default 0
) default charset=utf8",
"wfLogins" => "(
	id int UNSIGNED auto_increment PRIMARY KEY,
	ctime DOUBLE(17,6) UNSIGNED NOT NULL,
	fail tinyint UNSIGNED NOT NULL,
	action varchar(40) NOT NULL,
	username varchar(255) NOT NULL,
	userID int UNSIGNED NOT NULL,
	IP int UNSIGNED NOT NULL,
	UA text,
	KEY k1(IP, fail)
) default charset=utf8",
"wfReverseCache" => "(
	IP int UNSIGNED PRIMARY KEY,
	host varchar(255) NOT NULL,
	lastUpdate int UNSIGNED NOT NULL
) default charset=latin1",
"wfScanners" => "(
	eMin int UNSIGNED NOT NULL,
	IP int UNSIGNED NOT NULL,
	hits smallint UNSIGNED NOT NULL,
	PRIMARY KEY k1(eMin, IP)
) default charset=latin1",
"wfThrottleLog" => "(
	IP int UNSIGNED NOT NULL PRIMARY KEY,
	startTime int UNSIGNED NOT NULL,
	endTime int UNSIGNED NOT NULL,
	timesThrottled int UNSIGNED NOT NULL,
	lastReason varchar(255) NOT NULL,
	KEY k2(endTime)
) default charset=utf8",
"wfStatus" => "(
	ctime DOUBLE(17,6) UNSIGNED NOT NULL,
	level tinyint UNSIGNED NOT NULL,
	type char(5) NOT NULL,
	msg varchar(1000) NOT NULL,
	KEY k1(ctime),
	KEY k2(type)
) default charset=utf8",
'wfNet404s' => "(
	sig binary(16) NOT NULL PRIMARY KEY,
	ctime int UNSIGNED NOT NULL,
	URI varchar(1000) NOT NULL,
	KEY k1(ctime)
) default charset=utf8",
'wfHoover' => "(
	id int UNSIGNED auto_increment PRIMARY KEY,
	owner text,
	host text,
	path text,
	hostKey binary(4),
	KEY k2(hostKey)
) default charset=utf8",
'wfFileMods' => "(
	filenameMD5 binary(16) NOT NULL PRIMARY KEY,
	filename varchar(1000) NOT NULL,
	knownFile tinyint UNSIGNED NOT NULL,
	oldMD5 binary(16) NOT NULL,
	newMD5 binary(16) NOT NULL
) default charset=utf8"
);
	private $db = false;
	private $prefix = 'wp_';
	public function __construct($dbhost = false, $dbuser = false, $dbpassword = false, $dbname = false){
		if($dbhost){ //for testing
			$this->db = new wfDB(false, $dbhost, $dbuser, $dbpassword, $dbname);
			$this->prefix = 'wp_';
		} else {
			global $wpdb;
			$this->db = new wfDB();
			$this->prefix = $wpdb->base_prefix;
		}
	}
	public function dropAll(){
		foreach($this->tables as $table => $def){
			$this->db->query("drop table if exists " . $this->prefix . $table);
		}
	}
	public function createAll(){
		foreach($this->tables as $table => $def){
			$this->db->query("create table IF NOT EXISTS " . $this->prefix . $table . " " . $def);
		}
	}
	public function create($table){
		$this->db->query("create table IF NOT EXISTS " . $this->prefix . $table . " " . $this->tables[$table]);
	}
	public function drop($table){
		$this->db->query("drop table if exists " . $this->prefix . $table);
	}
}
?>
