<?php

/**
 * Nomads_Storage
 **/
 
class Nomads_Storage extends Nomads_File {

	public function __construct () {
		parent::__construct();
	}
	
	public function open($filePath) {
	
		$config = new Nomads_Storage_Config;
		
		// @todo lean path from "../"
		$filePath = $config->publicPath.'/'.$filePath;
		
		return parent::open($filePath);
	}
	
	public function getURL() {
		
		$config = new Nomads_Storage_Config;
		
		$fileURL = parent::getURL();
		
		if ($fileURL) {
			return $fileURL;
		}
		
		// @todo use Nomads_URL
		// @todo lean path from "../"
		
		$publicPath = $config->publicPath;
		$filePath = $this->getPath();
		
		if (substr($filePath, 0, strlen($publicPath)) != $publicPath) {
			return false;
		}
		
		return './?p=nomads/storage/download'
			.substr($filePath, strlen($publicPath))
			;
	}
}

