<?php
	/**
	 * media controller page
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 16th Dec 2013
	 */
	 
	class Media extends Controller {
		
		function __construct() {
        	parent::__construct();
			$redirect_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";			
			Authorize::handleLogin($redirect_link); //check user is logged or not
    	}
		
		public function index() {
			$this->view->render('media/index');	
		}
		
	}
	 
	 