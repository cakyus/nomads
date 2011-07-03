<?php

class Nomads_Database_Table {
	
	public $name;
	public $fields;
	public $indexes;
	
	public function __construct() {
		$this->fields = array();
		$this->indexes = array();
	}
	
	public function __destruct() {
		unset($this->fields);
		unset($this->indexes);
	}
	
	public function open($name) {
		
		$this->name = $name;
		$this->fields = $this->getFields();
		$this->indexes = $this->getIndexes();
		
		return true;
	}
	
	private function getFields() {
		
		$database = new Nomads_Database;
		
		$sql = 'SHOW COLUMNS FROM `'.$this->name.'`';
		
        if (!$queryFields = $database->query($sql)) {
            return false;
        }
		
		$fields = array();
		foreach ($queryFields as $queryField) {
			$field = new Nomads_Database_Field;
			$field->loadQuery($queryField);
			$fields[$field->name] = $field;
		}
		
		return $fields;
	}
	
	private function getIndexes() {
		
		$database = new Nomads_Database;

		$sql = 'SHOW INDEXES FROM `'.$this->name.'`';
		
		$indexes = array();
        if ($tableIndexes = $database->query($sql)) {
            $indexName = '';
            foreach ($tableIndexes as $tableIndex) {
				//echo $tableIndex['Column_name']."\n";
                
                if ($indexName != $tableIndex['Key_name']) {
					
                    // add new index
					$index = new Nomads_Database_Index;
					
                    $indexName = $tableIndex['Key_name'];
					$index->name = $indexName;
					$indexes[$indexName] = $index;
                    
                    // @todo indexType = index
                    if ($tableIndex['Key_name'] == 'PRIMARY') {
						$index->isPrimaryKey = true;
						$index->isUnique = false;
                    } else {
						$index->isPrimaryKey = false;
						$index->isUnique = true;
                    }
                }
                
				$field = $this->fields[$tableIndex['Column_name']];
				$index->appendField($field);			
            }
        }
        
        return $indexes;
	}
	
	public function getField($name) {
		foreach ($this->fields as $field) {
			if ($field->name == $name) {
				return $field;
			}
		}
		return null;
	}
	
	public function getIndex($name) {
		foreach ($this->indexes as $index) {
			if ($index->name == $name) {
				return $index;
			}
		}
		return null;
	}
	
	public function getIndexPrimaryKey() {
		foreach ($this->indexes as $index) {
			if ($index->isPrimaryKey) {
				return $index;
			}
		}
		return null;
	}
	
	public function getIndexPrimaryKeyFieldNames() {
		
		$fieldNames = array();
		
		if ($index = $this->getIndexPrimaryKey()) {
			foreach ($index->fields as $field) {
				$fieldNames[] = $field->name;
			}
		}
		
		return $fieldNames;
	}
	
	public function getFieldAutoIncrement() {
		foreach ($this->fields as $field) {
			if ($field->autoIncrement) {
				return $field;
			}
		}
		return null;
	}
}
