<?php

class Nomads_HTML_Form_Label extends Nomads_HTML_Element {
	
	public $for;
	
	public function __construct() {
		parent::__construct();
		$this->tagName = 'label';
	}
}

