<?php

/**
 * Nomads_Storage_Controller
 **/
 
class Nomads_Storage_Controller {

	public function __construct () {}
	
	public function download() {
				
		$storage = new Nomads_Storage;
		
		$filePath = '/'.implode('/', func_get_args());
		
		if ($storage->open($filePath)) {
			echo $storage->getContent();
		}
		
	}
}

