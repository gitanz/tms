<?php
	/**
	 * Admin Section
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 11th Dec 2013
	 */
	 
	 // dev error reporting
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	
	// checking for minimum PHP version
	if (version_compare(PHP_VERSION, '5.3.7', '<'))
    	exit("Sorry, Admin module does not run on a PHP version smaller than 5.3.7 !");
		
	// loading config
	require '../libraries/configuration.php';
	
	// loading the Official PHP Password Hashing Compatibility Library
	require 'libraries/other/PasswordCompatibilityLibrary.php';
	
	// the autoloading function, which will be called every time a file "is missing"
	// NOTE: don't get confused, this is not "__autoload", the now deprecated function
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
	
	// start admin app
	$adminApp = new AdminApp();