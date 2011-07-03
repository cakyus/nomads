<?php

// report all error
error_reporting(E_ALL);

// output buffering
ob_start();

// configuration
define('FRAMEWORK_CONTROLLER_DEFAULT', 'Welcome');
define('FRAMEWORK_FUNCTION_DEFAULT', 'index');

define('FRAMEWORK_PATH', __DIR__);
define('FRAMEWORK_LIBRARY_PATH', FRAMEWORK_PATH.'/library');
define('FRAMEWORK_APPLICATION_PATH', FRAMEWORK_PATH.'/application');

// loader
function __autoload($class) {

}

// error handler
// @todo error handler

// debugging
function d($var) {
	// @todo show file and line number which call this function
	ob_clean();
	header('Content-type: text/plain');
	$debug = debug_backtrace();
	echo "file: ".$debug[0]["file"]."\n"
		."line: ".$debug[0]["line"]."\n"
		."\n"
		;
	var_dump($var); exit();
}

// request handler
d('ok');


