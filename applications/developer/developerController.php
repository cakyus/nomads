<?php

class developerController {

	public function index() {
		
		/**
		 * @var databaseTableSchema $table
		 **/
		
		$schema = new databaseSchema;
		$htmlDocument = new htmlDocument;
		$htmlTable = new htmlTable;

		$htmlTable->headers->add('Name');
		
		foreach($schema->getTables() as $table) {
			$row = $htmlTable->rows->add();
			$row->add($table->name);
		}
		
		$htmlDocument->body->appendChild($htmlTable);
		$htmlDocument->title = 'Untitled';
		
		echo $htmlDocument->saveHTML();
	}
}
