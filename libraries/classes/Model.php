<?php
	/**
	 * class Base Model
	 *
	 * @package marvelousnepal
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 08th Jan 2014
	 */
	class Model {
		public $adjacencyList = '';
		public $siteadjacencyList = '';

		public $menuOtherList = '';
		public $vacancy = '';
		public $news = '';
		public $clients = '';
		public $filpath = "";
		/**
     	 * creates a PDO database connection when a model is constructed
     	 * We are using the try/catch error/exception handling here
     	 */
    	
		function __construct() {
	        try {
            	$this->db = new Database();
        	} catch (PDOException $e) {
            	die('Database connection could not be established.');
        	}
    	}
    	public function getSiteCount(){
    		$sql = "SELECT *
    				FROM `adc_ip2visits`
    				GROUP BY `visit_date` , `time`";

    		$sth = $this->db->prepare($sql);
    		$sth->execute();
    		return($sth->rowCount());
    	}
    	public function getHomeVideos(){
			$sql = "SELECT * FROM ".TABLE_PREFIX."itinerary_video WHERE video_path LIKE 'http://www.youtube.com%'
																  OR video_path LIKE 'https://www.youtube.com%'
																  LIMIT 3";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
    	}
		public function getPostMenu(){
			$sql = "SELECT * FROM ".TABLE_PREFIX."navigations WHERE `nav_type`='post' AND `nav_status`='1' LIMIT 4";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		public function getHomeTabs(){
			$sql = "SELECT ".TABLE_PREFIX."navigations.* 
					FROM ".TABLE_PREFIX."navigations
					WHERE ".TABLE_PREFIX."navigations . nav_ontabs = 'Yes' AND ".TABLE_PREFIX."navigations . nav_status = '1'
					ORDER BY `nav_order`";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}

		private function checkForActiveAction($filename, $navigation_action) {
        
        	$splitted_filename = explode("/", $filename);
	        $active_controller = $splitted_filename[0];
    	    $active_action = $splitted_filename[1];
			
        	//$splitted_filename = explode("/", $navigation_action);
	        //$navigation_controller = $splitted_filename[0];
    	    //$navigation_action = $splitted_filename[1];        
        
        	if ( $active_action == $navigation_action )
	            return true;            
        	else            
            	return false;        
	    }
		
		//Function to fetch main navigation
		public function menu_adjacency_main($parent, $level, $location, $filename, $first_call = true) {
			$menu_order = ORDER_MENU == 'order' ? 'nav_order' : 'nav_added';
			$menu_orderby = ORDER_MENU_BY == 'asc' ? 'ASC' : 'DESC';
			
			if($first_call == true):			
				$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_location` LIKE '%$location%' AND `nav_status` = '1' ORDER BY `".$menu_order."` ".$menu_orderby.";");
		        $sth->execute();
				$this->adjacencyList .= "<ul class = 'nav navbar-nav'>";				
			else:			
				$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_status` = '1' AND `nav_parent` = :parent ORDER BY `".$menu_order."` ".$menu_orderby.";");
		        $sth->execute( array(':parent' => $parent) );
				$this->adjacencyList .= "\n".'<ul class="dropdown-menu sub-menu" >';
			endif;
			// $this->adjacencyList .= $level > 0 ? '<li class="arrow_top"></li>' : '';
			
			$oMenus = $sth->fetchAll();
			// dd($oMenus);
			foreach ( $oMenus as $menu) :
				$sm_sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_status` = '1' AND `nav_parent` = :parent ORDER BY `".$menu_order."` ".$menu_orderby.";");
				$sm_sth->execute( array(':parent' => $menu->nav_id) );
				$submenu_total = $sm_sth->rowCount();
				
				if( $menu->nav_type == 'custom' ):
					$url = parse_url($menu->nav_url);
					if(in_array("http", $url)): //contains http
						$nav_url = $menu->nav_url;
						$target = 'target="_blank"';
					else:
						$nav_url = SITE_URL.$menu->nav_url;
						$target = '';
					endif;
				elseif( $menu->nav_type == 'page' && $menu->nav_tpl == 'default' ):
					$nav_url = SITE_URL."/index/page/".$menu->nav_alias;
					$target = '';
				elseif( $menu->nav_type == 'post' && $menu->nav_tpl == 'default' ):
					$nav_url = SITE_URL."/index/post/".$menu->nav_alias;
					$target = '';
				elseif( $menu->nav_tpl == 'itinerary' ):
					$nav_url = SITE_URL."/itineraries/show/".$menu->nav_id;
					$target = '';
				elseif( $menu->nav_tpl == 'gallery' ):
					$nav_url = SITE_URL."/index/gallery";
					$target = '';
				elseif( $menu->nav_tpl == 'news' ):
					$nav_url = SITE_URL."/news";
					$target = '';
				elseif( $menu->nav_tpl == 'testimonials' ):
					$nav_url = SITE_URL."/testimonial";
					$target = '';
				elseif( $menu->nav_tpl == 'sitemap' ):
					$nav_url = SITE_URL."/index/sitemap";
					$target = '';
				elseif( $menu->nav_tpl == 'planatrip' ):
					$nav_url = SITE_URL."/itineraries/planatrip";
					$target = '';

				else:
					$nav_url = '#';
					$target = '';
				endif;
				
				//check active
				/*if ($this->checkForActiveAction($filename, "page")) :
					$active = ' class="active"'; 
				endif;*/
				
				if( $submenu_total > 0 ):
					$this->adjacencyList .= "\n".'<li class = "dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="'.$nav_url.'" '.$target.' title="'.stripslashes(strip_tags($menu->nav_title)).'">'.stripslashes($menu->nav_title).'<b class="caret"></b></a>';
					$this->menu_adjacency_main($menu->nav_id, $level+1, $location, $filename, false);
					$this->adjacencyList .= '</li>'."\n";
				else:
					$this->adjacencyList .= "\n".'<li><a href="'.$nav_url.'" '.$target.' title="'.stripslashes(strip_tags($menu->nav_title)).'">'.stripslashes($menu->nav_title).'</a></li>'."\n";
				endif;
				
					
			endforeach;
			$this->adjacencyList .= "</ul>\n";
			return $this->adjacencyList;
		}
		//Function to sitemap
		public function sitemap($parent, $level,$location, $filename, $first_call = true) {
			$menu_order = ORDER_MENU == 'order' ? 'nav_order' : 'nav_added';
			$menu_orderby = ORDER_MENU_BY == 'asc' ? 'ASC' : 'DESC';
			
			if($first_call == true):			
				$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_status` = '1' ORDER BY `".$menu_order."` ".$menu_orderby.";");
		        $sth->execute();
				$this->siteadjacencyList .= "<ul>";				
			else:			
				$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_status` = '1' AND `nav_parent` = :parent ORDER BY `".$menu_order."` ".$menu_orderby.";");
		        $sth->execute( array(':parent' => $parent) );
				$this->siteadjacencyList .= "\n".'<ul>';
			endif;
			// $this->siteadjacencyList .= $level > 0 ? '<li class="arrow_top"></li>' : '';
			
			$oMenus = $sth->fetchAll();
			// dd($oMenus);
			foreach ( $oMenus as $menu) :
				$sm_sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_status` = '1' AND `nav_parent` = :parent ORDER BY `".$menu_order."` ".$menu_orderby.";");
				$sm_sth->execute( array(':parent' => $menu->nav_id) );
				$submenu_total = $sm_sth->rowCount();
				
				if( $menu->nav_type == 'custom' ):
					$url = parse_url($menu->nav_url);
					if(in_array("http", $url)): //contains http
						$nav_url = $menu->nav_url;
						$target = 'target="_blank"';
					else:
						$nav_url = SITE_URL.$menu->nav_url;
						$target = '';
					endif;
				elseif( $menu->nav_type == 'page' && $menu->nav_tpl == 'default' ):
					$nav_url = SITE_URL."/index/page/".$menu->nav_alias;
					$target = '';
				elseif( $menu->nav_type == 'post' && $menu->nav_tpl == 'default' ):
					$nav_url = SITE_URL."/index/post/".$menu->nav_alias;
					$target = '';
				elseif( $menu->nav_tpl == 'itinerary' ):
					$nav_url = SITE_URL."/itineraries/show/".$menu->nav_id;
					$target = '';
				elseif( $menu->nav_tpl == 'gallery' ):
					$nav_url = SITE_URL."/index/gallery";
					$target = '';
				elseif( $menu->nav_tpl == 'news' ):
					$nav_url = SITE_URL."/news";
					$target = '';
				elseif( $menu->nav_tpl == 'testimonials' ):
					$nav_url = SITE_URL."/testimonial";
					$target = '';
				elseif( $menu->nav_tpl == 'sitemap' ):
					$nav_url = SITE_URL."/index/sitemap";
					$target = '';
				elseif( $menu->nav_tpl == 'planatrip' ):
					$nav_url = SITE_URL."/itineraries/planatrip";
					$target = '';

				else:
					$nav_url = '#';
					$target = '';
				endif;
				
				//check active
				/*if ($this->checkForActiveAction($filename, "page")) :
					$active = ' class="active"'; 
				endif;*/
				
				if( $submenu_total > 0 ):
					$this->siteadjacencyList .= "\n".'<li ><a href="'.$nav_url.'" '.$target.' title="'.stripslashes(strip_tags($menu->nav_title)).'">'.stripslashes($menu->nav_title).'</a>';
					$this->sitemap($menu->nav_id, $level+1, $location, $filename, false);
					$this->siteadjacencyList .= '</li>'."\n";
				else:
					$this->siteadjacencyList .= "\n".'<li><a href="'.$nav_url.'" '.$target.' title="'.stripslashes(strip_tags($menu->nav_title)).'">'.stripslashes($menu->nav_title).'</a></li>'."\n";
				endif;
				
					
			endforeach;
			$this->siteadjacencyList .= "</ul>\n";
			return $this->siteadjacencyList;
		}
		
		public function menu_adjacency_other($parent, $level, $location, $filename, $first_call = true) {
			$menu_order = ORDER_MENU == 'order' ? 'nav_order' : 'nav_added';
			$menu_orderby = ORDER_MENU_BY == 'asc' ? 'ASC' : 'DESC';
			$this->menuOtherList = "";
			
			$sql = "SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_location` LIKE '%$location%' AND `nav_status` = '1' ORDER BY `".$menu_order."` ".$menu_orderby;
			// echo $sql;
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_location` LIKE '%$location%' AND `nav_status` = '1' ORDER BY `".$menu_order."` ".$menu_orderby.";");
	        $sth->execute();

			$oMenus = $sth->fetchAll();
			foreach ( $oMenus as $menu) :
				
				if( $menu->nav_type == 'custom' ):
					$url = parse_url($menu->nav_url);
					if(in_array("http", $url)): //contains http
						$nav_url = $menu->nav_url;
						$target = 'target="_blank"';
					else:
						$nav_url = SITE_URL.$menu->nav_url;
						$target = '';
					endif;
				elseif( $menu->nav_type == 'page' && $menu->nav_tpl == 'default' ):
					$nav_url = SITE_URL."/index/page/".$menu->nav_alias;
					$target = '';
				elseif( $menu->nav_type == 'post' && $menu->nav_tpl == 'default' ):
					$nav_url = SITE_URL."/index/post/".$menu->nav_alias;
					$target = '';
				elseif( $menu->nav_tpl == 'itinerary' ):
					$nav_url = SITE_URL."/itineraries/show/".$menu->nav_id;
					$target = '';
				elseif( $menu->nav_tpl == 'gallery' ):
					$nav_url = SITE_URL."/index/gallery";
					$target = '';
				elseif( $menu->nav_tpl == 'news' ):
					$nav_url = SITE_URL."/news";
					$target = '';
				elseif( $menu->nav_tpl == 'testimonials' ):
					$nav_url = SITE_URL."/testimonial";
					$target = '';
				elseif( $menu->nav_tpl == 'planatrip' ):
					$nav_url = SITE_URL."/itineraries/planatrip";
					$target = '';
				elseif( $menu->nav_tpl == 'sitemap' ):
					$nav_url = SITE_URL."/index/sitemap";
					$target = '';
				else:
					$nav_url = '#';
					$target = '';
				endif;
				
				//check active
				/*if ($this->checkForActiveAction($filename, "page")) :
					$active = ' class="active"'; 
				endif;*/				
				if($location == "Header" || $location == "Tail" ):
					$this->menuOtherList .= "\n".'<a href="'.$nav_url.'" '.$target.' title="'.stripslashes(strip_tags($menu->nav_title)).'">'.stripslashes($menu->nav_title).'</a> | '."\n";
				else:
				$this->menuOtherList .= "\n".'<a href="'.$nav_url.'" '.$target.' title="'.stripslashes(strip_tags($menu->nav_title)).'">'.stripslashes($menu->nav_title).'</a><br/>'."\n";
				endif;
			endforeach;
			$this->menuOtherList .= "\n";
			return $this->menuOtherList;
		}
		public function getImage(){
			$sql = "SELECT * FROM `".TABLE_PREFIX."itinerary_gallery` LIMIT 1";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			return $sth->fetch();
		}
		public function getVideo(){
			$sql = "SELECT * FROM `".TABLE_PREFIX."itinerary_video` WHERE video_path LIKE 'http://www.youtube.com%'
																  OR video_path LIKE 'https://www.youtube.com%'
																  LIMIT 1";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			return $sth->fetch();
		}
		public function getHomeContactContent(){
			$sql = "SELECT ".TABLE_PREFIX."pages . *, ".TABLE_PREFIX."navigations . *
					FROM `".TABLE_PREFIX."pages` 
					LEFT JOIN `".TABLE_PREFIX."navigations` ON ".TABLE_PREFIX."pages.page_parent = ".TABLE_PREFIX."navigations.nav_id
					WHERE `page_status` = '1' AND `page_include` = '1'";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			return $sth->fetch();
		}
		public function welcomeText() {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."pages` WHERE `page_home` = '1' AND `page_status` = '1'");
	        $sth->execute();
	        return $sth->fetch();
		}
		
		public function banners( $id = 0 ){
			$banner_order = ORDER_BANNER == 'order' ? 'bnr_order' : 'bnr_added';
			$banner_orderby = ORDER_BANNER_BY == 'asc' ? 'ASC' : 'DESC';
			
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."banners` WHERE `bnr_status` = '1' AND `bnr_parent` = :parent ORDER BY `".$banner_order."` ".$banner_orderby.";");
	        $sth->execute( array(':parent' => $id) );
			return $sth->fetchAll();			
			
		}
		
		public function vacancyBox( $filename ){
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_tpl` = 'career' AND `nav_status` = '1';");
	        $sth->execute();
			$oNav = $sth->fetch();

			if( $oNav ):
				$sth = $this->db->prepare("SELECT `page_image`, `page_content` FROM `".TABLE_PREFIX."pages` WHERE `page_parent` = :parent;");
		        $sth->execute( array(':parent' => $oNav->nav_id ) );
				$oPage = $sth->fetch();
				
				$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."careers_demands` WHERE `dmd_status` = :status;");
		        $sth->execute( array(':status' => '1' ) );
				$oDmd = $sth->fetch();
				
				$class = $filename == 'content/home' ? '' : '1';
				$img = $filename == 'content/home' ? '<img src="'.$this->attachmentFullPathCorrect( $oPage->page_image ).'">' : '';
				
				$this->vacancy = '<div class="current-vacancies'.$class.'">
                            '.$img.'
                            <h1>'.$oNav->nav_title.'</h1>
                            '.$oPage->page_content.'
                            <span>'.$oDmd->dmd_title.'</span><br />
                            Salary: '.$oDmd->dmd_salary.'<br />
                            Company: '.$oDmd->dmd_company.'<br />
                            Working Days: '.$oDmd->dmd_wrking_days.'<br />
                            Working Hours: '.$oDmd->dmd_wrking_hrs.'
                            <div class="arrow fright"><a href="'.SITE_URL.'/index/page/'.$oNav->nav_alias.'" title="'.$oNav->nav_title.'"><img src="'.SITE_URL.'/assets/images/arrow.png"></a></div>
                            <div class="clear"></div>
                        </div>';
				
				return $this->vacancy;
			endif;

		}
		
		public function newsBox( $filename ){
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_type` = 'post' AND `nav_status` = '1' ORDER BY `nav_id`;");
	        $sth->execute();
			$oNav = $sth->fetch();

			if( $oNav ):
				$sth = $this->db->prepare("SELECT `page_alias`, `page_title`, `page_content` FROM `".TABLE_PREFIX."pages` WHERE `page_parent` = :parent ORDER BY `page_added` DESC");
		        $sth->execute( array(':parent' => $oNav->nav_id ) );
				$oPage = $sth->fetch();
				
				$class = $filename == 'content/home' ? '' : '1';
				$img = $filename == 'content/home' ? '<img src="'.SITE_URL.'/assets/images/news.png">' : '';
				
				$this->news .= '<div class="current-vacancies'.$class.'">
                            '.$img.'
                            <h1>'.$oNav->nav_title.'</h1>
                            <p>Keep updates with our News & Events</p>';
				if( $oPage ) :
					$title = $oPage->page_title;
					$alias = $oPage->page_alias;
					$this->news .= '<a href="'.SITE_URL.'/index/page/'.$alias.'" title="'.$title.'"><span>' . $oPage->page_title . '</span></a>';
					$this->news .= strip_tags(trim(substr($oPage->page_content, 0, 102)), '<p>');					
				else:
					$this->news .= '<span>No Updates</span>';
					$this->news .= '<p>Sorry! No updates available</p>';
					$title = $oNav->nav_title;
					$alias = $oNav->nav_alias;
				endif;
                            
               $this->news .= '<div class="arrow fright"><a href="'.SITE_URL.'/index/page/'.$oNav->nav_alias.'" title="'.$oNav->nav_title.'"><img src="'.SITE_URL.'/assets/images/arrow.png"></a></div>
                            <div class="clear"></div>
                        </div>';
				
				return $this->news;
			endif;

		}
		
		public function clientBox( $filename ) {
									
			$sth = $this->db->prepare('SELECT n.*, p.* FROM '.TABLE_PREFIX.'navigations n JOIN '.TABLE_PREFIX.'pages p ON n.nav_id = p.page_parent WHERE n.nav_status = "1" AND p.page_parent = "55" AND p.page_status = "1";');
	        $sth->execute();
			$oCountries = $sth->fetchAll();
			
			$class = $filename == 'content/home' ? '' : '1';
			$img = $filename == 'content/home' ? '<img src="'.SITE_URL.'/assets/images/clients.png">' : '';
			
			$this->clients .= '<div class="current-vacancies'.$class.'">
                            '.$img.'
                            <h1>Client Lists</h1>';
			$this->clients .= '<div class="list_carousel responsive" >
									<ul id="client_list">';
			if( $oCountries ) :
				foreach ( $oCountries as $country ) :
					$this->clients .= '<li><a href="'.SITE_URL.'/index/page/'.$country->page_alias.'" title="'.$country->page_title.'"><img src="'.$this->attachmentFullPathCorrect( $country->page_image ).'"> '.$country->page_title.'</a></li>';
				endforeach;
			endif;
			
			$this->clients .='</ul>
								<div class="clearfix"></div>
							</div>';
			
			$this->clients .= '<div class="arrow fright"><a href="'.SITE_URL.'/index/page/our-valuable-clients" title="Our Clients"><img src="'.SITE_URL.'/assets/images/arrow.png"></a></div>
                            <div class="clear"></div>
                        </div>';
			
			return $this->clients;
			
			/*$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."careers_countries` WHERE `ctry_status` = '1' ORDER BY `ctry_title`;");
	        $sth->execute();
			$oCountries = $sth->fetchAll();
			
			$class = $filename == 'content/home' ? '' : '1';
			$img = $filename == 'content/home' ? '<img src="'.SITE_URL.'/assets/images/clients.png">' : '';
			
			$this->clients .= '<div class="current-vacancies'.$class.'">
                            '.$img.'
                            <h1>Client Lists</h1>
                            <p>See Our Vacancies in Different Countries</p>';
			
			$this->clients .= '<div class="list_carousel responsive" >
									<ul id="client_list">';
			if( $oCountries ) :
				foreach ( $oCountries as $country ) :
					$this->clients .= '<li><a href="'.SITE_URL.'/index/jobs/countries-wise/'.$country->ctry_alias.'" title="'.$country->ctry_title.'"><img src="'.$this->attachmentFullPathCorrect( $country->ctry_imgpath ).'"> '.$country->ctry_title.'</a></li>';
				endforeach;
			endif;
							$this->clients .='</ul>
								<div class="clearfix"></div>
							</div>';
			$this->clients .= '<!--<div class="arrow fright"><a href="'.SITE_URL.'/index/page/current-vacancies" title="Current Vacancies"><img src="'.SITE_URL.'/assets/images/arrow.png"></a></div>-->
                            <div class="clear"></div>
                        </div>';
			
			return $this->clients;*/
			
		}
		
		public function attachmentFullPathCorrect( $filePath ) {
			$pos = strpos($filePath, "/uploads/");
			if($pos !== false)
	    		$filpath = substr($filePath, $pos+strlen("/"));
			
			$correctpath = SITE_URL.'/'.$filpath;
			return $correctpath;
		}
	}