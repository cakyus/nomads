<?php

class databaseSchemaTable {
	
	public $name;
	public $columns;
	public $indexes;
	
	public function __construct() {
		$this->columns = array();
		$this->indexes = array();
	}
	
	public function open($name) {
		$this->name = $name;
	}
	
	public function create() {
		
	}
	
	public function delete() {
		
	}
	
	public function update() {
		
	}	
}