<?php

class databaseConfig {

	public $hostname;
	public $username;
	public $password;
	public $database;
	
	public function __construct() {
		$this->hostname = '127.0.0.1';
		$this->username = 'root';
		$this->password = '';
		$this->database = 'nomads';
	}
}