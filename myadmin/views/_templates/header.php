<?php
	/**
	 * header page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 11th Dec 2013
	 */
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
	    <title>AxilTMS <?=ADMIN_VERSION?> &lsaquo; <?=SITE_NAME?></title>
    	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta name="description" content="">
	    <meta name="author" content="">

    	<link rel="stylesheet" type="text/css" href="<?=ADMIN_URL?>/public/lib/bootstrap/css/bootstrap.min.css">    
	    <link rel="stylesheet" type="text/css" href="<?=ADMIN_URL?>/public/stylesheets/theme.css">
    	<link rel="stylesheet" type="text/css" href="<?=ADMIN_URL?>/public/stylesheets/elements.css">
        <link rel="stylesheet" type="text/css" href="<?=ADMIN_URL?>/public/stylesheets/bootstrap-tagsinput.css">
        <link rel="stylesheet" type="text/css" href="<?=ADMIN_URL?>/public/stylesheets/bootstrap-spinner.css">

        <?php if (Session::get('admin_logged_in') == true):?>
        <link rel="stylesheet" type="text/css" href="<?=ADMIN_URL?>/public/lib/font-awesome/css/font-awesome.css">
        <?php endif; ?>

	    <script src="<?=ADMIN_URL?>/public/javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="<?=SITE_URL?>/myadmin/public/javascripts/jquery.searchable.min.js"></script>

	    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    	<!--[if lt IE 9]>
	    	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    	<![endif]-->
	</head>
    
    <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  	<!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  	<!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  	<!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  	<!--[if (gt IE 9)|!(IE)]><!--> 
  	<body class=""> 
  	<!--<![endif]-->    
	    <div class="navbar">
    	    <div class="navbar-inner">
                <ul class="nav pull-right">
                    <li><a href="<?=SITE_URL?>" target="_blank" class="hidden-phone visible-tablet visible-desktop" role="button">Site</a></li>
                <?php if (Session::get('admin_logged_in') == true):?>
                	<li><a href="<?=ADMIN_URL?>/system/settings" class="hidden-phone visible-tablet visible-desktop" role="button">Site Settings</a></li>
                    <li id="fat-menu" class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i> <?php echo Session::get('admin_name'); ?>
                            <i class="icon-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="<?=ADMIN_URL?>/users/my_profile">My Account</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" class="visible-phone" href="<?=SITE_URL?>">Site</a></li>
                             <li><a tabindex="-1" class="visible-phone" href="<?=ADMIN_URL?>/system/settings">Site Settings</a></li>
                            <li class="divider visible-phone"></li>
                            <li><a tabindex="-1" href="<?=ADMIN_URL?>/users/logout">Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                </ul>
                <a class="brand" href="<?=ADMIN_URL?>" title="Home"><span class="second"><?=SITE_NAME?></span></a>
        	</div>
    	</div>