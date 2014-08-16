<?php
	/**
	 * Controller index page
	 * @package himalayanPursuits
	 */
	class News extends Controller {
		public $loadCSS = array();
		public $loadJS = array();
		
		function __construct() {
        	parent::__construct();
    	}
    	function index($id = false){
    		if(!$id):
    		$results = $this->model->getAllNews();
    		$this->view->listing = true;
    		$this->view->results = $results;
    		$this->view->render("content/news");
    		else:
    		$result = $this->model->getNews($id);
    		$this->view->listing = false;
    		$this->view->result = $result;
    		$this->view->render("content/news");
    		endif;
    	}
    }