<?php

/**
 * HTTP Client with cache
 **/

class Nomads_Http_Request {
	
    
    // result
    public $status;
    public $statusText;
    public $responseText;
    public $responseHeader;
    
    // error handling
    public $error;
    public $errorText;
    
    // request handling
    
    public $connectionTimeout; // in seconds
    public $streamTimeout; // in seconds
    public $fetchSize;
    public $connectionTimeoutRetry;
    public $streamTimeoutRetry;
    public $requestText;
    public $requestPostText;
    
    // options
    public $useCache;
    
    // private
    public $method;
    public $link;
    private $requestHeaders;
	
	public function __construct() {
		// default values
        $this->requestHeaders = array();
        $this->connectionTimeout = 120; // in seconds
        $this->streamTimeout = 30; // in seconds
        $this->fetchSize = 512;
        $this->connectionTimeoutRetry = 0;
        $this->streamTimeoutRetry = 1;
        $this->useCache = false;
	}
    
    
    public function open($URL, $method = 'GET') {
        $this->method = $method;
        $this->link = $URL;
    }
    
    public function setRequestHeader($name, $value) {
        $this->requestHeaders[$name] = $value;
    }

    public function send($data=null) {
        
		debug_print($this->link);
		
        $this->requestPostText = $data;
        
        $httpRequestCache = new Nomads_Http_Request_Cache;
        
        if ($this->useCache) {
            if ($httpRequestCache->getCache($this)) {
                // we got a cache
                $this->responseHeader = $httpRequestCache->responseHeader;
                $this->responseText = $httpRequestCache->responseText;
                $this->handleGZip();
                return true;
            } elseif ($this->handleDownload() == false) {
                return false;
            } else {
                // download is ok, caching this ..
                $httpRequestCache->setCache($this);
            }
        } elseif ($this->handleDownload() == false) {
            return false;
        }
        
        $this->handleCookie();
        $this->handleResposeStatus();
        $this->handleGZip();
        
        if ($this->status == 200) {
            return true;
        } else {
            trigger_error(
                 'httpStatusCode '.$this->status
                .' '.$this->statusText
                , E_USER_WARNING
                );
            return $this->handleRedirect();
        }
        
        return false;
    }
    
    public function getResponseHeader($name) {

		if (preg_match(
			  "/".str_replace("-", "\-", $name).": ([^\r\n]+)/i"
			, $this->responseHeader
			, $match
			)) {
			return $match[1];
		}
		
		return false;
    }
    
    private function handleDownload() {
        
        // get remoteHostName
        $link = new Nomads_Url;
        $link->setUrl($this->link);
        $remoteHostName = $link->getHostname();
        
        // get remoteHostIp
        $httpRequestHostName = new Nomads_Http_Request_Hostname;
        
        if (empty($remoteHostName)) {
			debug_print('invalid remoteHostName ('.$remoteHostName.')');
            return false;
		} elseif ($remoteHostIp = $httpRequestHostName->getHostIp($remoteHostName)) {
            // do nothing
        } else {
			debug_print('can\'t resolve hostname ('.$remoteHostName.')');
            return false;
        }
        
        // connecting to remoteHost
		debug_print('connecting to '.$remoteHostIp.' ('.$remoteHostName.')');
		
		$fp = @fsockopen(
			 $remoteHostIp
			, 80
			, $this->error
			, $this->errorText
			, $this->connectionTimeout
			);
			
		if (!$fp) {
            if ($this->connectionTimeoutRetry == 0) {
    			debug_print('connectionTimeout '.$this->errorText);
    			return false;
            } else {
    			trigger_error('connectionTimeoutRetry'
                    .' '.$this->connectionTimeoutRetry     
                    .' '.$this->errorText
                    );
                $this->connectionTimeoutRetry--;
                return $this->send($this->requestPostText);
            }
        }
        
        // generate requestText
            // requestHeaders
        $this->setRequestHeader('Host', $remoteHostName);
		$this->setRequestHeader('User-Agent',' Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101211 Firefox/3.6.13');
		$this->setRequestHeader('Accept','text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8');
		$this->setRequestHeader('Accept-Language','en-us,en;q=0.5');
		$this->setRequestHeader('Accept-Encoding','gzip,deflate');
		$this->setRequestHeader('Accept-Charset','ISO-8859-1,utf-8;q=0.7,*;q=0.7');
        
            // cookie
            // @reference http://en.wikipedia.org/wiki/HTTP_cookie
            if (isset($_ENV['httpRequest']['cookie'][$remoteHostName])) {
                $this->setRequestHeader(
                    'Cookie', $_ENV['httpRequest']['cookie'][$remoteHostName]
                    );
            }
            
        $this->setRequestHeader('Connection','close');
            
            // generate linkFullPath
        $linkFullPath = $link->getPath();
        if ($link->getQuery()) {
            $linkFullPath .= '?'.$link->getQuery();
        }
        if ($link->getFragment()) {
            $linkFullPath .= '#'.$link->getFragment();
        }
        
        $requestText = "GET ".$linkFullPath." HTTP/1.0\r\n";
        
            // generate requestHeaders
        foreach ($this->requestHeaders as $name => $value) {
            $requestText .= $name.": ".$value."\r\n";
        }
        
        $requestText .= "\r\n";
        
        $streamTimeStart = time();
        $this->responseText = '';
        $fetchBuffer = '';
        $isResponseHeader = true;
        $this->requestText = $requestText;
        
        // downloading ..
		
		debug_print('sending request ..');
        fwrite($fp, $requestText);
		
		debug_print('downloading ..');
        while (!feof($fp)) {
        
            if (time() - $streamTimeStart > $this->streamTimeout) {
                fclose($fp);
                if ($this->streamTimeoutRetry == 0) {
                    trigger_error('streamTimeout');
                    return false;
                } else {
                    trigger_error('streamTimeoutRetry'
                        .' '.$this->streamTimeoutRetry
                        );
                    $this->streamTimeoutRetry--;
                    return $this->send($this->requestPostText);
                }
            }
            
            //$fetchBuffer = fgets($fp, $this->fetchSize);
            $fetchBuffer = fread($fp, $this->fetchSize);
            
            if ($isResponseHeader == false) {
                $this->responseText .= $fetchBuffer;
            } else {
                $pos = strpos($fetchBuffer, "\r\n\r\n");
                if ($pos !== false) {
                    $isResponseHeader = false;
                    $this->responseHeader .= substr($fetchBuffer,0,$pos);
                    $this->responseText .= substr($fetchBuffer,$pos+4);
                } else {
                    $this->responseHeader .= $fetchBuffer;
                }
            }
            
            $fetchBuffer = '';
        }
        
        $fetchBuffer = '';
        fclose($fp);
        
		debug_print('download completed');
        
        if ($result = $this->handleCorruptedDownload()) {
            return $result;
        }
        
        return true;
    }
    
    private function handleCorruptedDownload() {
        
		if ($fileSize = $this->getResponseHeader('Content-Length')) {
			$bodySize = strlen($this->responseText);
			if ($bodySize == $fileSize) {
                // do nothing
				debug_print('not corrupted');
				return true;
            } else {
                if ($this->streamTimeoutRetry == 0) {
    				trigger_error('fileCorrupted');
                } else {
                    trigger_error('fileCorruptedRetry'
                        .' '.$this->streamTimeoutRetry
                        );
                    $this->streamTimeoutRetry--;
                    return $this->send($this->requestPostText);
                }
			}
		} else {
			debug_print('Content-Length not found');
			return true;
		}
        
        return false;
    }
    
    private function handleResposeStatus() {
        
        if (preg_match(
            "/^[^ ]+ ([0-9]+) ([^\r]+)/"
            , $this->responseHeader
            , $match
            )) {
            // HTTP/1.1 200 OK        
            $this->status = $match[1];
            $this->statusText = $match[2];
        }
        
        return false;
    }
    
    private function handleRedirect() {
        
        if ($redirectLocation = $this->getResponseHeader('Location')) {
			
            if (substr($redirectLocation,0,1) == '/') {
                $url = new url;
                $url->setUrl($this->link);
                $url->setPath($redirectLocation);
                $redirectLocation = $url->getUrl();
            }
            
            if ($this->link == $redirectLocation) {
                trigger_error(
                    'redirect location is the same as location'
                    , E_USER_WARNING
                    );
                return false;
            }
            
            trigger_error('redirect to '.$redirectLocation);
            $this->open($this->method, $redirectLocation);
            return $this->send($this->requestPostText);
        }
        
        return false;
    }
    
    private function handleGZip() {
        if ($this->getResponseHeader('Content-Encoding') == 'gzip') {
			$gzip = new Nomads_GZip;
			$this->responseText = $gzip->uncompress($this->responseText);
		}
    }
    
    private function handleCookie() {
        
        $link = new Nomads_Url;
        $link->setUrl($this->link);
        $remoteHostName = $link->getHostname();
        
        if (preg_match_all(
              "/([^ ]+)=([^;$]+)/"
            , $this->getResponseHeader('Set-Cookie')
            , $match
            )) {
            
            $httpRequestCookie = new httpRequestCookie;
            $httpRequestCookie->host = $remoteHostName;
            //var_dump($match);
            for ($i=0; $i < count($match[0]); $i++) {
                if ($match[1][$i] == 'path') {
                    $httpRequestCookie->path = $match[2][$i];
                } elseif ($match[1][$i] == 'domain') {
                    $httpRequestCookie->host = $match[2][$i];
                } elseif ($match[1][$i] == 'expires') {
                    $time = strtotime($match[2][$i]);
                    //echo $match[2][$i]."\n";
                    //echo date("Y-m-d H:i:s",$time)."\n";
                    $httpRequestCookie->expires = $time;
                } else {
                    $httpRequestCookie->name = $match[1][$i];
                    $httpRequestCookie->value = $match[2][$i];
                }
            }
            $httpRequestCookie->put();
        }
    }
}
