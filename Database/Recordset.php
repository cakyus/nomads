<?php

class System_Database_Recordset extends My_Collection {
	
	private $command;
	private $items;
	
	public function __construct() {
		parent::__construct();
		$this->command = new System_Database_Command_Recordset;
		$this->items = array();
	}
		
	public function __destruct() {
		unset($this->items);
		unset($this->command);
	}
	
	public function open($tableName) {
		return $this->command->open($tableName);
	}
		
	public function filter($fieldName, $fieldValue, $operator='=') {
		$this->command->filter($fieldName, $fieldValue, $operator);
	}
		
	public function limit($count, $offset=null) {
		$this->command->limit($count, $offset);
	}
		
	public function fetch() {
		
		$database = new System_Database;
		
		$this->command->select();
		if ($query = $database->query($this->command)) {
			foreach ($query as $row) {
				$record = new System_Database_Record;
				$record->open($this->command->getTableName());
				$record->load($row);
				$this->append($record);
			}
		}
	}
	
	/**
	 * @return System_Database_Record
	 **/
		
	public function item($index) {
		return parent::item($index);
	}
}