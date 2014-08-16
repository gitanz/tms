<?php
	/**
	 * Controller index page
	 * @package himalayanPursuits
	 */
	class Index extends Controller {    
		public $loadCSS = array();
		public $loadJS = array();
		
		function __construct() {
        	parent::__construct();
    	}

	    function index() {
			// Set page title
			$this->view->Set_Site_Title( SITE_TITLE );
			// Set page keywords
			$this->view->Set_Meta_Keywords( SITE_KEYWORDS );
			// Set page descriptions
			$this->view->Set_Meta_Description( SITE_DESCRIPTION );
			// load CSS file
			$this->loadCSS[] = '/assets/css/jquery.vegas.css'; 
			$this->view->Set_CSS( $this->loadCSS );
			// load JS file
			$this->loadJS[] = '/assets/js/jquery.vegas.min.js';
			$this->loadJS[] = '/assets/js/jquery.scrollTo-1.4.3.1-min.js'; 
			$this->view->Set_JS( $this->loadJS );
			
            $this->view->render('content/home');
    	}
    	function sitemap(){
    		$this->view->render("content/sitemap");
    	}
		function gallery($id=false){
			$this->view->title = "Image Gallery";
			if(!$id):
			$this->view->albums = $this->model->getAlbums();
			else:
			$this->view->albumImages = $this->model->getAlbumImages($id);	
			endif;
			$this->view->render("content/gallery");
		}
		function videos($id=false){
			$this->view->title = "Video Gallery";
			if(!$id):
			$this->view->albums = $this->model->getVAlbums();
			else:
			$this->view->albumVideos = $this->model->getAlbumVideos($id);	
			endif;
			$this->view->render("content/video");
		}
		function search(){
			if(!$_GET['query'])$this->view->render('content/home');
			$site_title = "Search |".$_GET['query'];
			$site_desc = $_GET['query'];
			$seo = new phpSEO( $site_desc );
			$keywords = $seo->getKeyWords(12);
			$desc = $seo->getMetaDescription(150); 
			$this->view->page_title = "Search";
			$this->view->query = $_GET['query'];

			$search_results = $this->model->searchQuery();
			$this->view->query_results = $search_results;  
			$this->view->Set_Site_Title(SITE_TITLE.' &#8250'."Search");
			$this->view->Set_Meta_Keywords($keywords);
			$this->view->Set_Meta_Description($desc);
			$this->view->Set_CSS();
			$this->view->Set_JS( $this->loadJS);
			$this->view->render('content/search');
		}
		function post($slug = false,$list=true){
			if($list!==true):
				$menu = $this->model->getPage($list);
			else: 
			$menu = $this->model->getMenuAlias( $slug );
				if(count($menu)==0) $this->view->render("error/index");
			endif;
			$this->view->pages = $menu;
			$this->view->listing = $list===true?true:false;
			$page_by_menu = $menu[0];
			$site_title = $page_by_menu ? $page_by_menu->page_title : $menu->nav_title;
			$site_desc = $page_by_menu ? $page_by_menu->page_content : $menu->nav_title;				
			$seo = new phpSEO( $site_desc );
			$keywords = $seo->getKeyWords(12);
			$desc = $seo->getMetaDescription(150); 
			$this->view->render('content/post');	
		}
		function page( $slug = false, $first_parameter = false ){

			$menu = $this->model->getMenuBySlug( $slug );
			//var_dump($menu);
			//if the menu exists
			if ( $menu ) : //if slug is from menu
				if ($menu->nav_tpl == 'default') : // page is default
					if($menu->nav_type == 'page') :
						$page_by_menu = $this->model->getPagebyParentID( $menu->nav_id );
						$site_title = $page_by_menu ? $page_by_menu->page_title : $menu->nav_title;
						$site_desc = $page_by_menu ? $page_by_menu->page_content : $menu->nav_title;				
						$seo = new phpSEO( $site_desc );
						$keywords = $seo->getKeyWords(12);
						$desc = $seo->getMetaDescription(150); 
						$breadcrumb = $this->model->breadcrumb($menu->nav_id);
            			$this->view->breadcrumb = $breadcrumb;
						$this->view->page_title = $page_by_menu ? $page_by_menu->page_title : $menu->nav_title;
						$this->view->page_content = $page_by_menu ? $page_by_menu->page_content : 'This page is under contsruction.';
						if($page_by_menu){
						$this->view->contact_form = $page_by_menu->page_include == '1' ? true : false;
						$this->view->booking_form = $page_by_menu->page_include == '2' ? true : false;
						}
						$this->view->Set_Site_Title( SITE_TITLE.' &#8250; '.$site_title );			
						$this->view->Set_Meta_Keywords( $keywords );
						$this->view->Set_Meta_Description( $desc );
						$this->view->Set_CSS();
						// $this->loadJS[] = $this->view->contact_form == true ? '/assets/js/jquery.validate.min.js' : '';
						$this->view->Set_JS( $this->loadJS );
						
						$this->view->opage = $page_by_menu;
						$this->view->render('content/page');
					elseif($menu->nav_type == 'post') :						

						$pages = new Paginator(PER_PAGE, 'page');
						$pages->set_total( $this->model->get_all_count( $menu->nav_id ) );
						
						$site_title = $menu->nav_title;
						$site_desc = $menu->nav_title;				
						$seo = new phpSEO( $site_desc );
						$keywords = $seo->getKeyWords(12);
						$desc = $seo->getMetaDescription(150); 
					
						$this->view->Set_Site_Title( SITE_TITLE.' &#8250; '.$site_title );			
						$this->view->Set_Meta_Keywords( $keywords );		
						$this->view->Set_Meta_Description( $desc );
						$this->view->Set_CSS();
						$this->view->Set_JS();
					
						$this->view->page_title = $menu->nav_title;
						$this->view->pages = $this->model->getPagesbyParentID( $pages->get_limit(), $menu->nav_id );
						//$this->view->pages = $this->model->getAllPages( $pages->get_limit(), $nav_id );
						$this->view->links = $pages->page_links();
						$this->view->render('content/post');
					endif;
				elseif ($menu->nav_tpl == 'career'):					
						
						$site_title = $menu->nav_title;
						$site_desc = $menu->nav_title;
						$seo = new phpSEO( $site_desc );
						$keywords = $seo->getKeyWords(12);
						$desc = $seo->getMetaDescription(150); 
					
						$this->view->Set_Site_Title( SITE_TITLE.' &#8250; '.$site_title );			
						$this->view->Set_Meta_Keywords( $keywords );		
						$this->view->Set_Meta_Description( $desc );
						$this->view->Set_CSS();
						$this->view->Set_JS();
					
						$this->view->page_title = $menu->nav_title;
						$this->view->page_alias = $menu->nav_alias;						
						$page_by_menu = $this->model->getPagebyParentID( $menu->nav_id );
						$this->view->page_content = $page_by_menu ? $page_by_menu->page_content : '';
						
						$this->view->demands = $this->model->getDemandsListing();
						$this->view->categories = $this->model->getDemandsCategory();
						$this->view->countries = $this->model->getDemandsCountry();
						
						$this->view->render('content/demands');

				elseif ($menu->nav_tpl == 'gallery'):
					
					if( $first_parameter ) : //if child is called
						$oGallery = $this->model->getGalleryBySlug( $first_parameter );
						
						$site_title = $oGallery ? $menu->nav_title. ' | ' .$oGallery->gly_title : $site_title;
						$site_desc = $oGallery ? $oGallery->gly_title : $site_title;				
						$seo = new phpSEO( $site_desc );
						$keywords = $seo->getKeyWords(12);
						$desc = $seo->getMetaDescription(150); 
					
						$this->view->Set_Site_Title( SITE_TITLE.' &#8250; '.$site_title );			
						$this->view->Set_Meta_Keywords( $keywords );		
						$this->view->Set_Meta_Description( $desc );
						$this->loadCSS[] = '/assets/css/venobox.css';
						$this->view->Set_CSS( $this->loadCSS );
						$this->loadJS[] = '/assets/js/venobox.min.js';
						$this->view->Set_JS( $this->loadJS );
					
						$this->view->page_title = $oGallery ? $oGallery->gly_title : $menu->nav_title;
						$this->view->images = $this->model->getGalleriesbyParentID( $oGallery->gly_id );
					
					else:

						$site_title = $menu->nav_title;
						$site_desc = $menu->nav_title;
						$seo = new phpSEO( $site_desc );
						$keywords = $seo->getKeyWords(12);
						$desc = $seo->getMetaDescription(150); 
					
						$this->view->Set_Site_Title( SITE_TITLE.' &#8250; '.$site_title );			
						$this->view->Set_Meta_Keywords( $keywords );		
						$this->view->Set_Meta_Description( $desc );
						$this->view->Set_CSS();
						$this->view->Set_JS();
					
						$this->view->page_title = $menu->nav_title;
						$this->view->page_alias = $menu->nav_alias;
						$this->view->galleries = $this->model->getGalleriesbyNavID( $menu->nav_id );

					endif;
					
					
					$this->view->render('content/gallery');
					
				endif;
			else: // if no menu slug
				$page = $this->model->getPageBySlug( $slug );
				
				if ($page) :
					$site_title = $page->page_title;
					$site_desc = $page->page_content;
					$seo = new phpSEO( $site_desc );
					$keywords = $seo->getKeyWords(12);
					$desc = $seo->getMetaDescription(150); 
					
					$this->view->Set_Site_Title( SITE_TITLE.' &#8250; '.$site_title );			
					$this->view->Set_Meta_Keywords( $keywords );		
					$this->view->Set_Meta_Description( $desc );
					$this->view->Set_CSS();
					$this->view->Set_JS();
					
					$this->view->page_title =$page->page_title;
					$this->view->page_content = $page->page_content;
					//$this->view->contact_form = $page_by_menu ? $page_by_menu->page_title : $menu->nav_title;
		
					$this->view->render('content/page');
				else:
					$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Page not found');
					$this->view->Set_Meta_Keywords( SITE_KEYWORDS );		
					$this->view->Set_Meta_Description( SITE_DESCRIPTION );				
					$this->loadCSS[] = '/assets/css/jquery.vegas.css'; 
					$this->view->Set_CSS( $this->loadCSS );				
					$this->loadJS[] = '/assets/js/jquery.vegas.min.js';
					$this->view->Set_JS( $this->loadJS );
					
					$this->view->render('error/index');
				endif;
			endif;
		}
		
		public function jobs( $key, $value = false ){
			
			if ( ($key == 'countries-wise') || ($key == 'categories-wise') ):
				
				if( $key == 'countries-wise' ):
					
					$this->view->wise = $this->model->getCountryBySlug( $value );
					
					if( $this->view->wise ):
						$this->view->demands = $this->model->getDemandsByCountrySlug( $this->view->wise->ctry_id );
						$site_title = $this->view->wise->ctry_title;
						$site_desc = $this->view->wise->ctry_content;
						
						$this->view->page_title =$this->view->wise->ctry_title;
						$this->view->page_content = $this->view->wise->ctry_content;
					else:
						$site_title = 'Not Found';
						$site_desc =  '';
						$this->view->page_title = 'Not Found';
						$this->view->page_content =  '';
					endif;
					
					$seo = new phpSEO( $site_desc );
					$keywords = $seo->getKeyWords(12);
					$desc = $seo->getMetaDescription(150);
					
					$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Vacancies &#8250; '.$site_title );
					$this->view->Set_Meta_Keywords( $keywords );		
					$this->view->Set_Meta_Description( $desc );
					$this->view->Set_CSS();
					$this->view->Set_JS();
					
					$this->view->render('content/demandsbyfixed');
					
				else:
					
					$this->view->wise = $this->model->getCategoryBySlug( $value );
					
					if( $this->view->wise ):
						$this->view->demands = $this->model->getDemandsByCategorySlug( $this->view->wise->cat_id );
						$site_title = $this->view->wise->cat_title;
						$site_desc = $this->view->wise->cat_title;
						
						$this->view->page_title =$this->view->wise->cat_title;
						$this->view->page_content = '';
					else:
						$site_title = 'Not Found';
						$site_desc =  '';
						$this->view->page_title = 'Not Found';
						$this->view->page_content =  '';
					endif;
					
					$seo = new phpSEO( $site_desc );
					$keywords = $seo->getKeyWords(12);
					$desc = $seo->getMetaDescription(150);
					
					$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Vacancies &#8250; '.$site_title );
					$this->view->Set_Meta_Keywords( $keywords );		
					$this->view->Set_Meta_Description( $desc );
					$this->view->Set_CSS();
					$this->view->Set_JS();
					
					$this->view->render('content/demandsbyfixed');
					
				endif;
			
			elseif ( ($key == 'categories') ):
				
				//$this->view->wise = $this->model->getAvailableCategories();

				$site_title = 'Available Categories';
				$site_desc = $site_title;
						
				$this->view->page_title = $site_title;
				$this->view->page_content = $site_title;

					
					
				$seo = new phpSEO( $site_desc );
				$keywords = $seo->getKeyWords(12);
				$desc = $seo->getMetaDescription(150);
					
				$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Vacancies &#8250; '.$site_title );
				$this->view->Set_Meta_Keywords( $keywords );		
				$this->view->Set_Meta_Description( $desc );
				$this->view->Set_CSS();
				$this->view->Set_JS();
				
				$this->view->categories = $this->model->getAllAvailableCategories();
					
				$this->view->render('content/demandsavailablecat');
				
			elseif ( ($key == 'post-requirements') || ($key == 'create-cv') || ($key == 'complain') ):
			
				if( $key == 'post-requirements' ):
					
					if( $value == 'posted' ):
					
						if(!($_POST)) :
							header ( 'Location: '.SITE_URL.'/index/jobs/post-requirements' ); exit;
						endif;
						
						//var_dump($_POST);
						
						$save_success = $this->model->formDataReqSend();
						$this->view->errors = $this->model->errors;
					
						/*if ( $save_success ) : // check save status
							$this->view->page_content = '';
						else :*/
							$this->view->page_content = $this->view->errors[0];
						//endif;
					
						$site_title = 'Post Your Requirements';
						$site_desc = $site_title;
							
						$this->view->page_title = $site_title;
					
						
						$seo = new phpSEO( $site_desc );
						$keywords = $seo->getKeyWords(12);
						$desc = $seo->getMetaDescription(150);
						
						$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Vacancies &#8250; '.$site_title );
						$this->view->Set_Meta_Keywords( $keywords );		
						$this->view->Set_Meta_Description( $desc );
						$this->view->Set_CSS();
						$this->view->Set_JS();
						
						$this->view->render('content/message');
						
					
					else:
						
						$site_title = 'Post Your Requirements';
						$site_desc =  'Post Your Requirements';
						$this->view->page_title = 'Post Your Requirements';
						$seo = new phpSEO( $site_desc );
						$keywords = $seo->getKeyWords(12);
						$desc = $seo->getMetaDescription(150);
					
						$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Vacancies &#8250; '.$site_title );
						$this->view->Set_Meta_Keywords( $keywords );		
						$this->view->Set_Meta_Description( $desc );
						$this->view->Set_CSS();
						$this->loadJS[] = '/assets/js/jquery.validate.min.js';
						$this->view->Set_JS( $this->loadJS );
						
						$this->view->render('content/demandspost');
						
					endif;
					
				elseif( $key == 'create-cv' ):
				
					if( $value == 'posted' ):
						if(!($_POST)) :
							header ( 'Location: '.SITE_URL.'/index/jobs/create-cv' ); exit;
						endif;
						
						//var_dump($_POST);
						
						if ( isset ($_POST['submit_now'] ) ):
							
							$save_success = $this->model->formDataCVSend();
							$this->view->errors = $this->model->errors;					
						
							$this->view->page_content = $this->view->errors[0];						
					
							$site_title = 'Create Your CV';
							$site_desc = $site_title;
							
							$this->view->page_title = $site_title;
							
							$seo = new phpSEO( $site_desc );
							$keywords = $seo->getKeyWords(12);
							$desc = $seo->getMetaDescription(150);
						
							$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Vacancies &#8250; '.$site_title );
							$this->view->Set_Meta_Keywords( $keywords );		
							$this->view->Set_Meta_Description( $desc );
							$this->view->Set_CSS();
							$this->view->Set_JS();
					
							$this->view->render('content/message');							
							
						else:
							
							echo $this->model->formDataCVPrint();
						
						endif;
						
					else:
					
						$site_title = 'Create Your CV';
						$site_desc =  'Create Your CV';
						$this->view->page_title = 'Create Your CV';
						$seo = new phpSEO( $site_desc );
						$keywords = $seo->getKeyWords(12);
						$desc = $seo->getMetaDescription(150);
						$this->view->job_nationality = 'Nepali';
					
						$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Vacancies &#8250; '.$site_title );
						$this->view->Set_Meta_Keywords( $keywords );		
						$this->view->Set_Meta_Description( $desc );
						$this->loadCSS[] = '/assets/css/cupertino/jquery-ui-1.10.4.custom.min.css'; 
						$this->view->Set_CSS( $this->loadCSS );
						$this->loadJS[] = '/assets/js/jquery-ui-1.10.4.custom.min.js';
						$this->loadJS[] = '/assets/js/jquery.validate.min.js';
						$this->view->Set_JS( $this->loadJS );
						
						$this->view->render('content/demandscv');
					
					endif;
				
				else:

					if( $value == 'posted' ):
					
					else:
					
						$site_title = 'Compain/ Comments';
						$site_desc = $site_title;
						$seo = new phpSEO( $site_desc );
						$keywords = $seo->getKeyWords(12);
						$desc = $seo->getMetaDescription(150); 
					
						$this->view->page_title = $site_title;
						
						$this->view->Set_Site_Title( SITE_TITLE.' &#8250; '.$site_title );			
						$this->view->Set_Meta_Keywords( $keywords );
						$this->view->Set_Meta_Description( $desc );
						$this->view->Set_CSS();
						$this->loadJS[] = '/assets/js/jquery.validate.min.js';
						$this->view->Set_JS( $this->loadJS );
		
						$this->view->render('content/complain');
						
					endif;
					
				endif;
							
			else:
				
				if ( ($key != 'apply') && ($key != 'applied') ):
				
					$this->view->job = $this->model->getJobBySlug( $key );
					
					if( $this->view->job ) :
						
						$site_title = $this->view->job->dmd_title;
						$site_desc = $this->view->job->dmd_title;
							
						$this->view->page_title =$this->view->job->dmd_title;
						$this->view->page_content = '';
						
						$seo = new phpSEO( $site_desc );
						$keywords = $seo->getKeyWords(12);
						$desc = $seo->getMetaDescription(150);
						
						$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Vacancies &#8250; '.$site_title );
						$this->view->Set_Meta_Keywords( $keywords );		
						$this->view->Set_Meta_Description( $desc );
						$this->view->Set_CSS();
						$this->view->Set_JS();
					
						$this->view->render('content/demandsdetails');
					
					else:
						
						$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Page not found');
						$this->view->Set_Meta_Keywords( SITE_KEYWORDS );		
						$this->view->Set_Meta_Description( SITE_DESCRIPTION );				
						$this->loadCSS[] = '/assets/css/jquery.vegas.css'; 
						$this->view->Set_CSS( $this->loadCSS );				
						$this->loadJS[] = '/assets/js/jquery.vegas.min.js';
						$this->view->Set_JS( $this->loadJS );
						
						$this->view->render('error/index');
						
					endif;
				
				elseif ( ($key == 'applied') ):
					
					if(!($_POST)) :
						header ( 'Location: '.SITE_URL.'/index/jobs/apply' ); exit;
					endif;
										
					$save_success = $this->model->formDataSave();
					$this->view->errors = $this->model->errors;
					
					/*if ( $save_success ) : // check save status
						$this->view->page_content = '';
					else :*/
						$this->view->page_content = $this->view->errors[0];
					//endif;
					
					$site_title = 'Online Form';
					$site_desc = $site_title;
							
					$this->view->page_title = $site_title;
					
						
					$seo = new phpSEO( $site_desc );
					$keywords = $seo->getKeyWords(12);
					$desc = $seo->getMetaDescription(150);
						
					$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Vacancies &#8250; '.$site_title );
					$this->view->Set_Meta_Keywords( $keywords );		
					$this->view->Set_Meta_Description( $desc );
					$this->view->Set_CSS();
					$this->view->Set_JS();
					
					$this->view->render('content/message');
					
				else: //application form
					
					$this->view->job = $this->model->getJobBySlug( $value );
					
					$site_title = '';
					$site_desc = '';
					
					$this->view->job_post = '';
					$this->view->job_country = '';
					$this->view->job_id = 0;
					$this->view->job_nationality = 'Nepali';
					if( $this->view->job ) :
						$site_title = $this->view->job->dmd_title. ' &#8250;';
						$site_desc = $this->view->job->dmd_title;
						$this->view->job_post = $this->view->job->dmd_title;
						$this->view->job_country = $this->view->job->ctry_title;
						$this->view->job_id = $this->view->job->dmd_id;
					endif;
					
					$form_token = uniqid(); /*** create the form token ***/	
				   	$_SESSION['form_token'] = $form_token; /*** add the form token to the session ***/
					
					$this->view->page_title = 'Online Form';
					$this->view->page_content = '';
						
					$seo = new phpSEO( $site_desc );
					$keywords = $seo->getKeyWords(12);
					$desc = $seo->getMetaDescription(150);
						
					$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Vacancies &#8250; '.$site_title.' Apply Now' );
					$this->view->Set_Meta_Keywords( $keywords );		
					$this->view->Set_Meta_Description( $desc );
					$this->loadCSS[] = '/assets/css/cupertino/jquery-ui-1.10.4.custom.min.css'; 
					$this->view->Set_CSS( $this->loadCSS );
					$this->loadJS[] = '/assets/js/jquery-ui-1.10.4.custom.min.js';
					$this->loadJS[] = '/assets/js/jquery.validate.min.js';
					$this->view->Set_JS( $this->loadJS );
					
					$this->view->render('content/demandform');
					
					
				endif;
				
			endif;
		}
		
		public function form( $key ){
				
			if(!($_POST)) :
				header ( 'Location: '.SITE_URL.'/index/jobs/apply' ); exit;
			endif;
			
			$save_success = $this->model->formDataSend();
			$this->view->errors = $this->model->errors;

			$this->view->page_content = $this->view->errors[0];
					
			$site_title = 'Contact Form Submission';
			$site_desc = $site_title;							
			$this->view->page_title = $site_title;					
						
			$seo = new phpSEO( $site_desc );
			$keywords = $seo->getKeyWords(12);
			$desc = $seo->getMetaDescription(150);
						
			$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Form Submission' );
			$this->view->Set_Meta_Keywords( $keywords );		
			$this->view->Set_Meta_Description( $desc );
			$this->view->Set_CSS();
			$this->view->Set_JS();
					
			$this->view->render('content/message');
			
		}
		
		
	}