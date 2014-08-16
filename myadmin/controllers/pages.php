<?php
	/**
	 * page module controller page
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 24th Dec 2013
	 */
	 
	class Pages extends Controller {
		function __construct() {
        	parent::__construct();
			$redirect_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";			
			Authorize::handleLogin($redirect_link); //check user is logged or not
    	}
		
		public function index() { $this->lists(); }
		
		public function lists($nav_id = false) {
			//create a new object
			$pages = new Paginator(PER_PAGE, 'page');
			//set the total records, calling a method to get the number of records from a model
			$pages->set_total( $this->model->get_all_count() );
			//calling a method to get the records with the limit set
			$this->view->pages = $this->model->getAllPages( $pages->get_limit(), $nav_id );
			//create the nav menu
			$this->view->links = $pages->page_links();
			$this->view->confirmDelete = isset($this->view->confirmDelete) ? true : false;
			$this->view->adjacency = $this->model->menu_adjacency_list($nav_id, 0, 0);
			$this->view->render('pages/index'); //then pass this to the view, may be different depending on the system
		}
		
		public function create() {			
			
			$this->view->new_form = true;			
			$this->view->adjacency = $this->model->menu_adjacency(0, 0, 0, 0);
			$this->view->datetime = $this->datetime_sys_format(DATETIME);
			$this->view->order = $this->model->getOrder();
        	$this->view->render('pages/form');
    	}
		
		public function update($pag_id) {			
			$this->view->page = $this->model->getPage($pag_id);
			$this->view->adjacency = $this->model->menu_adjacency(0, $this->view->page->page_parent, 0, 0);
			$this->view->datetime = $this->datetime_sys_format($this->view->page->page_added);
			$this->view->order = $this->model->getOrder();
			if ($this->view->page) :
				$this->view->new_form = false;
			else:
				$this->view->new_form = true;
			endif;
	        $this->view->render('pages/form');
		}
		
		public function save(){
			if(!($_POST))
				header('location: ' . ADMIN_URL . '/pages/create');
			//var_dump($_POST);			
			// do formDataSave() in the pagesModel, passing POST via params			
	        $save_success = $this->model->formDataSave();
			$this->view->adjacency = $this->model->menu_adjacency(0, $_POST['page_parent'], 0, 0);
			$this->view->errors = $this->model->errors;
        	if ( $save_success ) : // check save status
				$action = $save_success == 1 ? 'created' : 'updated';
            	setcookie("PageCookie", $action, time()+60);  /* expire in 1 min(60 sec) */
				header('location: ' . ADMIN_URL . '/pages/lists');// if YES, then redirect
				//echo 'success';
    	   	else :
				$this->view->new_form = empty($_POST['page_id']) ? true : false;
    	        $this->view->render('pages/form');
			endif;
		}
		
		public function datetime_format($datetime) {
			return $this->model->datetime_format($datetime);	
		}
		
		public function delete($pag_id = false, $confirm = false) {
			if($pag_id == false)
				header('location: ' . ADMIN_URL . '/pages/lists');

			$this->view->page = $this->model->getPage($pag_id);
			$this->view->pagid = $pag_id;
			if (is_object($this->view->page) && ($confirm == false)) :
				$this->view->confirmDelete = true;
			endif;
			if (is_object($this->view->page) && ($confirm == true)) :
				setcookie("PageCookie", 'removed', time()+60);  /* expire in 1 min(60 sec) */
				$this->model->delete($pag_id);				
				header('location: ' . ADMIN_URL . '/pages/lists');// if YES, then redirect
			endif;
			$this->lists(); 
		}
		
		public function deleteall(){
			if(!isset($_POST))
				header('location: ' . ADMIN_URL . '/pages/lists');
				
			if( isset($_POST['yesall']) ):
				foreach ( $_POST['pagid'] as $key=>$value ) :
					$this->model->delete($key);
				endforeach;
				setcookie("PageCookie", 'removed', time()+60);  /* expire in 1 min(60 sec) */
				header('location: ' . ADMIN_URL . '/pages/lists');// if YES, then redirect
			elseif ( !empty($_POST['pagid']) ):
				$this->view->deleteAll = true;
				$this->lists();
			else:
				$this->lists();
			endif;
		}
	}