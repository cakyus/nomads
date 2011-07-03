<?php

namespace _d33b5f82a79b41febf6799da3b8e26a7;

class htmlButton extends htmlInput {
	
	public function __construct() {
		parent::__construct();
		$this->type = 'button';
	}
}

