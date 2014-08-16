<?php
	/**
	 * class Gallery_Model
	 * handles gallery modules
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 03rd Jan 2014
	 */
	 
	class Gallery_Model extends Model{
		public $errors = array();
		
		public function __construct() {        
	        parent::__construct();            
	    }
		
		public function formDataSave() {
			$error = true;
			$loop = 0;
			$gallery_titles = $_POST['gallery_titles'];
			$gallery_images = $_POST['gallery_image'];
			
			for ( $i = 0; $i < count($gallery_images); $i++):				
				if ( (!empty($gallery_images[$i])) && (@is_file( '../'.View::attachmentPathCorrect($gallery_images[$i]) ))) :
					$error = false;
					$loop++;					
				endif;
			endfor;

			if( ($_POST['form'] == 1) && $error ):			
				$this->errors[] = 'Select at least one gallery image.';
			else:				
				
				$sth = $this->db->prepare("SELECT `nav_title` FROM `".TABLE_PREFIX."navigations` WHERE `nav_id` = :navid;");					
				$sth->execute(array(':navid' => $_POST['gallery_parent']));				
				$oNav = $sth->fetch();
				$categoryname = empty($_POST['gallery_title']) ? $oNav->nav_title.' '.rand ( 1 , 100 ) : $_POST['gallery_title'];
				
				$alias = empty( $_POST['gallery_alias'] ) ? $this->create_alias($categoryname) : $this->create_alias($_POST['gallery_alias']);// change to slug
				$alias = $this->check_alias ($alias, $_POST['gallery_id']);
				
				if( $_POST['form'] == 1  ): //Insert New Record
				
					$sth = $this->db->prepare("INSERT INTO `".TABLE_PREFIX."galleries`
	                       (`gly_title`, `gly_alias`, `gly_path`, `gly_parent`, `gly_navid`, `gly_status`, `gly_author`, `gly_type`, `gly_added`)    					                      	  VALUES (:glytitle, :glyalias, :glypath, :glyparent, :glynav, :glystatus, :glyauthor, :glytype, :glyadded);");
					$data = array(
				            ':glytitle' => ucfirst($categoryname),
							':glyalias' => $alias,
							':glypath' => '',
							':glyparent' => 0,
							':glynav' => intval($_POST['gallery_parent']),
							':glystatus' => intval($_POST['gallery_status']),
							':glyauthor' => intval($_SESSION['admin_id']),
							':glytype' => 'images',
							':glyadded' => DATETIME);
					try { 
						$sth->execute( $data );
						$insertID = $this->db->lastInsertId(); 
						for ( $i = 0; $i < count($gallery_images); $i++):				
							if ( (!empty($gallery_images[$i])) && (@is_file( '../'.View::attachmentPathCorrect($gallery_images[$i]) ))) :
								$path_parts = pathinfo($gallery_images[$i]);
								$img_title = empty( $gallery_titles[$i] ) ? $path_parts['filename'] : $gallery_titles[$i];
								$img_image = $gallery_images[$i];
								
								$sth = $this->db->prepare("INSERT INTO `".TABLE_PREFIX."galleries`
	                              	(`gly_title`, `gly_path`, `gly_parent`, `gly_navid`, `gly_status`, `gly_author`, `gly_type`, `gly_added`)    					                          			VALUES (:glytitle, :glypath, :glyparent, :glynav, :glystatus, :glyauthor, :glytype, :glyadded);");
								$data = array(
										':glytitle' => ucfirst($img_title),
										':glypath' => $img_image,
										':glyparent' => intval($insertID),
										':glynav' => intval($_POST['gallery_parent']),
										':glystatus' => intval($_POST['gallery_status']),
										':glyauthor' => intval($_SESSION['admin_id']),
										':glytype' => 'images',
										':glyadded' => DATETIME);
								$sth->execute( $data );
								$sth->rowCount();
							endif;
						endfor;
						return 1;
					} catch(PDOExecption $e) {
						$this->errors[] = 'Error!: '.$e->getMessage();
				    } 
				else:
					$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."galleries` SET 
										`gly_title` = :glytitle,
										`gly_alias` = :glyalias, 
										`gly_navid` = :glynav,
										`gly_status` = :glystatus, 
										`gly_author` = :glyauthor, 
										`gly_updated` = :glyupdated
										WHERE `gly_id` = :glyid;");
					$data = array(
				            ':glytitle' => ucfirst($categoryname),
							':glyalias' => $alias,
							':glynav' => intval($_POST['gallery_parent']),
							':glystatus' => intval($_POST['gallery_status']),
							':glyauthor' => intval($_SESSION['admin_id']),
							':glyupdated' => DATETIME,
							':glyid' => intval($_POST['gallery_id'])
							);
					$sth->execute( $data );
					$count =  $sth->rowCount();
					for ( $i = 0; $i < count($gallery_images); $i++):				
						if ( (!empty($gallery_images[$i])) && (@is_file( '../'.View::attachmentPathCorrect($gallery_images[$i]) ))) :
							$path_parts = pathinfo($gallery_images[$i]);
							$img_title = empty( $gallery_titles[$i] ) ? $path_parts['filename'] : $gallery_titles[$i];
							$img_image = $gallery_images[$i];
								
							$sth = $this->db->prepare("INSERT INTO `".TABLE_PREFIX."galleries`
	                             	(`gly_title`, `gly_path`, `gly_parent`, `gly_navid`, `gly_status`, `gly_author`, `gly_type`, `gly_added`)    					                          			VALUES (:glytitle, :glypath, :glyparent, :glynav, :glystatus, :glyauthor, :glytype, :glyadded);");
							$data = array(
									':glytitle' => ucfirst($img_title),
									':glypath' => $img_image,
									':glyparent' => intval($_POST['gallery_id']),
									':glynav' => intval($_POST['gallery_parent']),
									':glystatus' => intval($_POST['gallery_status']),
									':glyauthor' => intval($_SESSION['admin_id']),
									':glytype' => 'images',
									':glyadded' => DATETIME);
							$sth->execute( $data );
							$sth->rowCount();
						endif;
					endfor;
					
					if ($count == 1) :
            			return 2;
       				else :
	       				$this->errors[] = 'Gallery cannot be saved.';
       					return false;
       				endif;
					
				endif;
				
			endif;
			return false;
		}
		
		public function get_all_count( $condition ) {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."galleries` ".$condition);
	        $sth->execute();
			return $sth->rowCount();
		}
		
		public function getAllGalleries( $limit, $navid = false  ){
			if( $navid ):
				$sth = $this->db->prepare('SELECT a.gly_id, a.gly_title, FROM_UNIXTIME(gly_added, "%a, %D %b %Y. %h:%i %p") added, b.TotalCout 
					FROM '.TABLE_PREFIX.'galleries 	a INNER JOIN(
				        SELECT gly_parent, COUNT(1) as TotalCout
				          FROM '.TABLE_PREFIX.'galleries  WHERE gly_parent <> gly_id GROUP BY gly_parent
					) b 
				    ON a.gly_id = b.gly_parent AND b.TotalCout > 0 WHERE a.gly_parent = :parent AND a.gly_navid = :nav ORDER BY a.gly_added DESC 
					'.$limit.'');
				$sth->execute(array(':parent' => 0, ':nav' => $parent));
			else:				
				$sth = $this->db->prepare('SELECT a.gly_id, a.gly_title, FROM_UNIXTIME(gly_added, "%a, %D %b %Y. %h:%i %p") added, b.TotalCout 
					FROM '.TABLE_PREFIX.'galleries 	a INNER JOIN(
				        SELECT gly_parent, COUNT(1) as TotalCout
				          FROM '.TABLE_PREFIX.'galleries  WHERE gly_parent <> gly_id GROUP BY gly_parent
					) b 
				    ON a.gly_id = b.gly_parent AND b.TotalCout > 0 WHERE a.gly_parent = :parent ORDER BY a.gly_added DESC 
					'.$limit.'');				
				$sth->execute(array(':parent' => 0));
			endif;

            return $sth->fetchAll();
		}
		
		public function getAllImages( $parent ){
			
			$sth = $this->db->prepare('SELECT `gly_id`, `gly_title`, `gly_path` FROM `'.TABLE_PREFIX.'galleries` WHERE `gly_parent` = :parent 
										ORDER BY `gly_added` DESC');
			$sth->execute(array(':parent' => $parent));
            return $sth->fetchAll();
		}
		
		public function getGallery($glyid) {        
        	$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."galleries` WHERE `gly_id` = :gly_id;");
	        $sth->execute(array(':gly_id' => $glyid));
	        return $sth->fetch();
    	}
		
		private function check_alias ($slug, $id, $increment_number_at_end = false) {
			
			$sth = $this->db->prepare("SELECT `gly_alias` FROM `".TABLE_PREFIX."galleries` WHERE `gly_alias` = :gly_alias;");
			$sth->execute(array(':gly_alias' => $slug));
		 	$count =  $sth->rowCount();
			
			$idsth = $this->db->prepare("SELECT `gly_alias` FROM `".TABLE_PREFIX."galleries` WHERE `gly_id` = :gly_id AND `gly_alias` = :gly_alias;");
			$idsth->execute(array(':gly_id' => $id, ':gly_alias' => $slug));
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
				
				$sth = $this->db->prepare("SELECT `gly_alias` FROM `".TABLE_PREFIX."galleries` WHERE `gly_alias` LIKE :gly_alias;");
				$sth->execute( array(':gly_alias' => '%'.$remaingin_string.'%') );
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
		
		public function updateImageCaption(){
			//var_dump($_POST);
			$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."galleries` SET 
												`gly_title` = :glytitle,
												`gly_updated` = :glyupdate
                                   				WHERE `gly_id` = :glyid;");
			$data = array(
            			':glytitle' => ucfirst($_POST['value']),
            			':glyupdate' => DATETIME,
						':glyid' => intval($_POST['pk']));
			
	        $sth->execute($data);
			$count =  $sth->rowCount();
			if ($count == 1) 
      			return 'Success';
  			else 
				return 'Error';
		}
		
		public function deleteImage() {
			$img_id= intval($_POST['pk']);
			$sth = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."galleries` WHERE `gly_id` = :gly_id;");
        	$sth->execute(array(':gly_id' => $img_id));        
    	    $count =  $sth->rowCount();
        	if ($count == 1)
            	return 'Success';
	        else
    	        return 'Error';        	    
		}
		
		public function delete( $glyid ) {
			$sth_ch = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."galleries` WHERE `gly_parent` = :parent;");
        	$sth_ch->execute(array(':parent' => $glyid)); 
			
			$sth = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."galleries` WHERE `gly_id` = :gly_id;");
        	$sth->execute(array(':gly_id' => $glyid)); 
    	    $count =  $sth->rowCount();
        	if ($count == 1) :
            	return true;
	        else :
    	        $this->errors[] = 'Gallery deletion failed.';
        	    return false;
	        endif;
        	    
		}
	}