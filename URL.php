<?php

class Nomads_URL {

    
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
    
    public function getCurrentUrl() {
        
        // clear all
        $this->clear();
        
        $protocol = $_SERVER['SERVER_PROTOCOL'];
        $protocol = substr($protocol,0,strpos($protocol,'/'));
        $protocol = strtolower($protocol);
        
        $this->setProtocal($protocol);
        
        if (isset($_SERVER['HTTP_HOST'])) {
            
            if (strpos($_SERVER['HTTP_HOST'],':')) {
                $components = explode(':',$_SERVER['HTTP_HOST']);
                $this->setHost($components[0]);
                $this->setPort($components[1]);
            } else {
                $this->setHost($_SERVER['HTTP_HOST']);
                $this->setPort(80);
            }
        } else {
            $this->setHost($_SERVER['SERVER_NAME']);
            $this->setPort($_SERVER['SERVER_PORT']);
        }
        
        if ($pos = strpos($_SERVER['REQUEST_URI'],'?')) {
            $this->setPath(substr($_SERVER['REQUEST_URI'], 0, $pos));
        } else {
            $this->setPath($_SERVER['REQUEST_URI']);            
        }

        $this->setQueryString($_SERVER['QUERY_STRING']);
        $this->setFragment('');
        
        return $this->buildUrl();
    }
    
    public function getLocalUrl($className, $functionName) {
        $this->getCurrentUrl();
        $this->setQueryString('');
        $this->setFragment('');
        $this->setQuery('c',$className);
        $this->setQuery('f',$functionName);
        $this->buildUrl();
        return $this->getUrl();
    }
    
    public function getUrl() {
        return $this->url;
    }
    
    public function getProtocal() {
        return $this->protocol;
    }
    
    public function getHost() {
        return $this->host;
    }
    
    public function getPort() {
        return $this->port;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getPath() {
        return $this->path;
    }
    
    public function getQueryString() {
        return $this->querystring;
    }
    
    public function getFragment() {
        return $this->fragment;
    }
    
    public function getQuery($name) {
        if (isset($this->queries[$name])) {
            return $this->queries[$name];
        }
        return false;
    }

    public function setUrl($url) {
        $this->parseUrl($url);
        $this->buildUrl();
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
        $this->queries[$name] = $value;
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
        $this->querystring = http_build_query($this->queries);
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
    
    private function clear() {
        
        $this->url = '';
        
        // url components
        $this->protocol = '';
        $this->host = '';
        $this->port = 0;
        $this->username = '';
        $this->password = '';
        $this->path = '';
        $this->querystring = '';
        $this->fragment = '';
        
        // more components
        $this->queries = array();
    }
}

