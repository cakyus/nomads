<?php

	
	public $name;
	public $type;
	public $value;
	
	public function __construct() {
		parent::__construct();
		$this->tagName = 'input';
	}
}
