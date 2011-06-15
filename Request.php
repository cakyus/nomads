<?php

class Nomads_Request {
    
    private $properties;

    public function __construct() {
        
        $this->properties = array();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->properties = $_POST;
        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->properties = $_GET;
        }
    }
	
	public function getMethod() {
		return $_SERVER['REQUEST_METHOD'];
	}
	
	public function item($index) {
		$items = array_values($this->properties);
		return $items[$index];
	}
	
	public function key($index) {
		$items = array_keys($this->properties);
		return $items[$index];
	}
	
	public function count() {
		return count($this->properties);
	}
    
    public function __get($name) {
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        } else {
            return null;
        }
    }
}