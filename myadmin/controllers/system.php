<?php
	/**
	 * system [counter, db backup] controller page
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 17th Dec 2013
	 */
	 
	class System extends Controller {
		function __construct() {
        	parent::__construct();
			$redirect_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";			
			Authorize::handleLogin($redirect_link); //check user is logged or not
    	}
		
		public function index() { $this->settings(); }
		
		public function settings() {
			$this->view->sitename = $this->model->getSiteVariable('site_name');
			$this->view->siteurl = $this->model->getSiteVariable('site_url');
			$this->view->siteemail = $this->model->getSiteVariable('site_email');
			$this->view->sitephone = $this->model->getSiteVariable('site_phone');
			$this->view->sitetz = $this->model->getSiteVariable('site_timezone');
			$this->view->siteoffline = $this->model->getSiteVariable('site_offline');
			$this->view->siteoffmsg = $this->model->getSiteVariable('site_offlinemsg');
			$this->view->sitelimit = $this->model->getSiteVariable('site_list_limit');
			
			$this->view->sitetitle = $this->model->getSiteVariable('site_title');
			$this->view->sitekeywrds = $this->model->getSiteVariable('site_meta_keywords');
			$this->view->sitedesc = $this->model->getSiteVariable('site_meta_description');
			$this->view->sitecopyright = $this->model->getSiteVariable('site_copyright');
			
			$this->view->sitethumb = $this->model->getSiteVariable('site_thumb');
			$this->view->siteuploadsize = $this->model->getSiteVariable('site_max_upload');
			
			$this->view->sitemenuorder = $this->model->getSiteVariable('site_menu_order');
			$this->view->sitemenuorderby = $this->model->getSiteVariable('site_menu_orderby');
			$this->view->sitepageorder = $this->model->getSiteVariable('site_page_order');
			$this->view->sitepageorderby = $this->model->getSiteVariable('site_page_orderby');
			$this->view->sitebannerorder = $this->model->getSiteVariable('site_banner_order');
			$this->view->sitebannerorderby = $this->model->getSiteVariable('site_banner_orderby');
			
			$this->view->sitesocialtitle = $this->model->getSiteVariable('site_social_title');
			$this->view->sitesociallinks = $this->model->getSiteVariable('site_social_links');
			$this->view->sitesocialicons = $this->model->getSiteVariable('site_social_icons');
			
			$this->view->siteassoctitle = $this->model->getSiteVariable('site_assoc_title');
			$this->view->siteassoclinks = $this->model->getSiteVariable('site_assoc_links');
			$this->view->siteassocicons = $this->model->getSiteVariable('site_assoc_icons');

        	$this->view->render('system/index');
    	}
		
		public function save(){			
			if(!($_POST))
				header('location: ' . ADMIN_URL . '/settings');
			
			// do editSave() in the settingsModel, passing POST via params			
	        $save_success = $this->model->editSave();			
			$this->view->errors = $this->model->errors;
			// check save status
        	if ($save_success)
	            // if YES, then redirect
            	header('location: ' . ADMIN_URL . '/system/settings');
				//echo 'success';
    	   	else
	            // if NO, then show the users/index (login form) again
    	        //$this->view->render('system/settings');
				$this->settings();
		}
		
		public function counter() {
			$this->view->visitToday = $this->model->show_visits_today();
			$this->view->visitTotal = $this->model->get_total_counter();
			
			$site = new Paginator(PER_PAGE, 'page');			
			$site->set_total( $this->model->get_total_counter() );
			$this->view->siteVisits = $this->model->getAllCounter( $site->get_limit() );			
			$this->view->links = $site->page_links();
			
			$pages = new Paginator(PER_PAGE, 'pages');
			$pages->set_total( $this->model->get_total_counter('page') );
			$this->view->pageVisits = $this->model->getAllCounter( $pages->get_limit(), 'page' );			
			$this->view->linkss = $pages->page_links();			

			$this->view->getPopularPages = $this->model->get_popular_pages();
			$this->view->getPopularCountries = $this->model->get_popular_countries();

			$this->view->render('system/counter');
		}
		
		public function backup() {
			$this->view->confirmDelete =  isset($this->view->confirmDelete) ? true : false;
			$this->view->confirmRestore = isset($this->view->confirmRestore) ? true : false;
			$this->view->render('system/backup');
		}
		
		public function backup_db() {
			$this->view->render('system/backup-db');
		}
		
		public function backup_save(){
			if(!($_POST))
				header('location: ' . ADMIN_URL . '/system/backup-save');
				
			$save_success = $this->model->formBackupCreate();
			$this->view->errors = $this->model->errors;
        	if ( $save_success ) : // check save status
				$action = $save_success == 1 ? 'created' : 'sent';
            	setcookie("DBBackupCookie", $action, time()+60);  /* expire in 1 min(60 sec) */
				header('location: ' . ADMIN_URL . '/system/backup');// if YES, then redirect
				//echo 'success';
    	   	else :				
    	        $this->view->render('system/backup-db');
			endif;				
		}
		
		public function backup_delete($sql_file, $confirm = false) {
			$this->view->sqlfile = $this->model->fileExists(BACKUP_DIRECTORY, $sql_file);
			$this->view->sql_file = $sql_file;
			if ( ($this->view->sqlfile == true) && ($confirm == false) ) :
				$this->view->confirmDelete = true;
			endif;
			if ( ($this->view->sqlfile == true) && ($confirm == true) ) :
				unlink(BACKUP_DIRECTORY.$sql_file);
				setcookie("DBBackupCookie", 'removed', time()+60);  /* expire in 1 min(60 sec) */				
				header('location: ' . ADMIN_URL . '/system/backup');// if YES, then redirect
			endif;
			if ( $this->model->errors )
				$this->view->errors = $this->model->errors;
			$this->backup();
		}
		
		public function backup_restore($sql_file, $confirm = false) {
			$this->view->sqlfile = $this->model->fileExists(BACKUP_DIRECTORY, $sql_file);
			$this->view->sql_file = $sql_file;
			if ( ($this->view->sqlfile == true) && ($confirm == false) ) :
				$this->view->confirmRestore = true;
			endif;
			if ( ($this->view->sqlfile == true) && ($confirm == true) ) :
				$save_success = $this->model->formBackupRestore( $sql_file );
				if ( $save_success ) : // check save status					
	            	setcookie("DBBackupCookie", 'restored', time()+60);  /* expire in 1 min(60 sec) */
					header('location: ' . ADMIN_URL . '/system/backup');// if YES, then redirect
				endif;
			endif;
			if ( $this->model->errors )
				$this->view->errors = $this->model->errors;
			$this->backup();
		}
	}