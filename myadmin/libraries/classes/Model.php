<?php
	/**
	 * class Base Model
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 12th Dec 2013
	 */
	
	class Model {
		public $adjacencyList = '';
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
		
		public function create_alias($phrase, $maxLength = 25) {
		    $result = strtolower($phrase);

		    $result = preg_replace("/[^A-Za-z0-9\s-._\/]/", "", $result);
		    $result = trim(preg_replace("/[\s-]+/", " ", $result));
		    $result = trim(substr($result, 0, $maxLength));
		    $result = preg_replace("/\s/", "-", $result);
   
		    return $result;
		}
		
		public function datetime_format($datetime){
			return date("D, jS M Y. g:i A", $datetime);
		}
		
		//Function to fetch navigation as option
		function menu_adjacency($id, $parent, $parent_id, $level, $tpl = 'default') {
			
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_parent` = :parent_id ORDER BY `nav_order`;");
	        $sth->execute(array(':parent_id' => $parent_id));
	        $oMenus = $sth->fetchAll();
			
			foreach ( $oMenus as $value) :

				$this->adjacencyList.="<option value=".$value->nav_id;
				if ($id == $value->nav_id)
					$this->adjacencyList .= " disabled";
				if ($value->nav_type == 'custom')
					$this->adjacencyList .= " disabled";
				if ($tpl != 'default'):
					if($value->nav_tpl != $tpl)
						$this->adjacencyList .= " disabled";
				endif;
				if ($parent == $value->nav_id)
					$this->adjacencyList .= " selected";
				
				$this->adjacencyList .= ">".str_repeat('&minus;', $level).stripslashes($value->nav_title)."</option>";
				$this->menu_adjacency($id, $parent, $value->nav_id,  $level+1, $tpl);
				
			endforeach;
			
			return $this->adjacencyList;
		}
		function cat_adjacency($id){
			$this->adjacencyList = "";
			$sth = $this->db->prepare("SELECT * FROM ".TABLE_PREFIX."itinerary_categories");
			$sth->execute();
			$oCats = $sth->fetchAll();
			foreach($oCats as $cat):
				if($cat->category_id!=$id)
				$this->adjacencyList .= "<option value = ".$cat->category_id.">$cat->category_title</option>";
				else
				$this->adjacencyList .= "<option value = ".$cat->category_id." selected>$cat->category_title</option>";
			endforeach;
			return $this->adjacencyList;
		}
		//Function to fetch navigation as ul li
		function menu_adjacency_list($id, $parent, $level, $module = 'pages', $task = 'lists') {			
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_parent` = :parent_id ORDER BY `nav_order`;");
	        $sth->execute(array(':parent_id' => $parent));
	        $oMenus = $sth->fetchAll();
			
			foreach ( $oMenus as $value) :
				$this->adjacencyList .="<li";
				if ($id == $value->nav_id)
					$this->adjacencyList .= " class='active'";
				$this->adjacencyList .= "><a href=".ADMIN_URL.'/'.$module.'/'.$task.'/'.$value->nav_id.">".str_repeat('&minus;', $level).stripslashes($value->nav_title)."</a></li>";
				$this->menu_adjacency_list($id, $value->nav_id, $level+1, $module, $task);				
			endforeach;
			
			return $this->adjacencyList;
		}
		
		public function countTableValue($table, $condition = false) {		
			$sth = $this->db->prepare("SELECT * FROM `". $table ."`".$condition);
	        $sth->execute();
			return $sth->rowCount();
		}
		
		public function countVisitsTableValue ( $unique = false ){
			$site_url = SITE_URL;			
			$site_url = str_replace('http://', '', $site_url);
			$pieces = explode("/", $site_url);			
			$removeFirst = array_shift($pieces);
			$pieces = implode("/", $pieces);
			$pieces = strlen($pieces) > 0 ? '/'.$pieces.'/' : '/';
			if( !$unique )
				$sth = $this->db->prepare("SELECT * FROM `". TABLE_PREFIX ."ip2visits` WHERE `on_page` = '". $pieces ."'");
			else
				$sth = $this->db->prepare("SELECT DISTINCT (ip_adr) FROM `". TABLE_PREFIX ."ip2visits` WHERE `visit_date` = CURDATE() AND `on_page` = '". $pieces ."'");
			$sth->execute();
			return $sth->rowCount();
		}
		
		function get_latest_menus(){
			$sth = $this->db->prepare("SELECT `nav_id`, `nav_title`, `nav_type`, FROM_UNIXTIME(nav_added, '%a, %D %b %Y. %h:%i %p') as `added` FROM `".TABLE_PREFIX."navigations` ORDER BY `nav_added` DESC LIMIT 0, 4");
			$sth->execute();
			return $sth->fetchAll();
		}
		
		function get_latest_pages(){
			$sth = $this->db->prepare("SELECT `page_id`, `page_title`, FROM_UNIXTIME(page_added, '%a, %D %b %Y. %h:%i %p') as `added` FROM `".TABLE_PREFIX."pages` ORDER BY `page_added` DESC LIMIT 0, 4");
			$sth->execute();
			return $sth->fetchAll();
		}
		
		function get_latest_visits(){
			$sth = $this->db->prepare("SELECT v.id, v.ip_adr, DATE_FORMAT(v.visit_date, '%a, %D %b. %Y') visit_date, DATE_FORMAT(v.time, '%r') times, v.on_page, c.country 
						FROM ".TABLE_PREFIX."ip2visits v JOIN ".TABLE_PREFIX."ip2nationcountries c 
						ON v.country = c.code 
						ORDER BY visit_date, times DESC LIMIT 0, 4");
			$sth->execute();
			return $sth->fetchAll();
		}
	}