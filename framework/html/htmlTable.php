<?php

/**
 *
 * @usage
 * 
 * $table = new htmlTable;
 *
 * $table->headers->add('ID');
 * $table->headers->add('Name');
 *
 * $row = $table->rows->add();
 * $row->add('1');
 * $row->add('You');
 * 
 **/

class htmlTable extends htmlElement {
	
	public $headers;
	public $rows;
	
	public function __construct() {
		parent::__construct();
		$this->tagName = 'table';
		$this->headers = new htmlTableHeaderCollection;
		$this->rows = new htmlTableRowCollection;
	}
	
	public function __destruct() {
		unset($this->headers);
		unset($this->rows);
	}
	
	public function __toString() {
		$this->children->append($this->headers);
		$this->children->append($this->rows);
		return parent::__toString();
	}
}