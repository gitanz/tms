<?php
class News extends Controller{
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
		$this->view->news = $this->model->getAllNews( $pages->get_limit());
		$this->view->links = $pages->page_links();
		$this->view->deleteError = $error;
		$this->view->confirmDelete = isset($this->view->confirmDelete) ? true : false;
		$this->view->render("news/index");
	}
	public function create() {			
		$this->view->new_form = true;			
		$this->view->datetime = $this->datetime_sys_format(DATETIME);
    	$this->view->render('news/form');
	}
	public function save(){
		$saveresponse = $this->model->saveFormData($_POST);
		$this->view->errors = $this->model->errors;
		if($saveresponse):
			$action = $saveresponse == 1 ? 'created':'updated';
			setcookie("NewsCookie",$action,time()+60);
			header('location:'.ADMIN_URL.'/news/lists');
		else:
			$this->view->new_form = empty($_POST['news_id'])? true : false;
			$this->view->render('news/form');
		endif;
	}	
	public function update($newsid){
		$this->view->news = $this->model->getNews($newsid);
		$this->view->datetime = $this->datetime_sys_format($this->view->news->news_added);
		if($this->view->news):
			$this->view->new_form = false;
		else:
			$this->view->new_form = true;
		endif;
		$this->view->render('news/form');
	}
	public function delete($newsid){
		$response = $this->model->delete($newsid,true);
		if($response):
			$this->view->confirmDelete = true;
			$this->view->newsid = $newsid;
		else:
			$this->view->deleteError = true;
		endif;	
		$this->lists();
	}
	public function confirmDelete($newsid){
		$response = $this->model->deleteNow($newsid);
		if($response):
			$this->lists();
			header("location:".ADMIN_URL."/news/lists");
		else:
			$this->view->deleteError = true;
			$this->lists();
		endif;
	}
	public function deleteAll($confirm = true){
		if(!isset($_POST['news']))
			header('location:'.ADMIN_URL.'/news/lists');
		if(isset($_POST['newsid']))
			foreach($_POST as $value){
				if(is_array($value)) $response = $this->model->deleteAll(array_keys($value));
				if($response) $this->lists();
				if(!$response) $this->lists($error = true);
				}
		
	}
}

			



		

			

