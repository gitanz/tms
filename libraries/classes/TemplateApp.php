<?php
	/**
	 * Template Main Class
	 *
	 * @package marvelousnepal
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 07th Jan 2014
	 */
	 
	 class TemplateApp {
		private $_url = null;
		private $_controller = null;
		//trying to implement restful _anz
		private $_itinerary = null;
		private $_controllerPath = 'controllers/'; // Always include trailing slash
		private $_modelPath = 'models/'; // Always include trailing slash
		private $_errorFile = 'error.php';
		private $_defaultFile = 'index.php';
		
		/**
		 * Starts the site template
		 */
		public function __construct(){
			// Sets the protected $_url
			$this->_getUrl();
	
			// Load the default controller if no URL is set
			// eg: Visit http://localhost it loads Default Controller
			if (empty($this->_url[0])) :
				$this->_loadDefaultController();
				return false;
			endif;
	
			$this->_loadExistingController();

			$this->_callControllerMethod();
		}
		
		/**
		 * Fetches the $_GET from 'url'
		 */
		private function _getUrl() {
			$url = isset($_GET['url']) ? $_GET['url'] : null;
			$url = rtrim($url, '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$this->_url = explode('/', $url);
		}
		
		/**
		 * This loads if there is no GET parameter passed
		 */
		private function _loadDefaultController() {	
			// write URL cookie
			$this->writeUrlCookie($this->_url);
	
			require $this->_controllerPath . $this->_defaultFile;
			$this->_controller = new Index();
			$this->_controller->index();
		}
		
		/**
     	 * Load an existing controller if there IS a GET parameter passed
     	 * 
     	 * @return boolean|string
     	 */
    	private function _loadExistingController() {
        	$file = $this->_controllerPath . $this->_url[0] . '.php';        	
        	if (file_exists($file)) :
            	require $file;
            	$this->_controller = new $this->_url[0];
            	$this->_controller->loadModel($this->_url[0], $this->_modelPath);
        	else:
            	$this->_error();
            	return false;
        	endif;
    	}
		
		/**
     	 * If a method is passed in the GET url parameter
     	 * 
     	 *  http://localhost/controller/method/(param)/(param)/(param)
     	 *  url[0] = Controller
     	 *  url[1] = Method (= "Action")
     	 *  url[2] = Param
     	 *  url[3] = Param
     	 *  url[4] = Param
     	 */
    	private function _callControllerMethod() {
	        $length = count($this->_url);

    	    // Make sure the method we are calling exists
        	if ($length > 1) :
            	if (!method_exists($this->_controller, $this->_url[1])) :
                	$this->_error();	                
	                exit;
    	        endif;
        	endif;

	        // write URL cookie
    	    $this->writeUrlCookie($this->_url);
        
        	// Determine what to load
	        switch ($length) :
    	        case 5:
        	        //Controller->Method(Param1, Param2, Param3)
            	    $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
                break;
            
	            case 4:
    	            //Controller->Method(Param1, Param2)
        	        $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
            	break;
            
	            case 3:
    	            //Controller->Method(Param1, Param2)
        	        $this->_controller->{$this->_url[1]}($this->_url[2]);
            	break;
            
            	case 2:
                	//Controller->Method(Param1, Param2)
                	$this->_controller->{$this->_url[1]}();
                break;
            
            	default:
                	$this->_controller->index();
                break;
        	endswitch;
	    }
		
		/**
		 * write a cookie that says where exactly the user currently is
		 * (to help finding your last location after coming back to the page)
		 */
		private function writeUrlCookie($url_array) {
	
			if (count($url_array) > 0)
				$url = implode("/", $url_array);
			else
				$url = "index";			
	
			setcookie('sitelastvisitedpage', $url, time() + COOKIE_RUNTIME, "/", COOKIE_DOMAIN);
		}
		
		/**
     	 * Display an error page if nothing exists
     	 * 
     	 * @return boolean
     	 */
    	private function _error() {
        	require $this->_controllerPath . $this->_errorFile;
	        $this->_controller = new Error();
    	    $this->_controller->index();
        	// TODO: how to do this better ? exit; is not really good...
	        exit;
    	    //return false;
	    }
	 }