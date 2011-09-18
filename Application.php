<?php

class Nomads_Application {
	
	public $mode;
	public $path;
	
	public function __construct() {
		$this->mode = APPLICATION_MODE;
		$this->path = APPLICATION_PATH;
	}
	
	public function start() {
		
		// set autoloader
		include('Loader.php');
		Nomads_Loader::setAutoload();

		// find controller
		// probably useful variables:
		// $_SERVER['SCRIPT_NAME'], $_SERVER['REQUEST_URI']
		$path = substr($_SERVER['REQUEST_URI']
			, strlen(dirname($_SERVER['SCRIPT_NAME']))
			);
		// /projects/nomads/application/public/index.php
		echo $path;
		// echo $this->path;
		phpinfo(32);
	}
}
