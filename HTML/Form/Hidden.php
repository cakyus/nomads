<?php

class Nomads_HTML_Form_Hidden extends Nomads_HTML_Form_Input {
	
	public function __construct() {
		parent::__construct();
		$this->type = 'hidden';
	}
}

