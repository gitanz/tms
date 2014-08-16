<?php
	/**
	 * Frontend Template Section
	 *
	 * @package marvelousnepal
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 07th Jan 2014
	 */
	 
	 // dev error reporting
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	
	// checking for minimum PHP version
	if (version_compare(PHP_VERSION, '5.3.7', '<'))
    	exit("Sorry, Axil Framework does not run on a PHP version smaller than 5.3.7 !");
		
	// loading config
	require 'libraries/configuration.php';
	
	// loading the Official PHP Password Hashing Compatibility Library
	require 'myadmin/libraries/other/PasswordCompatibilityLibrary.php';
	
	// the autoloading function, which will be called every time a file "is missing"
	function autoload($class) {
	    // if file does not exist in LIBS folder [set it in config/config.php],
    	// then check in LIBS/external
		if (file_exists('libraries/classes/' . $class . ".php"))
    	    require 'libraries/classes/' . $class . ".php";
	    else
    	    require 'libraries/classes/' . "external/" . $class . ".php";
	}
	
	// spl_autoload_register defines the function that is called every time a file is missing. as we created this
	// function above, every time a file is needed, autoload(THENEEDEDCLASS) is called
	spl_autoload_register("autoload");
	
	// start template app
	$templateApp = new TemplateApp();
	
	//initiate counter
	$visitors = new Count_visitors; 
	$visitors->delay = 1; // how often (in hours) a visitor is registered in the database (default = 1 hour)
	$visitors->insert_new_visit(); // That's all, the validation is with this method, too.