<?php

class Nomads_Collection {
	
	protected $items;
	
	public function __construct() {
		$this->items = array();
	}
	
	public function add($keyword, $value=null) {
		if (is_null($value)) {
			$value = $keyword;
			$keyword = $this->count();
		}
		$this->items[$keyword] = $value;
	}

	public function get($keyword) {
		if (isset($this->items[$keyword])) {
			return $this->items[$keyword];
		}
		return null;
	}
	
	public function exists($keyword) {
		return isset($this->items[$keyword]);
	}
	
	public function count() {
		return count($this->items);
	}
}

