<?php

class Nomads_Database_Index {
	
	public $name;
	public $isPrimaryKey;
	public $isUnique;
	
	public $fields;
	
	public function __construct() {
		$this->fields = array();
	}
	
	public function __destruct() {
		unset($this->fields);
	}

	public function appendField(Nomads_Database_Field $field) {
		$this->fields[$field->name] = $field;
	}
}
