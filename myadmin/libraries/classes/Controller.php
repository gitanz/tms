<?php
	/**
	 * This is the "base controller class". All other "real" controllers extend this class.
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 11th Dec 2013
	 */
	
	class Controller {
		
		function __construct() {
	        // every time a controller is created, start a session
    	    // TODO: this is a singleton/static method. should this be handled in another way ?
        	Session::init();
        
	        // if user is not logged in, but has a rememberme-cookie, then try to login with cookie ("remember me" feature)
    	    if (!isset($_SESSION['admin_logged_in']) && isset($_COOKIE['rememberme']))
				// route user to cookie-auto-login controller/action
    	        header('location: ' . ADMIN_URL . '/users/loginwithcookie');	        

	        // every time a controller is created, create a view object (that does nothing, but provides the render method)
    	    $this->view = new View();
    	}
		
		/**
     	 * loads the model with the given name.
     	 * loadModel("test") would include models/test_model.php and create the object $this->model in the controller
     	 * @param string $name The name of the model
     	 */
    	public function loadModel($name) {

        	$path = 'models/' . $name . 'Model.php';

        	if (file_exists($path)) :
            	require 'models/' . $name . 'Model.php';

            	$modelName = $name . '_Model';
            	$this->model = new $modelName();
        	endif;
    	}
		
		public function datetime_sys_format($datetime){
			return date("Y-m-d H:i:s", $datetime);
		}
		
	}