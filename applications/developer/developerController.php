<?php

class developerController {

	public function index() {
		
		$schema = new databaseSchema;
		
		foreach($schema->getTables() as $table) {
			echo $table->name.'<br>';
		}
	}
}
