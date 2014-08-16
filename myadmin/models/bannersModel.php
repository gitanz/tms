<?php
	/**
	 * class Banners_Model
	 * handles banners modules
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 26th Dec 2013
	 */
	 
	class Banners_Model extends Model{
		public $errors = array();
		public $bannerList = '';
		 
		public function __construct() {        
	        parent::__construct();            
	    }
		
		public function formDataSave() {			
			$error = true;
			$loop = 0;
			$banner_images = $_POST['banner_image'];
			$banner_titles = $_POST['banner_title'];
			
			for ( $i = 0; $i < count($banner_images); $i++):				
				if ( (!empty($banner_images[$i])) && (@is_file( '../'.View::attachmentPathCorrect($banner_images[$i]) ))) :
					$error = false;
					$loop++;
				endif;
			endfor;
			if( $error ):
				$this->errors[] = 'Select at least one banner image.';
			else:
				$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."banners` WHERE `bnr_parent` = :parent;");					
				$sth->execute(array(':parent' => $_POST['banner_parent']));
				$order =  $_POST['form'] == 1 ? $sth->rowCount()+1 : $_POST['banner_order'];
				
				if( $_POST['form'] == 1  ): //Insert New Record
					for ( $i = 0; $i < count($banner_images); $i++):				
						if ( (!empty($banner_images[$i])) && (@is_file( '../'.View::attachmentPathCorrect($banner_images[$i]) ))) :
							$banner_title = empty( $banner_titles[$i] ) ? 'Banner '.$order : $banner_titles[$i];
							$banner_image = $banner_images[$i];
							
							$sth = $this->db->prepare("INSERT INTO `".TABLE_PREFIX."banners`
	                              (`bnr_title`, `bnr_content`, `bnr_imgpath`, `bnr_order`, `bnr_status`, `bnr_author`, `bnr_parent`, `bnr_added`)    					                          			VALUES (:bnrtitle, :bnrcontent, :bnrpath, :bnrorder, :bnrstatus, :bnrauthor, :bnrparent, :bnradded);");
							$data = array(
					            ':bnrtitle' => ucfirst($banner_title),
								':bnrcontent' => '',
								':bnrpath' => $banner_image,
								':bnrorder' => $order,
								':bnrstatus' => intval($_POST['banner_status']),
								':bnrauthor' => intval($_SESSION['admin_id']),
								':bnrparent' => intval($_POST['banner_parent']),
								':bnradded' => DATETIME);
							$execute = $sth->execute( $data );	
							$count =  $sth->rowCount();	
							$count++;
							$order++;
						endif;
					endfor;
					return 1;
				else: //edit
					//var_dump($banner_titles);
					//exit;
					$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."banners` SET 
												`bnr_title` = :bnrtitle,
												`bnr_imgpath` = :bnrpath,
												`bnr_status` = :bnrstatus,
												`bnr_author` = :bnrauthor,
												`bnr_parent` = :bnrparent,
												`bnr_updated` = :bnrupdate
                                   				WHERE `bnr_id` = :bnrid;");
					$data = array(
						':bnrtitle' => ucfirst($banner_titles[0]),
						':bnrpath' => $banner_images[0],
						':bnrstatus' => intval($_POST['banner_status']),
						':bnrauthor' => intval($_SESSION['admin_id']),
						':bnrparent' => intval($_POST['banner_parent']),
						':bnrupdate' => DATETIME,
						':bnrid' => intval($_POST['banner_id']));
        			$sth->execute($data);
					$count =  $sth->rowCount();
					if ($count == 1) :
    	        		return 2;
        			else :
            			$this->errors[] = 'Banner cannot be saved.';
           				return false;
        			endif;
				
				endif;
			endif;
			return false;	
		}
		
		public function get_all_count() {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."banners`");
	        $sth->execute();
			return $sth->rowCount();
		}
		
		public function getAllBanners( $limit, $parent = false  ){
			if( $parent ):
				$sth = $this->db->prepare("SELECT `bnr_id`, `bnr_title`, `bnr_imgpath`, FROM_UNIXTIME(bnr_added, '%a, %D %b %Y. %h:%i %p') as `added` FROM `".TABLE_PREFIX."banners` WHERE `bnr_parent` = :parent; ORDER BY `bnr_added` DESC ".$limit."");
				$sth->execute(array(':parent' => $parent));
			else:
				$sth = $this->db->prepare("SELECT `bnr_id`, `bnr_title`, `bnr_imgpath`, FROM_UNIXTIME(bnr_added, '%a, %D %b %Y. %h:%i %p') as `added` FROM `".TABLE_PREFIX."banners` ORDER BY `bnr_added` DESC ".$limit."");				
				$sth->execute();
			endif;
                
            return $sth->fetchAll();
		}
		
		public function getBanner($bnrid) {        
        	$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."banners` WHERE `bnr_id` = :bnr_id;");
	        $sth->execute(array(':bnr_id' => $bnrid));
	        return $sth->fetch();
    	}
		
		public function delete($bnr_id) {

			$sth = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."banners` WHERE `bnr_id` = :bnr_id;");
        	$sth->execute(array(':bnr_id' => $bnr_id));        
    	    $count =  $sth->rowCount();
        	if ($count == 1) :
            	return true;
	        else :
    	        $this->errors[] = 'Banner deletion failed.';
        	    return false;
	        endif;
		}
		
		public function getAllBannersOrder($id) {
			$this->bannerList .=  '<ol class="sortable" id="bannerSort">';
			$sth = $this->db->prepare("SELECT `bnr_id`, `bnr_title`, `bnr_imgpath`, `bnr_order` FROM `".TABLE_PREFIX."banners` WHERE `bnr_parent` = :bnr_parent ORDER BY `bnr_order` ASC;");
			
			$sth->execute(array(':bnr_parent'=>$id));
			$objectMenu = $sth->fetchAll();
			foreach($objectMenu as $tbl_field => $tbl_value) :
				$bnrid = $tbl_value->bnr_id;
				$bnrtitle = stripslashes($tbl_value->bnr_title);
				$bnrorder = $tbl_value->bnr_order;
				$this->bannerList .= '<li id="list_'.$bnrid.'"><div><span class="disclose"><span></span></span>'.$bnrtitle.'</div>';
				$this->bannerList .= '</li>';
			endforeach;
			$this->bannerList .=  '</ol>';
			return $this->bannerList;
		}
		
		public function updateAllBannersOrder(){
			$list = $_POST['list'];
			$sort = 1;
			foreach ($list as $id=>$parent) :
				$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."banners` SET 
											`bnr_order` = '".$sort."'
										    WHERE `bnr_id` = '".$id."'");
				$sth->execute();
				$sort++;
			endforeach;
			
		}

	}