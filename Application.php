<?php

class Nomads_Application {
	
	public $mode;
	
	public function __construct() {
		$this->mode = APPLICATION_MODE;
	}
	
	public function start() {
		
		// set autoloader
		include('Loader.php');
		
		Nomads_Loader::register();

		$controller = new Index_Controller;
		$controller->index();
	}
}
