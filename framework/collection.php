<?php

/**
 * collection
 **/

class collection implements Iterator {
	
	private $values;
	private $keywords;
	private $position;
	
	public function __construct() {
		$this->keywords = array();
		$this->values = array();
		$this->position = 0;
	}
	
	public function rewind() {
		$this->position = 0;
	}
	
    public function current() {
        return $this->values[$this->position];
    }

    public function key() {
        return $this->keywords[$this->position];
    }

    public function next() {
        ++$this->position;
    }

    public function valid() {
        return isset($this->values[$this->position]);
    }
	
	public function append($object=null, $keyword=null) {
	
		if (is_null($keyword)) {
			$keyword = count($this->values);
		} elseif (isset($this->keywords[$keyword])) {
			trigger_error("keyword is already in collection. '".$keyword."'");
			return false;
		}
		
		$this->keywords[] = $keyword;
		$this->values[] = $object;
		
		return $keyword;
	}
    
    public function remove($keyword) {
        
		for ($i=0; $i<count($this->keywords); $i++) {
			if ($this->keywords[$i] == $keyword) {
				unset($this->keywords[$i]);
				unset($this->values[$i]);
				return true;
			}
		}
		
		return false;
    }
	
    public function set($keyword, $value) {
        
		for ($i=0; $i<count($this->keywords); $i++) {
			if ($this->keywords[$i] == $keyword) {
				$this->values[$i] = $value;
				return true;
			}
		}
		
		$this->append($value, $keyword);
		return false;
    }
	
	public function item($keyword) {
		
		for ($i=0; $i<count($this->keywords); $i++) {
			if ($this->keywords[$i] == $keyword) {
				return $this->values[$i];
			}
		}
		
		return false;
	}
	
	public function count() {
		return count($this->values);
	}

	public function clear() {
		$this->__construct();
	}
}

