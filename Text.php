<?php

class Nomads_Text {
	
	public function __construct() {
		
	}
	
    // generate global unique id
    // this should be able to use when merge data from two independent server
	 
	public function getGUID() {
		return str_replace(array("{", "-", "}"), "", com_create_guid());
	}
	
    // generate unique id
    // use only in a server
	 
	public function getUniqId() {
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
