<?php
	/**
	 * error controller page
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 11th Dec 2013
	 */

	class Error extends Controller {

		function __construct() {
			parent::__construct();
		}
	
		function index() {
			$this->view->render('error/index');
		}
	}