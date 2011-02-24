<?php

class request {
    
    private $properties;

    public function __construct() {
        
        $this->properties = array();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->properties = $_POST;
        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->properties = $_GET;
        }
    }
    
    public function get($name) {
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        } else {
            return null;
        }
    }

}

