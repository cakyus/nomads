<?php

error_reporting(E_ALL);

// configuration
define('FRAMEWORK_CLASS_DEFAULT', 'home');
define('FRAMEWORK_FUNCTION_DEFAULT', 'index');
define('FRAMEWORK_DIRECTORY_PATH', dirname(__FILE__));

function __autoload($className) {

	if (preg_match_all("/(^[a-z]+|[A-Z][a-z]+)/",$className,$dirs) ) {
		$dirs = $dirs[0];
		array_unshift($dirs,'');
		//array_pop($dirs);
	} else {
		exit('class name is invalid "'.$className.'"');
	}
	
	$dirRoots = array(
		 FRAMEWORK_DIRECTORY_PATH.'/applications'
		,FRAMEWORK_DIRECTORY_PATH.'/framework'
		);
	
	foreach ($dirRoots as $dirRoot) {
		$dirPath = $dirRoot;
		$errorMessagePath = '';
		foreach ($dirs as $dir) {
			$dirPath .= strtolower($dir).'/';
			$file = $dirPath.$className.'.php';
			$errorMessagePath .= $file.'<br />';
			if (file_exists($file)) {
				require_once($file);
				return true;
			}
		}
	}
	
	$errorMessage = 'could not locate class "'.$className.'"';
	
	//uncomment for debugging
	//$errorMessage .= '<br />'.$errorMessagePath;
	
	exit($errorMessage);
}

// request handler

if (isset($_REQUEST['c'])) {
	$c = $_REQUEST['c'];
} else {
	$c = FRAMEWORK_CLASS_DEFAULT;
}

if (isset($_REQUEST['f'])) {
	$f = $_REQUEST['f'];
} else {
	$f = FRAMEWORK_FUNCTION_DEFAULT;
}

// className and functionName sanitation
if (	preg_match("/^[a-zA-Z]+$/", $c) == false
	||	preg_match("/^[a-zA-Z]+$/", $f) == false
	) {
	exit('invalid class name or function name');
}

$c .= 'Controller';
$o = new $c;
$o->$f();

