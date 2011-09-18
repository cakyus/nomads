<?php

class Nomads_Loader {
	
	public static function setAutoload() {
		return spl_autoload_register(array(__CLASS__, 'loadClass'));	
	}
	
	public static function loadClass($class) {
		
		// find in included path
		$dirs = explode(PATH_SEPARATOR, get_include_path());
		$path = str_replace('_','/',$class).'.php';
		
		foreach ($dirs as $dir) {
			$file = $dir.'/'.$path;
			if (file_exists($file)) {
				require_once($file);
				break;
			}
		}
	}
}
