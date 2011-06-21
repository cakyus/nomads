<?php

class Nomads_HTML_Form_Submit extends Nomads_HTML_Form_Input {
	
	public function __construct() {
		parent::__construct();
		$this->type = 'submit';
		$this->value = 'Submit';
	}
}

