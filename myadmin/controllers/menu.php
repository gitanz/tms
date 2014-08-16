<?php
	/**
	 * menu module controller page
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 17th Dec 2013
	 */
	 
	class Menu extends Controller {
		function __construct() {
        	parent::__construct();
			$redirect_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";			
			Authorize::handleLogin($redirect_link); //check user is logged or not
    	}
		
		public function index() { $this->lists(); }
		
		public function lists() {
			$this->view->menus = $this->model->getAllMenus();
			$this->view->confirmDelete = isset($this->view->confirmDelete) ? true : false;
			$this->view->render('menu/index');
		}
		
		public function create() {
			$this->view->new_form = true;
			$this->view->adjacency = $this->model->menu_adjacency(0, 0, 0, 0);
        	$this->view->render('menu/form');
    	}
		
		public function update($nav_id) {			
			$this->view->menu = $this->model->getMenu($nav_id);
			$this->view->adjacency = $this->model->menu_adjacency($nav_id, $this->view->menu->nav_parent, 0, 0);
			if ($this->view->menu) :
				$this->view->new_form = false;
			else:
				$this->view->new_form = true;
			endif;
	        $this->view->render('menu/form');
		}
		
		public function save(){
			if(!($_POST))
				header('location: ' . ADMIN_URL . '/menu/create');
			//print_r($_POST);
			
			// do formDataSave() in the menuModel, passing POST via params			
	        $save_success = $this->model->formDataSave();
			$this->view->errors = $this->model->errors;
        	if ( $save_success ) : // check save status
				$action = $save_success == 1 ? 'created' : 'updated';
            	setcookie("MenuCookie", $action, time()+60);  /* expire in 1 min(60 sec) */
				header('location: ' . ADMIN_URL . '/menu/lists');// if YES, then redirect
				//echo 'success';
    	   	else :
				$this->view->new_form = empty($_POST['menu_id']) ? true : false;
    	        $this->view->render('menu/form');
			endif;
		}
		
		public function delete($nav_id = false, $confirm = false) {
			if($nav_id == false)
				header('location: ' . ADMIN_URL . '/menu/lists');

			$this->view->menu = $this->model->getMenu($nav_id);
			$this->view->navid = $nav_id;
			if (is_object($this->view->menu) && ($confirm == false)) :
				$this->view->confirmDelete = true;
			endif;
			if (is_object($this->view->menu) && ($confirm == true)) :
				$this->model->delete($nav_id);
		       	//setcookie("MenuCookie", 'removed', time()+60);  /* expire in 1 min(60 sec) */
				header('location: ' . ADMIN_URL . '/menu/lists');// if YES, then redirect
			endif;
			$this->lists(); 
		}
		
		public function deleteall(){
			if(!isset($_POST))
				header('location: ' . ADMIN_URL . '/menu/lists');
				
			if( isset($_POST['yesall']) ):
				ksort($_POST['navid']);
				foreach ( $_POST['navid'] as $key=>$value ) :
					$this->model->delete($key);
				endforeach;
				setcookie("MenuCookie", 'removed', time()+60);  /* expire in 1 min(60 sec) */
				header('location: ' . ADMIN_URL . '/menu/lists');// if YES, then redirect
			elseif ( !empty($_POST['navid']) ):
				$this->view->deleteAll = true;
				$this->view->menus = $this->model->getAllMenus();
				$this->view->confirmDelete = false;
				$this->view->render('menu/index');
			else:
				$this->lists();
			endif;
		}
		
		public function order(){
			$this->view->menus = $this->model->getAllMenusOrder();
			$this->view->render('menu/order');
		}
		
		public function ajax_order(){
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
				$this->model->updateAllMenusOrder();
				return true;
			else :
				$this->view->render('error/index');
			endif;
		}

	}
	 