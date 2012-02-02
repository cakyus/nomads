<?php

class Nomads_XML {

	public $data;

	public function __construct() {

		$this->data = new SimpleXMLElement(
			 '<?xml version=\'1.0\'?>'
			.'<XMLData />'
			);

	}

	public function Open($file) {
		$this->data = simplexml_load_file($file);
	}

	public function Save() {
		return $this->data->asXML($this->file);
	}

	public function SaveXML() {
		$doc = new DOMDocument();
		// we want a nice output
		$doc->formatOutput = true;
		$doc->loadXML($this->data->saveXML());
		return $doc->saveXML();
	}
}
