<?php
	/**
	 * error controller page
	 *
	 * @package marvelousnepal
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 07th Jan 2014
	 */

	class Error extends Controller {

		function __construct() {
			parent::__construct();
		}
	
		function index() {
			// Set page title
			$this->view->Set_Site_Title( SITE_TITLE.' &#8250;   Page not found' );
			// Set page keywords
			$this->view->Set_Meta_Keywords( SITE_KEYWORDS );
			// Set page descriptions
			$this->view->Set_Meta_Description( SITE_DESCRIPTION );
			// load CSS file
			$this->loadCSS[] = '/assets/css/jquery.vegas.css'; 
			$this->view->Set_CSS( $this->loadCSS );
			// load JS file
			$this->loadJS[] = '/assets/js/jquery.vegas.min.js';
			$this->loadJS[] = '/assets/js/jquery.scrollTo-1.4.3.1-min.js'; 
			$this->view->Set_JS( $this->loadJS );
			$this->view->render('error/index');
		}
	}