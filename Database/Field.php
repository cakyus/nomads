<?php

class Nomads_Database_Field {

    public $name;
    public $type;
    public $size;
    public $isNull;
    public $defaultValue; 
	public $autoIncrement;
	
	public function loadQuery($data) {
		
		$this->name = $data['Field'];
		
		if ($data['Null'] == 'NO') {
			$this->isNull = false;
		} else {
			$this->isNull = true;
		}
		
		if ($data['Extra'] == 'auto_increment') {
			$this->autoIncrement = true;
		} else {
			$this->autoIncrement = false;
		}
		
        if (preg_match("/^([^\(]+)\(([0-9]+)\)$/", $data['Type'], $match)) {			
            $this->type = $match[1];
            $this->size = $match[2];
        } else {
			$this->type = $data['Type'];
        }
		
		$this->defaultValue = $data['Default'];
	}
	
	public function isTypeString() {
		if ($this->type == 'text') {
			return true;
		} elseif (strstr($this->type,'varchar')) {
			return true;
		} elseif (strstr($this->type,'char')) {
			return true;
		}
		return false;
	}
}
