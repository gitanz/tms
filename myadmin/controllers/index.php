<?php
	/**
	 * Controller index page
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 11th Dec 2013
	 */
	 
	 class Index extends Controller {    
	    function __construct() {
        	parent::__construct();
			// VERY IMPORTANT: All controllers/areas that should only be useable by logged-in users
	        // need this line! Otherwise not-logged in users could do actions
    	    // if all of your pages should only be useable by logged-in users: Put this line into
        	// libs/Controller->__construct
			Authorize::handleLogin(); 
    	}

	    function index() {			
			$model = new Model();
			$this->view->menuTotal = $model->countTableValue( TABLE_PREFIX.'navigations' );
			$this->view->pagesTotal = $model->countTableValue( TABLE_PREFIX.'pages' );
			$this->view->visitsTotal = $model->countVisitsTableValue();
			$this->view->uniqueVisitsTotal = $model->countVisitsTableValue(true);
			
			$this->view->menus = $model->get_latest_menus();
			$this->view->pages = $model->get_latest_pages();
			$this->view->visits = $model->get_latest_visits();
			
            $this->view->render('index/index');
    	}
	}