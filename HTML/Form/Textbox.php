<?php
class htmlTextbox extends htmlInputLabel {
	
	public function __construct() {
		parent::__construct();
		$this->type = 'text';
	}
}

