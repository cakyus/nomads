<?php

/**
 * protocol://username:password@host:port/path?querystring#fragment
 **/

class url {
    
    private $url;
    
    // url components
    private $protocol;
    private $host;
    private $port;
    private $username;
    private $password;
    private $path;
    private $querystring;
    private $fragment;
    
    // more components
    private $queries;
    
    public function __construct() {
        $this->queries = array();
    }

    public function getCurrentUrl() {}
    public function getLocalUrl($className, $functionName) {}

    public function getUrl($url) {
        return $this->url;
    }
    public function getProtocal($string) {
        return $this->protocol;
    }
    public function getHost($string) {
        return $this->host;
    }
    public function getPort($string) {
        return $this->port;
    }
    public function getUsername($string) {
        return $this->username;
    }
    public function getPassword($string) {
        return $this->password;
    }
    public function getPath($string) {
        return $this->path;
    }
    public function getQueryString($string) {
        return $this->querystring;
    }
    public function getFragment($string) {
        return $this->fragment;
    }
    public function getQuery($name) {
        if (isset($this->queries[$name])) {
            return $this->queries[$name];
        }
        return false;
    }

    public function setUrl($url) {
        return $this->parseUrl($url);
    }
    public function setProtocal($string) {
        $this->protocol = $string;
        return $this->buildUrl();
    }
    public function setHost($string) {
        $this->host = $string;
        return $this->buildUrl();
    }
    public function setPort($string) {
        $this->port = $string;
        return $this->buildUrl();
    }
    public function setUsername($string) {
        $this->username = $string;
        return $this->buildUrl();
    }
    public function setPassword($string) {
        $this->password = $string;
        return $this->buildUrl();
    }
    public function setPath($string) {
        $this->path = $string;
        return $this->buildUrl();
    }
    public function setQueryString($string) {
        $this->querystring = $string;
        $this->parseQueryString();
        return $this->buildUrl();
    }
    public function setFragment($string) {
        $this->fragment = $string;
        return $this->buildUrl();
    }
    public function setQuery($name, $value) {
        $this->protocol = $string;
        $this->buildQueryString();
        return $this->buildUrl();
    }
    
    private function parseQueryString() {
        return parse_str($this->querystring, $this->queries);
    }
    
    private function parseUrl($url) {
        
        if (!$components = parse_url($url)) {
            return false;
        }
        if (isset($components['scheme'])) {
            $this->protocol = $components['scheme'];
        }
        if (isset($components['host'])) {
            $this->host = $components['host'];
        }
        if (isset($components['port'])) {
            $this->port = $components['port'];
        }
        if (isset($components['user'])) {
            $this->username = $components['user'];
        }
        if (isset($components['pass'])) {
            $this->password = $components['pass'];
        }
        if (isset($components['path'])) {
            $this->path = $components['path'];
        }
        if (isset($components['query'])) {
            $this->querystring = $components['query'];
        }
        if (isset($components['fragment'])) {
            $this->fragment = $components['fragment'];
        }
    }
    
    private function buildQueryString() {
        $this->querystring = http_build_query($this->queries):
    }
    
    private function buildUrl() {
		
		if (empty($this->protocol)) {
            $this->protocol = 'http';
            $this->url = 'http://';
		}
        
        $this->url = $this->protocol.'://';
		
		if (empty($this->username)) {
		} elseif (empty($this->password)) {
            $this->url = $this->username.'@';
		} else {
            $this->url = $this->username.':'.$this->password.'@';
        }
		
		if (empty($this->host)) {
            $this->url .= '127.0.0.1';
		}
        
        $this->url .= $this->host;
		
		if (empty($this->port) == false) {
            $this->url .= ':'.$this->port;
		}
		
		if (empty($this->path) == false) {
			if (substr($this->path,0,1) != '/') {
				$this->path = '/'.$this->path;
            }
			$this->url .= $this->path;
		}
        
        if (empty($this->querystring) == false) {
            if (empty($this->path)) {
                $this->url .= '/';
            }
            $this->url .= '?'.$this->querystring;
        }
        
        if (empty($this->fragment) == false) {
            if (empty($this->path)) {
                $this->url .= '/';
            }
            $this->url .= '#'.$this->fragment;
        }
    }
}

