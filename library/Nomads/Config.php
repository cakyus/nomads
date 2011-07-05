<?php

class Nomads_Config {

    public function __construct () {
    
        $file = new Nomads_File;
        
        $fileConfig = FRAMEWORK_PATH.'/config.php';
        
        if ($file->open($fileConfig)) {
            // fileConfig is found
            // @todo this include is called multiple times
            //  perhaps Singleton will be better
            include($fileConfig);
            
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
}

