<?php

class developerDatabaseController {
	
	public function index() {
		
		$schema = new databaseSchema;
		$htmlDocument = new htmlDocument;
		$htmlTable = new htmlTable;

		$htmlTable->headers->add('Name');
		
		foreach($schema->getTables() as $table) {
			
			$row = $htmlTable->rows->add();
			
			// table Name
			$row->add($table->name);
			
			// table Structure
			$url = new url;
			$url->getLocalUrl('developerDatabaseTableSchema','index');
			$url->setQuery('tableName',$table->name);
			
			$htmlAnchor = new htmlAnchor;
			$htmlAnchor->url = $url->getUrl();
			$htmlAnchor->text = 'Structure';
			
			$row->add($htmlAnchor);
			
			// table Data
			$url = new url;
			$url->getLocalUrl('developerDatabaseTableData','index');
			$url->setQuery('tableName',$table->name);
			
			$htmlAnchor = new htmlAnchor;
			$htmlAnchor->url = $url->getUrl();
			$htmlAnchor->text = 'Data';
			
			$row->add($htmlAnchor);
		}
		
		$htmlDocument->body->appendChild($htmlTable);
		$htmlDocument->title = 'Untitled';
		
		echo $htmlDocument->saveHTML();
	}
}