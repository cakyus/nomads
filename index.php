<?php

// report all error
error_reporting(E_ALL);

// output buffering
ob_start();

// configuration
$config['Framework']['controllerDefault'] = 'Welcome';
$config['Framework']['functionDefault'] = 'index';

$config['Framework']['path'] = __DIR__;
$config['Framework']['libraryPath'] = $config['Framework']['path'].'/library';
$config['Framework']['applicationPath'] = $config['Framework']['path'].'/application';

// overwrite configuration with config.php, if exits
// config.php is included in .gitignore
if (is_file($config['Framework']['path'].'/config.php')) {
	include($config['Framework']['path'].'/config.php');
}

// loader
function __autoload($className) {
	
	global $config;
	
	$classPath = '';
	
	// application Controller and View
	if (preg_match("/^([^_]+)(.+)*_(Controller|View)$/", $className, $match)) {

		$namespaceName = $match[1];
		$classChildName = $match[2];
		$classTypeName = $match[3];
		
		if (empty($classChildName)) {
			$classPath = $config['Framework']['applicationPath']
				.'/'.strtolower($namespaceName)
				.'/'.strtolower($classTypeName)
				.'/'.$classTypeName.'.php'
				;
		}
	}
	
	if (is_file($classPath)) {
		require_once($classPath);
		return true;
	}
	
	// library
	$classPath = $config['Framework']['libraryPath']
		.'/'.str_replace('_', '/', $className)
		.'.php'
		;
	
	if (is_file($classPath)) {
		require_once($classPath);
		return true;
	}
	
	trigger_error("Unable to load class $className");
	return false;
}

// error handler
// @todo error handler

// debugging
function d($var) {
	ob_clean();
	header('Content-type: text/plain');
	$debug = debug_backtrace();
	echo "file: ".$debug[0]["file"]."\n"
		."line: ".$debug[0]["line"]."\n"
		."\n"
		;
	var_dump($var); exit();
}

// error handler
function my_error_handler($errno, $errstr, $errfile, $errline) {

    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

	ob_clean();
	header('Content-type: text/plain');
    
    switch ($errno) {
    case E_USER_ERROR:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "$errno E_USER_NOTICE $errfile on line $errline"
        	."\n\n$errstr"
        	;
        break;

    default:
        echo "$errno UNKNOWN $errfile on line $errline"
        	."\n\n$errstr"
        	;
        break;
    }
    

    return true;
}

// set to the user defined error handler
$old_error_handler = set_error_handler("my_error_handler");

// request handler
if (isset($_REQUEST['p'])) {
	$path = $_REQUEST['p'];
} else {
	$path = '/';
}

$item = explode('/', $path);

//		class
if (empty($item[1])) {
	$class = $config['Framework']['controllerDefault'];
} else {
	$class = ucfirst($item[1]);
}

//		function
if (empty($item[2])) {
	$function = $config['Framework']['functionDefault'];
} else {
	$function = $item[2];
}

// 		arguments
if (empty($item[3])) {
	$arguments = array();	
} else {
	$arguments = array_slice($item, 3);
}

$class .= '_Controller';

#echo 'class: '.$class
#	.'<br />function: '.$function
#	.'<br />arguments: '.implode(',', $arguments)
#	;

call_user_func_array(array($class, $function), $arguments);

