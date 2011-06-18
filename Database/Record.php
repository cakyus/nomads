<?php

/**
 * @warning field reserved name
 * - properties
 **/

class Nomads_Database_Record {
	
	private $_table;
	
	public function __destruct() {
		unset($this->_table);
	}
	
	public function open($tableName) {
		$this->_table = new Nomads_Database_Table;
		if ($this->_table->open($tableName)) {
			return true;
		}
		return false;
	}
	
	/**
	 * search database based on primary key
	 * no property in this class should be changed
	 * @return System_Database_Record
	 **/
	
	public function seek($indexName='PRIMARY') {
		
		$record = new System_Database_Record;
		$record->open($this->properties->schema->name);
		$index = $this->properties->schema->getIndex($indexName);
		foreach ($index->fields as $field) {
			$fieldName = $field->name;
			$record->{$fieldName} = $this->{$fieldName};
		}
		
		if ($record->get($indexName) == false) {
			return false;
		}
		
		return $record;
	}
	
	/**
	 * insert new record into database
	 * modified property:
	 * - autoincrement field (primary and also non-primary)
	 * @todo autoincrement
	 **/
	
	public function put() {
		
		$database = new Nomads_Database;
		
		$command = $this->getCommandPut();
		echo "$command\n"; die();
		
		if (!$database->exec($command)) {
			return false;
		}
		
		// insertid
		$field = $this->properties->schema->getFieldAutoIncrement();
		
		return true;
	}
	
	/**
	 * get record from database
	 **/
	
	public function get($indexName='PRIMARY') {
		
		$database = new System_Database;
		$command = new System_Database_Command;
		
		$command->selectIndex($this, $indexName);
		//echo($command); exit();
		
		$query = $database->query($command);
		
		if (empty($query)) {
			return false;
		}
		
		foreach ($query[0] as $name => $value) {
			$this->{$name} = $value;
		}
		
		return true;
	}
	
	public function del() {
		
		$database = new System_Database;
		$command = new System_Database_Command;
		
		$command->delete($this);
		//echo($command); exit();
		
		if (!$database->exec($command)) {
			return false;
		}
		
		return true;
	}
	
	public function set() {
		
		$database = new System_Database;
		$command = new System_Database_Command;
		
		$command->update($this);
		//echo($command); exit();
		
		if (!$database->exec($command)) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * @return System_Database_Record_Properties
	 **/
	
	public function getProperties() {
		return $this->properties;
	}
	
	private function getCommandPut() {
	
		$database = new Nomads_Database;
	
		$command = 'INSERT INTO `'.$this->_table->name.'`';
		
		// autoincrement field is not included
		// @assumption there is only one autoincrement field in a table
		// @assumption there is more than one field which not autoincrement
		
		$fieldNames = array();
		$fieldValues = array();
		
		foreach ($this->_table->fields as $field) {
			if ($field->autoIncrement) {
				continue;
			}
			
			$fieldNames[] = '`'.$field->name.'`';
			
			// @assumption special field names are: timeCrate, timeUpdate
			if (	$field->name == 'timeCreate'
				||	$field->name == 'timeUpdate'
				) {
				$fieldValues[] = time();
			} elseif ($field->isTypeString()) {
				$fieldValues[] = $database->quote($this->{$field->name});
			} else {
				$fieldValues[] = $this->{$field->name};
			}
		}
		
		$command .= ' ('.implode(',',$fieldNames).')';
		$command .= ' VALUES ('.implode(',',$fieldValues).')';
		
		return $command;
	}
}
