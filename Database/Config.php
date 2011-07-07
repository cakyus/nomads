<?php

/**
 * Nomads_Database_Config
 **/
 
class Nomads_Database_Config extends Nomads_Config {

	public $hostname;
	public $username;
	public $password;
	public $database;

	public function __construct () {
		parent::__construct();
	}
}

