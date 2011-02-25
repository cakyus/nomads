<?php

class developerDatabaseTableSchemaController {

    public function index() {
        
		$request = new request;
		$schemaTable = new databaseSchemaTable;
		$htmlDocument = new htmlDocument;
		$htmlTable = new htmlTable;
		
		$htmlDocument->addStyleUrl('developer.css');
		
		if ($schemaTable->open($request->get('tableName')) == false) {
			return false;
		}
		
		$htmlTable->headers->add('Name');
		$htmlTable->headers->add('Type');
		$htmlTable->headers->add('Size');
		$htmlTable->headers->add('AutoIncrement');
		
		foreach ($schemaTable->columns as $column) {
			$row = $htmlTable->rows->add();
			$row->add($column->name);
			$row->add($column->type);
			$row->add($column->size);
			$row->add($column->autoincrement);
		}
		
		$htmlDocument->body->appendChild($this->getHtmlMenu());
		$htmlDocument->body->appendChild($htmlTable);
		
		echo $htmlDocument->saveHTML();
    }
	
	public function edit() {
		
	}

	public function executeDelete() {
		
	}
	
	public function executeEmpty() {
		
	}
	
	public function executeCreate() {
		
	}
	
	public function executeUpdate() {
		
	}
	
	private function getHtmlMenu() {
		
		$htmlMenu = new htmlMenu;
		$request = new request;
		
		$queries = array('tableName' => $request->get('tableName'));
		
		$htmlMenu->addLocalUrl(
			 $request->get('tableName')
			,'developerDatabaseTableSchema'
			,'index'
			,$queries
			);
		
		$htmlMenu->addLocalUrl(
			 'Drop'
			,'developerDatabaseTableSchema'
			,'executeDelete'
			,$queries
			);
		
		$htmlMenu->addLocalUrl(
			 'Empty'
			,'developerDatabaseTableSchema'
			,'executeEmpty'
			,$queries
			);
		
		$htmlMenu->addLocalUrl(
			 'Modify'
			,'developerDatabaseTableSchema'
			,'edit'
			,$queries
			);
		
		$htmlMenu->addLocalUrl(
			 'Data'
			,'developerDatabaseTableData'
			,'index'
			,$queries
			);
		
		return $htmlMenu;
	}
	
	private function getHtmlTable() {
		
	}
	
}

