<?php

class Nomads_Text {
	
	public function __construct() {
		
	}
	
    // generate global unique id
    // this should be able to use when merge data from two independent server
    // 
    // original code is taken from Andrew Moore in PHP Manual's comment
    // it's a "VALID RFC 4211 COMPLIANT Universally Unique IDentifiers (UUID)"
    // http://www.php.net/manual/en/function.uniqid.php#94959
    //
    // if you write a new implementation, you should assure that
    // ALL characters are generated as random, and not an md5 or sha1 of
    // something that has less number of characters.
    // ie. something like "md5(rand())" is not good enough.
	 
	public function getUUID() {
	
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

			// 32 bits for "time_low"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),

			// 16 bits for "time_mid"
			mt_rand(0, 0xffff),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand(0, 0x0fff) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand(0, 0x3fff) | 0x8000,

			// 48 bits for "node"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
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
