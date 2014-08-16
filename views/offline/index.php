<?php
	if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
	/**
	 * Site Offline page
	 *
	 * @package marvelousnepal
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 07th Jan 2014
	 */	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
	    <title><?=SITE_TITLE?> is under maintenance.</title>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
    	<meta name="author" content="">

    	<link href="<?=SITE_URL?>/assets/css/bootstrap.min.css" rel="stylesheet">
	    <style type="text/css">
    	  body {
        	padding-top: 60px;
	        padding-bottom: 40px;
    	  }
	    </style>
    	<link href="<?=SITE_URL?>/assets/css/bootstrap-responsive.min.css" rel="stylesheet">

	    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    	<!--[if lt IE 9]>
	      <script src="<?=SITE_URL?>/assets/js/html5shiv.js"></script>
    	<![endif]-->

	</head>

  	<body>

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container"><a class="brand" href="<?=SITE_URL?>"><?=SITE_NAME?> Offline</a></div>
            </div>
        </div>
    
        <div class="container">
    
            <div class="hero-unit">
                <h2>SITE IS CURRENTLY <span>UNDER MAINTENANCE</span></h2>
                <p><?=SITE_OFFLINE_MSG?></p>
            </div>
            <hr>
    
            <footer>
                <p><?=SITE_COPYRIGHT?></p>
            </footer>
        </div> <!-- /container -->    

        <script src="<?=SITE_URL?>/assets/js/jquery-1.10.2.min.js"></script>
        <script src="<?=SITE_URL?>/assets/js/bootstrap.min.js"></script>
  	</body>
</html>