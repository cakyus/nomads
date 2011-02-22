<?php

class developerController {

	public function index() {
		
		/**
		 * @var databaseTableSchema $table
		 **/
		
		$schema = new databaseSchema;
		$htmlTable = new htmlTable;

		$htmlTable->headers->add('Name');
		
		foreach($schema->getTables() as $table) {
			$row = $htmlTable->rows->add();
			$row->add($table->name);
		}
		
		echo $htmlTable;
	}
}
