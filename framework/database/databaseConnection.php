<?php

class databaseConnection {
	
	public $handle;
	private static $instance;
	
	private function __construct() {}
	private function __clone() {}
	
	public static function getInstance() {
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
			self::$instance->open();
		}
		return self::$instance;
	}
	
	private function open() {
		
		$config = new databaseConfig;
		if ($this->handle = mysql_connect(
				  $config->hostname
				, $config->username
				, $config->password
			)) {
			// it's okay
		} else {
			exit('can\'t connect to database');
		}
		
		if (mysql_select_db($config->database,$this->handle)) {
			// it's okay
		} else {
			exit('can\'t open database');
		}
	}
}
