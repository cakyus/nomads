<?php
// class Nomads_Http_Request_Cookie extends databaseRecordset {
class Nomads_Http_Request_Cookie {

    public $id;
    public $name;
    public $value;
    public $host;
    public $path;
    public $expires;
    public $timeCreate;
    
    public function __construct() {
        parent::__construct('httpRequestCookie');
    }

    function getRequestHeaderCookie($host) {
        
        $cookies = array();
        
        $this->filter('host', $host);
        $this->filter('expires', time(), '>');
        
        if ($this->fetch()) {
            $cookies[] = $this->name.'='.$this->value;
        }
        
        if (empty($cookies)) {
            return false;
        } else {
            return implode(';', $cookies);
        }
    }    
}

