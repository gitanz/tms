<?php
class Testimonials extends Controller{
	function __construct(){
		parent::__construct();
		$redirect_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";			
		Authorize::handleLogin($redirect_link); //check user is logged or not
	}
	public function index(){
		$this->lists();
	}
	public function lists($error = false){
		$pages = new Paginator(PER_PAGE,'page');
		$pages->set_total( $this->model->get_all_count() );
		$this->view->testimonials = $this->model->getAllTestimonials( $pages->get_limit());
		$this->view->links = $pages->page_links();
		$this->view->deleteError = $error;
		$this->view->confirmDelete = isset($this->view->confirmDelete) ? true : false;
		$this->view->render("testimonials/index");
	}
	public function create() {			
		$this->view->new_form = true;			
		$this->view->datetime = $this->datetime_sys_format(DATETIME);
    	$this->view->render('testimonials/form');
	}
	public function save(){
		$saveresponse = $this->model->saveFormData($_POST);
		$this->view->errors = $this->model->errors;
		if($saveresponse):
			$action = $saveresponse == 1 ? 'created':'updated';
			setcookie("TestimonialCookie",$action,time()+60);
			header('location:'.ADMIN_URL.'/testimonials/lists');
		else:
			$this->view->new_form = empty($_POST['testimonial_id'])? true : false;
			$this->view->render('testimonials/form');
		endif;
	}	
	public function update($testiid){

		$this->view->testimonials = $this->model->getTestimonial($testiid);
		$this->view->datetime = $this->datetime_sys_format($this->view->testimonials->testimonial_added);
		if($this->view->testimonials):
			$this->view->new_form = false;
		else:
			$this->view->new_form = true;
		endif;
		$this->view->render('testimonials/form');
	}
	public function delete($testiid){
		$response = $this->model->delete($testiid,true);
		if($response):
			$this->view->confirmDelete = true;
			$this->view->testiid = $testiid;
		else:
			$this->view->deleteError = true;
		endif;	
		$this->lists();
	}
	public function confirmDelete($testiid){
		$response = $this->model->deleteNow($testiid);
		if($response):
			$this->lists();
			header("location:".ADMIN_URL."/testimonials/lists");
		else:
			$this->view->deleteError = true;
			$this->lists();
		endif;
	}
	public function deleteAll($confirm = true){
		if(!isset($_POST['testiid']))
			header('location:'.ADMIN_URL.'/testimonials/lists');
		if(isset($_POST['testiid']))
			foreach($_POST as $value){
				if(is_array($value)) $response = $this->model->deleteAll(array_keys($value));
				if($response) $this->lists();
				if(!$response) $this->lists($error = true);
				}
		
	}
	public function order(){
			$this->view->testimonials = $this->model->getAllTestimonialsOrder();
			$this->view->render('testimonials/order');
		}
	public function ajax_order(){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
			$this->model->updateAllTestimonialsOrder();
			return true;
		else :
			$this->view->render('error/index');
		endif;
		}
}

			



		

			

