<?php
// class httpRequestHostName extends databaseRecordset {
class Nomads_Http_Request_Hostname {

    public $id;
    public $hostName;
    public $hostIp;
    public $hostNameHash;
    public $timeCreate;
    public $timeUpdate;

    public function __construct() {}
    
    /**
     * resolve hostname to ipaddress
     **/
    
    public function getHostIp($hostname) {
		
		$this->hostName = $hostname;
		$this->hostIp = gethostbyname($hostname);
		
		return $this->hostIp;
    }
}

