<?php

class databaseSchemaTable {
	
	public $name;
	public $columns;
	public $indexes;
	
	public function __construct() {
		$this->columns = new collection;
		$this->indexes = new collection;
	}
	
	public function __destruct() {
		unset($this->columns);
		unset($this->indexes);
	}
	
	public function open($name) {
		
		if ($this->getColumns($name) && $this->getIndexes($name)) {
			$this->name = $name;
			return true;
		}
		
		return false;
	}
		
	
	public function create() {
		
	}
	
	public function delete() {
		
	}
	
	public function update() {
		
	}
	
	private function getColumns($tableName) {
		
		$database = new database;
		
		$sql = 'SHOW COLUMNS FROM `'.$tableName.'`';
		
		if (!$query = $database->query($sql)) {
			return false;
		}
			
		foreach ($query as $row) {
			
			$column = new databaseSchemaColumn;
			
			// name
			$column->name = $row['Field'];
			
			// type, size
			if (preg_match("/^[a-z]+$/",$row['Type'],$match)) {
				$column->type = $match[0];
				$column->size = 0;
			} elseif (preg_match("/^([a-z]+)\(([0-9]+)\)$/",$row['Type'],$match)) {
				$column->type = $match[1];
				$column->size = $match[2];				
			} else {
				trigger_error('can\'t parse field type of '
					.$this->name.'.'.$column->name
					,E_USER_ERROR
					);
			}
			
			// autoincrement
			if ($row['Extra'] == 'auto_increment') {
				$column->autoincrement = true;
			} else {
				$column->autoincrement = false;				
			}
			
			$this->columns->append($column, $column->name);
		}
		
		return true;
	}
	
	private function getIndexes($tableName) {
		
		$database = new database;
		
		$sql = 'SHOW INDEXES FROM `'.$tableName.'`';
		
		if (!$query = $database->query($sql)) {
			return false;
		}
		
		$keyName = '';
		
		foreach ($query as $row) {
			
			if (empty($keyName) || $keyName != $row['Key_name']) {
				$keyName = $row['Key_name'];
				$index = new databaseSchemaIndex;
				$index->name = $keyName;
				if ($row['Non_unique'] == 0) {
					$index->unique = true;
				} else {
					$index->unique = false;
				}
			}
			
			if ($column = $this->columns->item($row['Column_name'])) {
				$index->columns->append($column);
			} else {
				trigger_error(
					 'can\'t find column "'.$row['Column_name'].'"'
					.' of index "'.$row['Key_name'].'"'
					.' in table "'.$tableName.'"'
					,E_USER_ERROR
					);
			}
			
			$this->indexes->append($index, $index->name);
		}
		
		return true;
	}
}