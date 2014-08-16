<?php
	/**
	 * banners module controller page
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 26th Dec 2013
	 */
	 
	class Banners extends Controller {
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
			$this->view->banners = $this->model->getAllBanners( $pages->get_limit(), $nav_id );
			//create the nav menu
			$this->view->links = $pages->page_links();
			$this->view->confirmDelete = isset($this->view->confirmDelete) ? true : false;
			$this->view->adjacency = $this->model->menu_adjacency_list($nav_id, 0, 0, 'banners');
			$this->view->render('banners/index'); //then pass this to the view, may be different depending on the system
		}
		
		public function create() {			
			$this->view->new_form = true;
			$this->view->adjacency = $this->model->menu_adjacency(0, 0, 0, 0);
        	$this->view->render('banners/form');
    	}
		
		public function update($bnr_id) {			
			$this->view->banner = $this->model->getBanner($bnr_id);
			$this->view->adjacency = $this->model->menu_adjacency(0, $this->view->banner->bnr_parent, 0, 0);
			if ($this->view->banner)
				$this->view->new_form = false;
			else
				$this->view->new_form = true;
	        $this->view->render('banners/form');
		}
		
		public function save(){
			if(!($_POST))
				header('location: ' . ADMIN_URL . '/banners/create');
			//var_dump($_POST);
			
			// do formDataSave() in the menuModel, passing POST via params			
	        $save_success = $this->model->formDataSave();
			$this->view->errors = $this->model->errors;
        	if ( $save_success ) : // check save status
				$action = $save_success == 1 ? 'created' : 'updated';
            	setcookie("BannerCookie", $action, time()+60);  /* expire in 1 min(60 sec) */
				header('location: ' . ADMIN_URL . '/banners/lists');// if YES, then redirect
				//echo 'success';
    	   	else :
				$this->view->new_form = empty($_POST['banner_id']) ? true : false;
				$this->view->adjacency = $this->model->menu_adjacency(0, $_POST['banner_parent'], 0, 0);
    	        $this->view->render('banners/form');
			endif;
		}
		
		public function delete($bnr_id = false, $confirm = false) {
			if($bnr_id == false)
				header('location: ' . ADMIN_URL . '/banners/lists');

			$this->view->banner = $this->model->getBanner($bnr_id);
			$this->view->bnr_id = $bnr_id;
			if (is_object($this->view->banner) && ($confirm == false)) :
				$this->view->confirmDelete = true;
			endif;
			if (is_object($this->view->banner) && ($confirm == true)) :
				//setcookie("BannerCookie", 'removed', time()+60);  /* expire in 1 min(60 sec) */
				$this->model->delete($bnr_id);				
				header('location: ' . ADMIN_URL . '/banners/lists');// if YES, then redirect
			endif;
			$this->lists(); 
		}
		
		public function deleteall(){
			if(!isset($_POST))
				header('location: ' . ADMIN_URL . '/banners/lists');
				
			if( isset($_POST['yesall']) ):
				foreach ( $_POST['banid'] as $key=>$value ) :
					$this->model->delete($key);
				endforeach;
				setcookie("BannerCookie", 'removed', time()+60);  /* expire in 1 min(60 sec) */
				header('location: ' . ADMIN_URL . '/banners/lists');// if YES, then redirect
			elseif ( !empty($_POST['banid']) ):
				$this->view->deleteAll = true;
				$this->lists();
			else:
				$this->lists();
			endif;
		}
		
		public function order($nav_id = 0){
			$this->view->banners = $this->model->getAllBannersOrder($nav_id);
			$this->view->adjacency = $this->model->menu_adjacency_list($nav_id, 0, 0, 'banners', 'order');
			$this->view->render('banners/order');
		}
		
		public function ajax_order(){
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
				$this->model->updateAllBannersOrder();
				return true;
			else :
				$this->view->render('error/index');
			endif;
		}
		
	}