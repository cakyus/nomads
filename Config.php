<?php

class Nomads_Config {

    private $properties;

    public function __construct () {
    
        $file = new Nomads_File;
        
        $this->properties = array();
        $fileConfig = FRAMEWORK_PATH.'/config.php';
        
        if ($file->open($fileConfig)) {
            // fileConfig is found
            // @todo this include is called multiple times
            //  perhaps Singleton will be better
            include($fileConfig);
            $this->properties = $config;
        }
    }
    
    public function get($keyword) {
       if (isset($this->properties[$keyword])) {
            return $this->properties[$keyword];
        } else {
            return null;
        }
    }
}

