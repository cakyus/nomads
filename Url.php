<?php

class Nomads_Url {
	
	private $link;
    
	public function href($text) {
		return '<a href="'.$this->getUrl().'">'.$text.'</a>';
	}
	
	public function getCurrentUrl() {
	
		if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
			$link = 'http://';
		} else {
			return false;
		}
		
		// var_dump($_SERVER);
		
		$link .= $_SERVER['HTTP_HOST'];
		$link .= $_SERVER['REQUEST_URI'];
		
		if (isset($_SERVER['QUERY_STRING'])) {
			$link .= '?'.$_SERVER['QUERY_STRING'];
		}
		
		return $link;
	}
	
	public function getHostname() {
		return $this->get('host');
	}
	
	public function getPath() {
		return $this->get('path');
	}
	
	public function getQuery() {
		return $this->get('query');
	}
	
	public function getFragment() {
		return $this->get('fragment');
	}
	
	public function local($class, $function=null) {
		
		// get current link from phpinfo
		
		
		// echo $uri;
		
		$parseUrl = parse_url($this->getCurrentUrl());
		
		unset($parseUrl['query']);
		unset($parseUrl['fragment']);
		
		$this->link = $this->build($parseUrl);
		
		$this->setQuery('c', $class);
		if (!is_null($function)) {
			$this->setQuery('f', $function);
		}
	}
	
	public function setQuery($name, $value) {
		
		$parseUrl = parse_url($this->link);
		
		if (isset($parseUrl['query'])) {
			parse_str($parseUrl['query'], $parseQuery);
		} else {
			$parseQuery = array();
		}
		
		$parseQuery[$name] = $value;
		$parseUrl['query'] = http_build_query($parseQuery);
		
		$this->link = $this->build($parseUrl);
	}
	
	public function getUrl() {
		return $this->link;
	}
	
	public function setUrl($link) {
		$this->link = $link;
	}
	
	private function get($name) {
		$parseUrl = parse_url($this->link);
		if (isset($parseUrl[$name])) {
			return $parseUrl[$name];
		}
		return false;
	}
	
	private function build($parseUrl) {
		
		/*
		 
$url = 'http://username:password@hostname/path?arg=value#anchor';
		
Array
(
    [scheme] => http
    [host] => hostname
    [user] => username
    [pass] => password
    [path] => /path
    [query] => arg=value
    [fragment] => anchor
)
		*/
		
		// var_dump($parseUrl);
		
		if (isset($parseUrl['scheme'])) {
			$buildUrl = $parseUrl['scheme'].'://';			
		} else {
			$buildUrl = 'http://';
		}
		
		if (isset($parseUrl['host'])) {
			$buildUrl .= $parseUrl['host'];
		} else {
			$buildUrl .= 'localhost';
		}
		
		if (isset($parseUrl['port'])) {
			$buildUrl .= ':'.$parseUrl['port'];
		}
		
		if (isset($parseUrl['path'])) {
			$buildUrl .= $parseUrl['path'];
		} else {
			$buildUrl .= '/';
		}
		
		if (isset($parseUrl['query'])) {
			$buildUrl .= '?'.$parseUrl['query'];
		}
		
		return $buildUrl;
	}
}

