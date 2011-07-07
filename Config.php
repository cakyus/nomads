<?php

class Nomads_Config {

    public function __construct () {
    	
    	global $config;
    	
        if (isset($config[get_class($this)])) {
        	$configClass = $config[get_class($this)];
        } else {
        	return false;
        }
        
        foreach ($this as $key => $value) {
        	if (isset($configClass[$key])) {
        		$this->$key = $configClass[$key];
        	}
        }
    }
}

