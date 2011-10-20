<?php

class Nomads_Loader {
	
	
	public static function setAutoload() {
		return spl_autoload_register(array(__CLASS__, 'loadClass'));	
	}
	
	public static function register() {
		// add current folder in included path
		self::addIncludePath(dirname(__DIR__));
		return spl_autoload_register(array(__CLASS__, 'loadClass'));	
	}

	public static function addIncludePath($path) {
		set_include_path(implode(PATH_SEPARATOR
			, array($path, get_include_path())
			));
	}
	
	public static function loadClass($class) {
		
		// find in included path
		$dirs = explode(PATH_SEPARATOR, get_include_path());
		// echo get_include_path();
		$path = str_replace('_','/',$class).'.php';
		
		foreach ($dirs as $dir) {
			$file = $dir.'/'.$path;
			if (file_exists($file)) {
				require_once($file);
				return true;
			}
		}
		
		// controller
		if (substr($class, -11) == '_Controller') {
			$file = APPLICATION_PATH.'/controller/'
				.str_replace('_','/',substr($class,0,-11))
				.'.php'
				;
			if (file_exists($file)) {
				require_once($file);
				return true;
			}
		}
		
		// model
		$file = APPLICATION_PATH.'/model/'
			.str_replace('_','/',$class)
			.'.php'
			;
		if (file_exists($file)) {
			require_once($file);
			return true;
		}
		
		// class already exists
		if (in_array($class, get_declared_classes())) {
			return true;
		}
		
		// fail
		trigger_error('Can\'t resolve class "'.$class.'"');
	}
}
