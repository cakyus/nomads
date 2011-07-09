<?php

class Nomads_Config {

    public function __construct () {
    	
    	global $config;
    	
    	$className = get_class($this);
    	
    	if (substr($className, -7) != '_Config') {
    		trigger_error('Class name not ended with "_Config"');
    		return false;
    	}
    	
    	// remove __Config suffix from className
    	$className = substr($className, 0, -7);
    	
        if (isset($config[$className])) {
        	$configClass = $config[$className];
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

