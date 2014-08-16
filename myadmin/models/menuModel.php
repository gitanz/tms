<?php
	/**
	 * class Menu_Model
	 * handles menu module
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 17th Dec 2013
	 */
	 
	class Menu_Model extends Model{
		public $errors = array();
		private $data = array();
		private $index = array();
		public $menuList = '';		
		
		public function __construct() {        
	        parent::__construct();            
	    }
		
		function formDataSave() {
			
			if(empty( $_POST['menu_title'] )):
				$this->errors[] = 'Menu title is missing.';
			elseif(empty( $_POST['menu_type'] )):
				$this->errors[] = 'Select menu item type.';
			elseif(( $_POST['menu_type'] == 'custom' ) && ( empty($_POST['menu_url']) )):
				$this->errors[] = 'You have selected custom link, so you need to enter url.';
			else:
				$alias = empty( $_POST['menu_alias'] ) ? $this->create_alias($_POST['menu_title']) : $this->create_alias($_POST['menu_alias']);// change to slug
				$alias = $this->check_alias ($alias, $_POST['menu_id']); //				
				
				$url = $_POST['menu_type'] == 'custom' ? $_POST['menu_url'] : '';
				$location = isset($_POST['menu_location']) ? serialize( $_POST['menu_location'] ) : '';
				
				
				$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_parent` = :parent;");
					
				$sth->execute(array(':parent' => $_POST['menu_parent']));
				$order =  $_POST['form'] == 1 ? $sth->rowCount()+1 : $_POST['menu_order'];
				
				if( $_POST['form'] == 1  ): //Insert New Record
					$sth = $this->db->prepare("INSERT INTO `".TABLE_PREFIX."navigations`
                              (`nav_title`, `nav_ontabs`, `nav_image`, `nav_altname`, `nav_alias`, `nav_type`, `nav_url`, `nav_destination`,`nav_itinerary`,`nav_include`,`nav_tpl`, `nav_location`, `nav_order`, `nav_status`, `nav_parent`, `nav_added`)                              
                              VALUES (:navtitle, :navTabs, :navImg, :navAlt, :navalias, :navtype, :navurl, :navdesti, :naviti, :navinc, :navtpl,  :navlocation, :navorder, :navstatus, :navparent, :navadded);");
					$data = array(
					            ':navtitle' => ucfirst($_POST['menu_title']),
					            ':navTabs' => isset($_POST['ontabs'])?"Yes":"No",
					            ':navImg' => isset($_POST['menu_image'])?$_POST['menu_image']:"",
					            ':navAlt' => isset($_POST['altname'])?ucfirst($_POST['altname']):ucfirst($_POST['menu_title']),
								':navalias' => $alias,
								':navtype' => $_POST['menu_type'],
								':navurl' => $url,
								':navdesti' => $_POST["menu_destination"],
								':naviti' => $_POST["menu_itinerary"],
								':navinc'=>isset($_POST["menu_include"])?$_POST["menu_include"]:"",
								':navtpl' => $_POST['menu_temp_type'],
								':navlocation' => $location,
								':navorder' => $order,
								':navstatus' => intval($_POST['menu_status']),
								':navparent' => intval($_POST['menu_parent']),
								':navadded' => DATETIME);
								
					$execute = $sth->execute( $data );
					$count =  $sth->rowCount();
					
					if ($count == 1):
         		   		return 1;
			        else :
			            $this->errors[] = 'Menu cannot be saved.';
            			return false;
					endif;
					
				else: // Update Old Record
					$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."navigations` SET 
												`nav_title` = :navtitle,
												`nav_ontabs` = :navTabs,
												`nav_image` = :navImg,
												`nav_altname` = :navAlt,
												`nav_alias` = :navalias,
												`nav_type` = :navtype,
												`nav_url` = :navurl,
												`nav_destination` = :navdesti,
												`nav_itinerary` = :naviti,
												`nav_include` = :navinc,
												`nav_tpl` = :navtpl,
												`nav_location` = :navlocation,
												`nav_order` = :navorder,
												`nav_status` = :navstatus,
												`nav_parent` = :navparent,
												`nav_updated` = :navupdated
                                   				WHERE `nav_id` = :navid;");
					$data = array(
            				':navtitle' => ucfirst($_POST['menu_title']),
            				':navTabs' => isset($_POST['ontabs'])?"Yes":"No",
            				':navImg' => isset($_POST['menu_image'])?$_POST['menu_image']:"",
					        ':navAlt' => isset($_POST['altname'])?ucfirst($_POST['altname']):ucfirst($_POST['menu_title']),
							':navalias' => $alias,
							':navtype' => $_POST['menu_type'],
							':navurl' => $url,
							':navdesti' => $_POST["menu_destination"],
							':naviti' => $_POST["menu_itinerary"],
							':navinc'=>isset($_POST["menu_include"])?$_POST["menu_include"]:"",
							':navtpl' => $_POST['menu_temp_type'],
							':navlocation' => $location,
            				':navorder' => $order,
							':navstatus' => intval($_POST['menu_status']),
							':navparent' => intval($_POST['menu_parent']),
            				':navupdated' => DATETIME,
							':navid' => intval($_POST['menu_id']));
					//var_dump ($data);
        			$sth->execute($data);   
        
        			$count =  $sth->rowCount();
        			if ($count == 1) :
            			return 2;
        			else :
            			$this->errors[] = 'Menu cannot be saved.';
           				return false;
        			endif;
				endif;
				
			endif;
			
			return false;
			
		}
		
		private function check_alias ($slug, $id, $increment_number_at_end = false) {
			
			$sth = $this->db->prepare("SELECT `nav_alias` FROM `".TABLE_PREFIX."navigations` WHERE `nav_alias` = :nav_alias;");
			$sth->execute(array(':nav_alias' => $slug));
		 	$count =  $sth->rowCount();
			
			$idsth = $this->db->prepare("SELECT `nav_alias` FROM `".TABLE_PREFIX."navigations` WHERE `nav_id` = :nav_id AND `nav_alias` = :nav_alias;");
			$idsth->execute(array(':nav_id' => $id, ':nav_alias' => $slug));
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
				
				$sth = $this->db->prepare("SELECT `nav_alias` FROM `".TABLE_PREFIX."navigations` WHERE `nav_alias` LIKE :nav_alias;");
				$sth->execute( array(':nav_alias' => '%'.$remaingin_string.'%') );
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
		
		private function increment_string($str, $separator = '_', $first = 1) {
	    	preg_match('/(.+)'.$separator.'([0-9]+)$/', $str, $match);
		    return isset($match[2]) ? $match[1].$separator.($match[2] + 1) : $str.$separator.$first;
		}
		
		public function getAllMenus($id = NULL, $level = 0, $first_call = true){
			$call = $first_call == true ? false : false;
			$id = isset($id) ? $id : 0;
			$sth = $this->db->prepare("SELECT `nav_id`, `nav_title`, `nav_parent`, `nav_location`, `nav_added` FROM `".TABLE_PREFIX."navigations` WHERE `nav_parent` = :nav_parent ORDER BY `nav_order` ASC;");
			
			$sth->execute(array(':nav_parent'=>$id));
			$objectMenu = $sth->fetchAll();
			foreach($objectMenu as $tbl_field => $tbl_value) :
				$navid = $tbl_value->nav_id;
				$navtitle = stripslashes($tbl_value->nav_title);
				$navparent = $tbl_value->nav_parent;
				$navlocation = $this->get_navPosition( $tbl_value->nav_location );
				$navadded = $tbl_value->nav_added;
				if( isset($_POST['navid']) ):  					
					$inNav = $_POST['navid'];
					$checked = array_key_exists($navid, $inNav) ? ' checked' : '';
				else:
					$checked = '';
				endif;
				$this->menuList .= '<tr>
	                              	<td><label class="checkbox"><input type="checkbox" class="checkbxtd" name="navid['.$navid.']"'.$checked.' />'.$navid.'</label></td>
                                    <td>'.str_repeat("-", $level).'<a href="'.ADMIN_URL.'/menu/update/'.$navid.'" title="Edit" rel="tooltip">'.$navtitle.'</a></td>
                                	<td>'.$navlocation.'</td>
                                	<td>'.$this->datetime_format($navadded).'</td>
                                	<td>
                                		<a href="'.ADMIN_URL.'/menu/update/'.$navid.'" title="Edit" rel="tooltip"><i class="icon-pencil"></i></a>
                                    	<a href="'.ADMIN_URL.'/menu/delete/'.$navid.'" title="Delete" rel="tooltip"><i class="icon-remove"></i></a>
                                    </td>
                               	</tr>';
				$this->getAllMenus($navid, $level+1, false);
			endforeach;
			
			return $this->menuList;
		}
		
		public function getMenu($navid) {
        
        	$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_id` = :nav_id;");
	        $sth->execute(array(':nav_id' => $navid));
	        return $sth->fetch();
    	}
		
		//Function for geting nav position
		private function get_navPosition($array){
			//$menu_position = @unserialize($array);		
			$pos = @unserialize($array);
			$position = '';
			if (!is_array($pos)):
    			$position = 'Do not show';
			else:	    	
				foreach ($pos as $value):
					$position.= $value.' Menu, ';
				endforeach;
			endif;
			return $position;
		}		
		
		
		public function delete($nav_id) {
			//echo $nav_id.'<br />';
			//Get Parent ID
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_parent` = :parent_id;");
	        $sth->execute(array(':parent_id' => $nav_id));
	        $oMenus = $sth->fetchAll();
			//there exist child menu
			foreach ( $oMenus as $value )
				$this->delete($value->nav_id);

			
			//Delete Pages			
			$sth_pages = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."pages` WHERE `page_parent` = :nav_id;");
        	$sth_pages->execute(array(':nav_id' => $nav_id));
			
			//Delete Banner
			$sth_banners = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."banners` WHERE `bnr_parent` = :nav_id;");
        	$sth_banners->execute(array(':nav_id' => $nav_id));
			
			//Delete Gallery
			$sth_glry_chiled = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."galleries` WHERE `gly_navid` = :parent_id;");
	        $sth_glry_chiled->execute(array(':parent_id' => $nav_id));
	        $oGallery = $sth_glry_chiled->fetchAll();
			foreach ( $oGallery as $image) :
				//Delete Child Album
				$sth_ch = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."galleries` WHERE `gly_parent` = :parent;");
   	    		$sth_ch->execute(array(':parent' => $image->gly_id));
				//Delete Album
				$sth_gallery = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."galleries` WHERE `gly_id` = :gly_id;");
	       		$sth_gallery->execute(array(':gly_id' => $nav_id));
			endforeach;
			
			
			//Now Delete Menu
			$sth = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."navigations` WHERE `nav_id` = :nav_id;");
        	$sth->execute(array(':nav_id' => $nav_id));        	
    	    $count =  $sth->rowCount();
        	if ($count == 1) :
            	return true;
	        else :
    	        $this->errors[] = 'Menu deletion failed.';
        	    return false;
	        endif;
			
		}
		
		public function getAllMenusOrder($id = NULL, $level = 0, $first_call = true) {
			$this->menuList .=  $first_call == true ? '<ol class="sortable">' : '<ol>';
			$call = $first_call == true ? false : false;
			$id = isset($id) ? $id : 0;
			$sth = $this->db->prepare("SELECT `nav_id`, `nav_title`, `nav_order` FROM `".TABLE_PREFIX."navigations` WHERE `nav_parent` = :nav_parent ORDER BY `nav_order` ASC;");
			
			$sth->execute(array(':nav_parent'=>$id));
			$objectMenu = $sth->fetchAll();
			foreach($objectMenu as $tbl_field => $tbl_value) :
				$navid = $tbl_value->nav_id;
				$navtitle = stripslashes($tbl_value->nav_title);
				$navorder = $tbl_value->nav_order;
				$this->menuList .= '<li id="list_'.$navid.'"><div><span class="disclose"><span></span></span>'.$navtitle.'</div>';
				$this->getAllMenusOrder($navid, $level+1, false);
				$this->menuList .= '</li>';
			endforeach;
			$this->menuList .=  '</ol>';
			return $this->menuList;			
		}
		
		public function updateAllMenusOrder(){
			//print_r($_POST);
			$list = $_POST['list'];
			// an array to keep the sort order for each level based on the parent id as the key
		    $sort = array();
			foreach ($list as $id => $parentId) :
				/* a null value is set for parent id by nested sortable for root level elements
	           		so you set it to 0 to work in your case (from what I could deduct from your code) */
    		    $parentId = ($parentId === 'null') ? 0 : $parentId;
				// init the sort order value to 1 if this element is on a new level
        		if (!array_key_exists($parentId, $sort))
            		$sort[$parentId] = 1;
        		
				//echo $sort[$parentId].' &raquo; '.$parentId.' &raquo; '.$id.'<br />';
				$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."navigations` SET 
											`nav_order` = '".$sort[$parentId]."',
											`nav_parent` = '".$parentId."'
										    WHERE `nav_id` = '".$id."'");
				$sth->execute();
        		// increment the sort order for this level
		        $sort[$parentId]++;
				
			endforeach;
		}
		
	}