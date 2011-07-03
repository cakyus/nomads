<?php

/**
 * @warning field reserved name
 * - properties
 **/

class Nomads_Database_Record {
	
	private $_table;
	
	public function __construct() {
		
	}
	
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
	 **/
	
	public function seek() {
	
		$record = clone $this;
		
		if ($record->get()) {
			return $record;
		}
		
		return false;
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
#		echo "$command\n"; die();
		
		if (!$database->exec($command)) {
			return false;
		}
		
		// update insertid for autoIncrement field
		if ($field = $this->_table->getFieldAutoIncrement()) {
			$this->{$field->name} = $database->getInsertId();
		}
		
		return true;
	}
	
	public function get() {
		
		$database = new Nomads_Database;
		
		$command = $this->getCommandGet();
#		echo($command); exit();
		
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
		
		$database = new Nomads_Database;
		
		$command = $this->getCommandDel();
		
		return $database->exec($command);
	}
	
	public function set() {
		
		$database = new Nomads_Database;
		
		$command = $this->getCommandSet();
		//echo "$command\n"; die();
		
		return $database->exec($command);
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
			
			if ($field->isTypeString()) {
				$fieldValues[] = $database->quote($this->{$field->name});
			} else {
				$fieldValues[] = $this->{$field->name};
			}
		}
		
		$command .= ' ('.implode(',',$fieldNames).')';
		$command .= ' VALUES ('.implode(',',$fieldValues).')';
		
		return $command;
	}
	
	private function getCommandSet() {
	
		$database = new Nomads_Database;
	
		$command = 'UPDATE `'.$this->_table->name.'` SET ';
		
		// autoincrement field is not included
		// @assumption there is only one autoincrement field in a table
		// @assumption there is more than one field which not autoincrement
		
		$fieldCommands = array();
		$fieldPrimaryKeyFieldNames = $this->_table->getIndexPrimaryKeyFieldNames();
#		print_r($fieldPrimaryKeyFieldNames);
		
		foreach ($this->_table->fields as $field) {
			// exclude primary key fields
			if (in_array($field->name, $fieldPrimaryKeyFieldNames)) {
				continue;
			}
			
			$fieldCommand = '`'.$field->name.'` = ';
			
			if ($field->isTypeString()) {
				$fieldCommand .= $database->quote($this->{$field->name});
			} else {
				$fieldCommand .= $this->{$field->name};
			}
			
			$fieldCommands[] = $fieldCommand;
		}
		
		$command .= implode(',',$fieldCommands);
		$command .= $this->getCommandWherePrimaryKey();
		
		return $command;
	}
	
	private function getCommandDel() {
	
		$command = 'DELETE FROM `'.$this->_table->name.'` ';
		$command .= $this->getCommandWherePrimaryKey();
		
		return $command;
	}
	
	private function getCommandGet() {
	
		$command = 'SELECT * FROM `'.$this->_table->name.'` ';
		$command .= $this->getCommandWherePrimaryKey();
		
		return $command;
	}
	
	private function getCommandWherePrimaryKey() {
	
		$database = new Nomads_Database;
		
		$index = $this->_table->getIndexPrimaryKey();
		$fieldCommands = array();
		
		foreach ($index->fields as $field) {
			$fieldCommand = '`'.$field->name.'` = ';
			if ($field->isTypeString()) {
				$fieldCommand .= $database->quote($this->{$field->name});
			} else {
				$fieldCommand .= $this->{$field->name};
			}
			$fieldCommands[] = $fieldCommand;
		}
		
		if (empty($fieldCommands)) {
			trigger_error('table "'.$this->_table->name.'" has no primary key');
		}
		
		return ' WHERE '.implode(',', $fieldCommands);
	}
}
