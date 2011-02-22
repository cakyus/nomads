<?php

class htmlElement {
	
	private $id;
	public $tagName;
	public $attributes;
	public $children;
	
	public function __construct() {
		$this->id = com_create_guid();
		$this->attributes = new collection;
		$this->children = new collection;
	}
	
	public function __destruct() {
		unset($this->attributes);
		unset($this->children);
	}
	
	public function appendChild($child) {
		$this->children->append($child);
	}
	
	public function __toString() {
		
		if (empty($this->tagName)) {
			trigger_error('tagName can\'t be empty', E_USER_ERROR);
			return '';
		}
		
		$output = '<'.$this->tagName;
		
		foreach($this->attributes as $name => $value) {
			$output .= ' '.$name.'='.htmlentities($value);
		}
		
		if ($this->children->count()) {
			$output .= '>';
			foreach($this->children as $child) {
				$output .= $child->__toString();
			}
			$output .= '</'.$this->tagName.'>';
		} else {
			$output .= ' />';
		}
		
		return $output;
	}
}