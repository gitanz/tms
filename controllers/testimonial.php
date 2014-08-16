<?php
	/**
	 * Controller index page
	 * @package himalayanPursuits
	 */
	class Testimonial extends Controller {
		public $loadCSS = array();
		public $loadJS = array();
		
		function __construct() {
        	parent::__construct();
    	}
    	function index($id = false){
    		if(!$id):
    		$results = $this->model->getAllTestimonials();
    		$this->view->listing = true;
    		$this->view->results = $results;
    		$this->view->render("content/testimonials");
    		else:
    		$result = $this->model->getTestimonial($id);
    		$this->view->listing = false;
    		$this->view->result = $result;
    		$this->view->render("content/testimonials");
    		endif;
    	}
    }