<?php
	/**
	 * Admin authentication class
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 11th Dec 2013
	 */
	 
	class Authorize {
    	public static function handleLogin( $goto = null ) {        
	        Session::init();
			$redirect = urlencode($goto);
        	//if(!define(ADMIN_URL)) echo 'yes'; exit;
    	    // if admin is still not logged in, then destroy session and handle user as "not logged in"
        	if (!isset($_SESSION['admin_logged_in'])) :
	            Session::destroy();
				if(!empty($goto))
	    	        // route user to login page
    	    	    header('location: ' . ADMIN_URL . '/users/index?continue='.$redirect);
				else
					header('location: ' . ADMIN_URL . '/users/index');
	        endif;
    	}
	}