<?php

/**
 * Welcome_View
 *
 * @package packageName
 *
 **/

class Welcome_View extends Nomads_View {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		echo 'It\'s works !';
	}
}

