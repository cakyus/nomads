<?php

class Nomads_Text {
	
	public function __construct() {
		
	}
	
	public function newGUID() {
		return str_replace(array("{", "-", "}"), "", com_create_guid());
	}
	
	public function formatByte($Number) {
	
		$Unit = array(' B', 'KB', 'MB', 'GB', 'TB');
		$Index = 0;
		
		while ($Number > 1024) {
			$Number = $Number / 1024;
			$Index++;
		}
		
		return number_format($Number,2).' '.$Unit[$Index];
	}	
}