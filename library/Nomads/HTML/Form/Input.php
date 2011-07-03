<?php
class Nomads_HTML_Form_Input extends Nomads_HTML_Element {
	
	public $name;
	public $type;
	public $value;
	
	public function __construct() {
		parent::__construct();
		$this->tagName = 'input';
	}
}

