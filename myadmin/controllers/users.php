<?php
	/**
	 * user controller page
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 11th Dec 2013
	 */
	 
	 class Users extends Controller {
		 function __construct() {
        	// "As long as myChild has no constructor, the parent constructor will be called / inherited."
    	    // This means wenn a class thats extends another class has a __construct, it needs to construct
	        // the parent in that constructor, like this:
        	parent::__construct();
    	}
		
		function index() {
			if (Session::get('admin_logged_in') == false)
	        	$this->view->render('users/index');
			else
				header( 'Location: '.ADMIN_URL );
    	}
		
		function login() {
			// run the login() method in the login-model, put the result in $login_successful (true or false)
	        $login_successful = $this->model->login();
					
    	    // put the errors from the login model into the view (so we can display them in the view)
	        $this->view->errors = $this->model->errors;
			
			// do site needs to be redirect is there is redirect exist
	        $redirectURL = $this->model->redirect;
			
			// check login status
        	if ($login_successful) :            
	            // if YES, then move user to secured path
        	    // please note: this is a browser-relocator, not a rendered view
				if($redirectURL == null)
	            	header('location: ' . ADMIN_URL);
				else
					header('location: ' . $redirectURL);            
            
    	   	else :            
	            // if NO, then show the users/index (login form) again
    	        $this->view->render('users/index');
        	endif;
		}		
		
		function my_profile(){
			$redirect_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";			
			Authorize::handleLogin($redirect_link); //check user is logged or not
			
			$this->view->profile = $this->model->getMyProfile();
			$this->view->render('users/profile');	
		}
		
		function save(){
			if(!($_POST))
				header('location: ' . ADMIN_URL . '/users');	
				
			$save_success = $this->model->saveFormData();
	        $this->view->errors = $this->model->errors;
        	$this->view->profile = $this->model->getMyProfile();
			$id = $this->model->profile_id;
			$goto = $id == Session::get('admin_id') ? 'users/my_profile' : 'users/profile/'.$id.'';
			if ($save_success)
            	header('location: ' . ADMIN_URL . '/'.$goto);  // if YES, then redirect
    	   	else	
	    	    $this->view->render('users/profile');
		}
		
		function logout(){
	        $this->model->logout();
    	    header('location: ' . ADMIN_URL.'/users');
	    }
		
	 }