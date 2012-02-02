<?php
// class Nomads_Http_Request_Cache extends databaseRecordset {
class Nomads_Http_Request_Cache {

    public $method;
    public $link;
    public $requestPostText;
    public $responseHeader;
    public $responseText;
    public $httpExpires;
    public $timeCreate;
    
    public function __construct() {}
    
    public function getCache(Nomads_Http_Request $httpRequest) {
		
		$file = new Nomads_File;
		
		$this->method = $httpRequest->method;
		$this->link = $httpRequest->link;
		$this->requestPostText = $httpRequest->requestPostText;
		
		if ($file->open($this->getFilePath($httpRequest))) {
			
			$requestCache = unserialize($file->getContent());
			
			$this->responseHeader = $requestCache->responseHeader;
			$this->responseText = $requestCache->responseText;
			$this->httpExpires = strtotime(
				$httpRequest->getResponseHeader('Expires')
				);
			$this->timeCreate = $file->getTimeCreate();
			return true;
		} else {
			return false;
		}
    }
    
    public function setCache(Nomads_Http_Request $httpRequest) {
		
		$file = new Nomads_File;
		
		$file->open($this->getFilePath($httpRequest));
		$file->putContent(serialize($httpRequest));
		
		return true;
    }
    
    /**
     * get file path in temporary folder
     **/
    
	private function getFilePath(Nomads_Http_Request $httpRequest) {
		
		$path = sys_get_temp_dir();
		
		// use three keys : Method, URL, and Request POST Text
		$path .= '/php_'.md5(
			 $httpRequest->method
			.$httpRequest->link
			.$httpRequest->requestPostText
			);
		
		return $path;
	}
	
    public function clean() {
        
    }
    
    public function clear() {
        
    }
}

