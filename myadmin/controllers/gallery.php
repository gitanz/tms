<?php
	/**
	 * gallery module controller page
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 03rd Jan 2014
	 */
	 
	class Gallery extends Controller {
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
			$pages->set_total( $this->model->get_all_count( 'WHERE `gly_parent` = 0' ) );
			//calling a method to get the records with the limit set
			$this->view->galleries = $this->model->getAllGalleries( $pages->get_limit(), $nav_id );
			//create the nav menu
			$this->view->links = $pages->page_links();
			$this->view->confirmDelete = isset($this->view->confirmDelete) ? true : false;
			//$this->view->adjacency = $this->model->menu_adjacency_list($gly_id, 0, 0, 'banners');
			$this->view->render('gallery/index'); //then pass this to the view, may be different depending on the system
		}
		
		public function create() {			
			$this->view->new_form = true;			
			$this->view->adjacency = $this->model->menu_adjacency(0, 0, 0, 0, 'gallery');
        	$this->view->render('gallery/form');
    	}
		
		public function update($gly_id) {			
			$this->view->gallery = $this->model->getGallery($gly_id);
			$this->view->adjacency = $this->model->menu_adjacency(0, $this->view->gallery->gly_parent, 0, 0, 'gallery');
			if ($this->view->gallery):
				$this->view->allImages = $this->model->getAllImages($gly_id);
				$this->view->new_form = false;
			else:
				$this->view->new_form = true;
			endif;
	        $this->view->render('gallery/form');
		}
		
		public function save(){
			if(!($_POST))
				header('location: ' . ADMIN_URL . '/gallery/create');

	        $save_success = $this->model->formDataSave();
			$this->view->errors = $this->model->errors;
        	if ( $save_success ) : // check save status
				$action = $save_success == 1 ? 'created' : 'updated';
            	setcookie("GalleryCookie", $action, time()+60);  /* expire in 1 min(60 sec) */
				header('location: ' . ADMIN_URL . '/gallery/lists');// if YES, then redirect
				//echo 'success';
    	   	else :
				$this->view->new_form = empty($_POST['gallery_id']) ? true : false;
				$this->view->adjacency = $this->model->menu_adjacency(0, $_POST['gallery_parent'], 0, 0, 'gallery');
				$this->view->allImages = $this->model->getAllImages($_POST['gallery_id']);
    	        $this->view->render('gallery/form');
			endif;
		}
		
		public function delete($gly_id = false, $confirm = false) {
			if($gly_id == false)
				header('location: ' . ADMIN_URL . '/gallery/lists');

			$this->view->gallery = $this->model->getGallery($gly_id);
			$this->view->gly_id = $gly_id;
			if (is_object($this->view->gallery) && ($confirm == false)) :
				$this->view->confirmDelete = true;
			endif;
			if (is_object($this->view->gallery) && ($confirm == true)) :				
				$this->model->delete($gly_id);
				//setcookie("GalleryCookie", 'removed', time()+60);  /* expire in 1 min(60 sec) */
				header('location: ' . ADMIN_URL . '/gallery/lists');// if YES, then redirect
			endif;
			$this->lists(); 
		}
		
		public function deleteall(){
			if(!isset($_POST))
				header('location: ' . ADMIN_URL . '/gallery/lists');
				
			if( isset($_POST['yesall']) ):
				foreach ( $_POST['glyid'] as $key=>$value ) :
					$this->model->delete($key);
				endforeach;
				setcookie("GalleryCookie", 'removed', time()+60);  /* expire in 1 min(60 sec) */
				header('location: ' . ADMIN_URL . '/gallery/lists');// if YES, then redirect
			elseif ( !empty($_POST['glyid']) ):
				$this->view->deleteAll = true;
				$this->lists();
			else:
				$this->lists();
			endif;
		}
		
		public function ajax_update_caption(){
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
				echo $this->model->updateImageCaption();
				return true;
			else :
				$this->view->render('error/index');
			endif;
		}
		
		public function ajax_image_delete(){
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
				echo $this->model->deleteImage();
				return true;
			else :
				$this->view->render('error/index');
			endif;
		}

	}