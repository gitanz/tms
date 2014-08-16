<?php
	/**
	 * class Pages_Model
	 * handles pages modules
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 25th Dec 2013
	 */
	 
	class Pages_Model extends Model{
		public $errors = array();
		 
		public function __construct() {        
	        parent::__construct();            
	    }
		
		function formDataSave() {
			if(empty( $_POST['page_title'] )):
				$this->errors[] = 'Page title is missing.';
			else:				
				$nav_sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_id` = :nav_id;");
		        $nav_sth->execute(array(':nav_id' => $_POST['page_parent']));
		        $nav_row = $nav_sth->fetch();
				//var_dump($nav_row);

				if( ($nav_row != false) && ($nav_row->nav_type == 'page') ):
					//var_dump($_POST);
					$con_sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."pages` WHERE `page_id` = :page_id AND `page_parent` = :page_parent;");					
					$con_sth->execute(array(':page_id' => $_POST['page_id'], ':page_parent' => $_POST['page_parent']));
			        $con_row = $con_sth->fetch();
					//var_dump($con_row);
					if( ($con_row == false) || ($_POST['page_parent'] != $con_row->page_parent) ):
						$con_sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."pages` WHERE `page_parent` = :page_parent");
						$con_sth->execute(array(':page_parent' => $_POST['page_parent']));
						$count =  $con_sth->rowCount(); 
						if($count > 0)
							$this->errors[] = 'Already created page for this menu.';
					endif;
				endif;
				if( empty($this->errors) ) :
					$alias = empty( $_POST['page_alias'] ) ? $this->create_alias($_POST['page_title']) : $this->create_alias($_POST['page_alias']);// change to slug
					$alias = $this->check_alias ($alias, $_POST['page_id']);			
					
					$order =  intval($_POST['page_order']);
					
					if( $_POST['form'] == 1  ): //Insert New Record
						
						$sth = $this->db->prepare("INSERT INTO `".TABLE_PREFIX."pages`
                             (`page_title`, `page_alias`, `page_content`,`page_include`, `page_image`, `page_file`, `page_home`, `page_order`, `page_status`, `page_author`, `page_parent`, `page_added`) VALUES 
							  (:pagetitle, :pagealias, :pagecontent,:page_include, :pageimg, :pagefile, :pagehome, :pageorder, :pagestatus, :pageauthor, :pageparent, :pageadded);");
						$data = array(
				            ':pagetitle' => ucfirst(trim($_POST['page_title'])),
							':pagealias' => $alias,
							':pagecontent' => $_POST['page_content'],
							':page_include' => $_POST['page_include'],
							':pageimg' => $_POST['page_image'],
							':pagefile' => $_POST['page_file'],
							':pagehome' => $_POST['page_home'],
							':pageorder' => $order,
							':pagestatus' => intval($_POST['page_status']),
							':pageauthor' => intval($_SESSION['admin_id']),
							':pageparent' => intval($_POST['page_parent']),
							':pageadded' => DATETIME);
								
						$execute = $sth->execute( $data );
						$count =  $sth->rowCount();
				
						if ($count == 1):
       		   				return 1;
		        		else :
		            		$this->errors[] = 'Page cannot be saved.';	    
						endif;
												
					else: //edit
						$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."pages` SET 
												`page_title` = :pagetitle,
												`page_alias` = :pagealias,
												`page_content` = :pagecontent,
												`page_include` = :pageinclude,
												`page_image` = :pageimg,
												`page_file` = :pagefile,
												`page_home` = :pagehome,
												`page_order` = :pageorder,
												`page_status` = :pagestatus,
												`page_author` = :pageauthor,
												`page_parent` = :pageparent,
												`page_updated` = :pageupdate
                                   				WHERE `page_id` = :pageid;");
						$data = array(
            				':pagetitle' => ucfirst($_POST['page_title']),
							':pagealias' => $alias,
							':pagecontent' => $_POST['page_content'],
							':pageinclude'=>$_POST['page_include'],
							':pageimg' => $_POST['page_image'],
							':pagefile' => $_POST['page_file'],
							':pagehome' => $_POST['page_home'],
							':pageorder' => $order,
            				':pagestatus' => intval($_POST['page_status']),
							':pageauthor' => intval($_SESSION['admin_id']),
							':pageparent' => intval($_POST['page_parent']),
            				':pageupdate' => DATETIME,
							':pageid' => intval($_POST['page_id']));
						//var_dump ($data);
	        			$sth->execute($data);
						$count =  $sth->rowCount();
						
	        			if ($count == 1) :
    	        			return 2;
        				else :
            				$this->errors[] = 'Page cannot be saved.';
           					return false;
        				endif;
						
					endif; //add/edit
				endif;
			endif;			
			return false;	
		}
		
		private function check_alias ($slug, $id, $increment_number_at_end = false) {
			
			$sth = $this->db->prepare("SELECT `page_alias` FROM `".TABLE_PREFIX."pages` WHERE `page_alias` = :page_alias;");
			$sth->execute(array(':page_alias' => $slug));
		 	$count =  $sth->rowCount();
			
			$idsth = $this->db->prepare("SELECT `page_alias` FROM `".TABLE_PREFIX."pages` WHERE `page_id` = :page_id AND `page_alias` = :page_alias;");
			$idsth->execute(array(':page_id' => $id, ':page_alias' => $slug));
		 	$idcount =  $idsth->rowCount();
			
			if($count == 0 || $idcount == 1) : //if there is no any same slug
				return $slug;
			else:

				//check if the last char is a number
				//that could break this script if we don't handle it
				$last_char_is_number = is_numeric($slug[strlen($slug)-1]);
				$remaingin_string = empty( $last_char_is_number ) ? $slug : substr($slug, 0, -$last_char_is_number);
				//add a point to this slug if needed to prevent number collision..
				$slug = $slug. ($last_char_is_number && $increment_number_at_end ? '.':'');
				
				$sth = $this->db->prepare("SELECT `page_alias` FROM `".TABLE_PREFIX."pages` WHERE `page_alias` LIKE :page_alias;");
				$sth->execute( array(':page_alias' => '%'.$remaingin_string.'%') );
				//echo empty( $last_char_is_number ) ? 'y':'n';
				$count =  $sth->rowCount() == 0 ? '' : $sth->rowCount();
				//$count =  empty( $last_char_is_number ) ? '' : $sth->rowCount();
				$slug = $remaingin_string.$count;
				$slug = $this->increment_string($slug, '-');
				//so now we have unique slug
			    //remove the dot create because number collision
		    	if($last_char_is_number && $increment_number_at_end) $slug = str_replace('.','', $slug);
				return $slug;
				
				//exit;
			endif;
		}
		
		private function increment_string($str, $separator = '-', $first = 1) {
	    	preg_match('/(.+)'.$separator.'([0-9]+)$/', $str, $match);
		    return isset($match[2]) ? $match[1].$separator.($match[2] + 1) : $str.$separator.$first;
		}
		
		public function get_all_count() {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."pages`");
	        $sth->execute();
			return $sth->rowCount();
		}
		
		public function getAllPages( $limit, $parent = false  ){
			if( $parent ):
				$sth = $this->db->prepare("SELECT `page_id`, `page_title`, `page_alias`, `page_home`, FROM_UNIXTIME(page_added, '%a, %D %b %Y. %h:%i %p') as `added` FROM `".TABLE_PREFIX."pages`
                                           WHERE `page_parent` = :parent; ORDER BY `page_added` DESC ".$limit."");
				$sth->execute(array(':parent' => $parent));
			else:
				$sth = $this->db->prepare("SELECT `page_id`, `page_title`, `page_alias`, `page_home`, FROM_UNIXTIME(page_added, '%a, %D %b %Y. %h:%i %p') as `added` FROM `".TABLE_PREFIX."pages` ORDER BY `page_added` DESC ".$limit."");				
				$sth->execute();
			endif;
                
            return $sth->fetchAll();
		}
		
		public function getPage($pagid) {        
        	$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."pages` WHERE `page_id` = :pag_id;");
	        $sth->execute(array(':pag_id' => $pagid));
	        return $sth->fetch();
    	}
		
		public function getOrder() {        
        	$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."pages`");
	        $sth->execute();
			return $sth->rowCount()+1;
    	}
		
		public function delete($pag_id) {

			$sth = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."pages` WHERE `page_id` = :pag_id;");
        	$sth->execute(array(':pag_id' => $pag_id));        
    	    $count =  $sth->rowCount();
        	if ($count == 1) :
            	return true;
	        else :
    	        $this->errors[] = 'Page deletion failed.';
        	    return false;
	        endif;
		}
	}