<?php

class htmlDocument {

	public $body;
	public $head;
	public $title;
	
	public function __construct() {
		
		$this->head = new htmlElement;
		$this->body = new htmlElement;
		
		$this->head->tagName = 'head';
		$this->body->tagName = 'body';
	}
	
	public function __destruct() {
		unset($this->head);
		unset($this->body);
	}
	
	public function getElementById($id) {
		
	}
	
	public function getElementsByTagName($tagName) {
		
	}
	
	public function loadHTML($string) {
		
	}
	
	public function saveHTML() {
		
		$htmlDocument = new htmlElement;
		$htmlDocument->tagName = 'html';
		
		if (!empty($this->title)) {
			$htmlText = new htmlText;
			$htmlTitle = new htmlElement;
			$htmlText->appendData($this->title);
			$htmlTitle->tagName = 'title';
			$htmlTitle->appendChild($htmlText);
			$this->head->appendChild($htmlTitle);
		}
		
		$htmlDocument->appendChild($this->head);
		$htmlDocument->appendChild($this->body);
		
		return $htmlDocument->__toString();
	}
	
	public function saveXML() {
		
	}
}
