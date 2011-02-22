<?php

class databaseSchema {
	
	public function getTables() {
		
		$database = new database;
		$tables = new collection;
		
		$sql = 'SHOW TABLES';
		
		if ($query = $database->query($sql)) {
			foreach ($query as $table) {
				foreach ($table as $tableName) {
					$table = new databaseSchemaTable;
					$table->open($tableName);
					$tables->append($table, $tableName);
				}
			}
		}
		
		return $tables;
	}
}
