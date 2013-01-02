<?php
require_once('wfAPI.php');
require_once('wfArray.php');
class wordfenceURLHoover {
	private $debug = false;
	public $errorMsg = false;
	private $hostsToAdd = false;
	private $table = '';
	private $apiKey = false;
	private $wordpressVersion = false;
	private $useDB = true;
	private $hostKeys = array();
	private $hostList = array();
	private $dRegex = 'aero|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|xxx|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cx|cy|cz|dd|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|ss|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|za|zm|zw|xn--lgbbat1ad8j|xn--fiqs8s|xn--fiqz9s|xn--wgbh1c|xn--j6w193g|xn--h2brj9c|xn--mgbbh1a71e|xn--fpcrj9c3d|xn--gecrj9c|xn--s9brj9c|xn--xkc2dl3a5ee0h|xn--45brj9c|xn--mgba3a4f16a|xn--mgbayh7gpa|xn--mgbc0a9azcg|xn--ygbi2ammx|xn--wgbl6a|xn--p1ai|xn--mgberp4a5d4ar|xn--90a3ac|xn--yfro4i67o|xn--clchc0ea0b2g2a9gcd|xn--3e0b707e|xn--fzc2c9e2c|xn--xkc2al3hye2a|xn--mgbtf8fl|xn--kprw13d|xn--kpry57d|xn--o3cw4h|xn--pgbs0dh|xn--mgbaam7a8h|xn--54b7fta0cc|xn--90ae|xn--node|xn--4dbrk0ce|xn--80ao21a|xn--mgb9awbf|xn--mgbai9azgqp6j|xn--j1amh|xn--mgb2ddes|xn--kgbechtv|xn--hgbk6aj7f53bba|xn--0zwm56d|xn--g6w251d|xn--80akhbyknj4f|xn--11b5bs3a9aj6g|xn--jxalpdlp|xn--9t4b11yi5a|xn--deba0ad|xn--zckzah|xn--hlcj6aya9esc7a';
	private $api = false;
	private $db = false;
	public function __sleep(){
		$this->writeHosts();	
		return array('debug', 'errorMsg', 'table', 'apiKey', 'wordpressVersion', 'dRegex');
	}
	public function __wakeup(){
		$this->hostsToAdd = new wfArray(array('owner', 'host', 'path', 'hostKey'));
		$this->api = new wfAPI($this->apiKey, $this->wordpressVersion);
		$this->db = new wfDB();
	}	
	public function __construct($apiKey, $wordpressVersion, $db = false){
		$this->hostsToAdd = new wfArray(array('owner', 'host', 'path', 'hostKey'));
		$this->apiKey = $apiKey;
		$this->wordpressVersion = $wordpressVersion;
		$this->api = new wfAPI($apiKey, $wordpressVersion);
		if($db){
			$this->db = $db;
		} else {
			$this->db = new wfDB();
		}
		global $wpdb;
		if(isset($wpdb)){
			$this->table = $wpdb->base_prefix . 'wfHoover';
		} else {
			$this->table = 'wp_wfHoover';
		}
		$this->db->truncate($this->table);
	}
	public function hoover($id, $data){
		if(strpos($data, '.') === false){
			return;
		}
		try {
			@preg_replace("/(?<=^|[^a-zA-Z0-9\-])((?:[a-zA-Z0-9\-]+\.)+)(" . $this->dRegex . ")((?:$|[^a-zA-Z0-9\-\.\'\"])[^\r\n\s\t\"\'\$\{\}<>]*)/ie", "\$this->" . "addHost(\$id, '$1$2', '$3')", $data);
		} catch(Exception $e){ 
			//error_log("Regex error 1: $e"); 
		}
		@preg_replace("/(?<=[^\d]|^)(\d{8,10}|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})([^\d\'\"][^\r\n\s\t\"\'\$\{\}<>]*)/e", "\$this->" . "addIP(\$id, \"$1\",\"$2\")", $data);
		$this->writeHosts();
	}
	private function dbg($msg){ 
		if($this->debug){ 
			//error_log("DEBUG: $msg\n"); 
		} 
	}
	public function addHost($id, $host, $path){
		if(strpos($path, '/') !== 0){
			$path = '/';
		} else {
			$path = preg_replace_callback('/([^A-Za-z0-9\-\.\_\~:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,;\=]+)/', 'wordfenceURLHoover::urlenc', $path);
		}
		$host = strtolower($host);
		$hostParts = explode('.', $host);
		if(sizeof($hostParts) == 2){
			$hostKey = substr(hash('sha256', $hostParts[0] . '.' . $hostParts[1] . '/', true), 0, 4);
			$this->hostsToAdd->push(array('owner' => $id, 'host' => $host, 'path' => $path, 'hostKey' => $hostKey));
		} else if(sizeof($hostParts) > 2){
			$hostKeyThreeParts = substr(hash('sha256',$hostParts[sizeof($hostParts) - 3] . '.' . $hostParts[sizeof($hostParts) - 2] . '.' . $hostParts[sizeof($hostParts) - 1] . '/', true), 0, 4);
			$hostKeyTwoParts = substr(hash('sha256', $hostParts[sizeof($hostParts) - 2] . '.' . $hostParts[sizeof($hostParts) - 1] . '/', true), 0, 4);
			$this->hostsToAdd->push(array('owner' => $id, 'host' => $host, 'path' => $path, 'hostKey' => $hostKeyThreeParts));
			$this->hostsToAdd->push(array('owner' => $id, 'host' => $host, 'path' => $path, 'hostKey' => $hostKeyTwoParts));
		}
		if($this->hostsToAdd->size() > 1000){ $this->writeHosts(); }	
	}
	public function addIP($id, $ipdata, $path){
		$this->dbg("Add IP called with $ipdata $path");
		if(strpos($path, '/') !== 0){
			$path = '/';
		} else {
			$path = preg_replace_callback('/([^A-Za-z0-9\-\.\_\~:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,;\=]+)/', 'wordfenceURLHoover::urlenc', $path);
		}
		if(strstr($ipdata, '.') === false && $ipdata >= 16777216 && $ipdata <= 4026531840){
			$ipdata = long2ip($ipdata);
		} 
		$parts = explode('.', $ipdata);
		$isValid = true;
		if($parts[0] >= 240 || $parts[0] == '10' || $parts[0] == '172' || $parts[0] == '192' || $parts[0] == '127'){
			$isValid = false;
		}
		if($isValid){
			foreach($parts as $part){
				if($part < 1 || $part > 255){
					$isValid = false;
				}
			}
		}
		if($isValid && $ipdata){
			$hostKey = substr(hash('sha256', $ipdata . '/', true), 0, 4);
			$this->hostsToAdd->push(array('owner' => $id, 'host' => $ipdata, 'path' => $path, 'hostKey' => $hostKey));
			if($this->hostsToAdd->size() > 1000){ $this->writeHosts(); }	
		}
	}
	public static function urlenc($m){
		return urlencode($m[1]);
	}
	private function writeHosts(){
		if($this->hostsToAdd->size() < 1){ return; }
		if($this->useDB){
			$sql = "insert into " . $this->table . " (owner, host, path, hostKey) values ";
			while($elem = $this->hostsToAdd->shift()){
				$sql .= sprintf("('%s', '%s', '%s', '%s'),", 
					mysql_real_escape_string($elem['owner']), 
					mysql_real_escape_string($elem['host']), 
					mysql_real_escape_string($elem['path']), 
					mysql_real_escape_string($elem['hostKey'])
					);
			}
			$sql = rtrim($sql, ',');
			$this->db->query($sql);
		} else {
			while($elem = $this->hostsToAdd->shift()){
				$this->hostKeys[] = $elem['hostKey'];
				$this->hostList[] = array(
					'owner' => $elem['owner'],
					'host' => $elem['host'],
					'path' => $elem['path'],
					'hostKey' => $elem['hostKey']
					);
			}
		}
	}
	public function getBaddies(){
		$allHostKeys = array();
		$stime = microtime(true);
		$allHostKeys = array();
		if($this->useDB){
			$q1 = $this->db->query("select distinct hostKey as hostKey from $this->table");
			while($hRec = mysql_fetch_assoc($q1)){
				array_push($allHostKeys, $hRec['hostKey']);
			}
		} else {
			$allHostKeys = $this->hostKeys;
		}
		//Now call API and check if any hostkeys are bad. 
		//This is a shortcut, because if no hostkeys are bad it saves us having to check URLs
		if(sizeof($allHostKeys) > 0){ //If we don't have any hostkeys, then we won't have any URL's to check either.
			//Hostkeys are 4 byte sha256 prefixes
			//Returned value is 2 byte shorts which are array indexes for bad keys that were passed in the original list
			$this->dbg("Checking " . sizeof($allHostKeys) . " hostkeys");
			if($this->debug){
				foreach($allHostKeys as $key){
					$this->dbg("Checking hostkey: " . bin2hex($key));
				}
			}
			$resp = $this->api->binCall('check_host_keys', implode('', $allHostKeys));
			$this->dbg("Done hostkey check");

			$badHostKeys = array();
			if($resp['code'] == 200){
				if(strlen($resp['data']) > 0){
					$dataLen = strlen($resp['data']);
					if($dataLen % 2 != 0){
						$this->errorMsg = "Invalid data length received from Wordfence server: " . $dataLen;
						return false;
					}
					for($i = 0; $i < $dataLen; $i += 2){
						$idxArr = unpack('n', substr($resp['data'], $i, 2));
						$idx = $idxArr[1];
						if(isset($allHostKeys[$idx]) ){
							array_push($badHostKeys, $allHostKeys[$idx]);
							$this->dbg("Got bad hostkey for record: " . var_export($allHostKeys[$idx], true));
						} else {
							$this->dbg("Bad allHostKeys index: $idx");
							$this->errorMsg = "Bad allHostKeys index: $idx";
							return false;
						}
					}
				}
			} else {
				$this->errorMsg = "Wordfence server responded with an error. HTTP code " . $resp['code'] . " and data: " . $resp['data'];
				return false;
			}
			if(sizeof($badHostKeys) > 0){
				$urlsToCheck = array();
				//need to figure out which id's have bad hostkeys
				//need to feed in all URL's from those id's where the hostkey matches a URL
				foreach($badHostKeys as $badHostKey){
					if($this->useDB){
						$q1 = $this->db->query("select owner, host, path from $this->table where hostKey='%s'", $badHostKey);
						while($rec = mysql_fetch_assoc($q1)){
							$url = 'http://' . $rec['host'] . $rec['path'];
							if(! isset($urlsToCheck[$rec['owner']])){
								$urlsToCheck[$rec['owner']] = array();
							}
							if(! in_array($url, $urlsToCheck[$rec['owner']])){
								$urlsToCheck[$rec['owner']][] = $url;
							}
						}
					} else {
						foreach($this->hostList as $rec){
							if($rec['hostKey'] == $badHostKey){
								$url = 'http://' . $rec['host'] . $rec['path'];
								if(! isset($urlsToCheck[$rec['owner']])){
									$urlsToCheck[$rec['owner']] = array();
								}
								if(! in_array($url, $urlsToCheck[$rec['owner']])){
									$urlsToCheck[$rec['owner']][] = $url;
								}
							}
						}
					}
				}

				if(sizeof($urlsToCheck) > 0){
					$this->dbg("Checking " . sizeof($urlsToCheck) . " URLs");
					if($this->debug){
						foreach($urlsToCheck as $url){
							$this->dbg("Checking URL: " . var_export($url, true));
						}
					}
					$badURLs = $this->api->call('check_bad_urls', array(), array( 'toCheck' => json_encode($urlsToCheck)) );
					$this->dbg("Done URL check");
					if(is_array($badURLs) && sizeof($badURLs) > 0){
						$finalResults = array();
						foreach($badURLs as $file => $badSiteList){
							if(! isset($finalResults[$file])){
								$finalResults[$file] = array();
							}
							foreach($badSiteList as $badSite){
								array_push($finalResults[$file], array(
									'URL' => $badSite[0],
									'badList' => $badSite[1]
									));
							}
						}
						return $finalResults;
					} else {
						return array();
					}
				} else {
					return array();
				}
			} else {
				return array();
			}
		} else {
			return array();
		}
	}
}
?>
