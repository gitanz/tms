<?php
	/**
	 * class System_Model
	 * handles system
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 13th Dec 2013
	 */
	 
	class System_Model extends Model{
		public $errors = array();
		 
		public function __construct() {        
	        parent::__construct();            
	    }
		
		public function getSiteVariable($var) {        	
        	$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."variables` WHERE `variable_name` = '".$var."'");
        	$sth->execute();
       	 	return $sth->fetch();
	    }
		
		public function editSave() {
			
			if(isset( $_POST['general'] )) :
				$site_url = filter_var($_POST['site_url'], FILTER_SANITIZE_URL);
				$site_email = filter_var($_POST['site_email'], FILTER_SANITIZE_EMAIL);
				
				if(empty( $_POST['site_name'] )):
					$this->errors[] = 'Site Name is missing.';
				elseif (!filter_var($site_url, FILTER_VALIDATE_URL)):
					$this->errors[] = 'Site URL is invalid. Enter valid URL.';
				elseif (!filter_var($site_email, FILTER_VALIDATE_EMAIL)):
					$this->errors[] = 'Site Email is invalid. Enter valid Email Address.';
				elseif (!filter_var($_POST['site_list_limit'], FILTER_SANITIZE_NUMBER_INT)):
					$this->errors[] = 'Post List is invalid. Enter valid number only.';
				else:
					$newPost = array_slice($_POST, 0, -1);
		        	//var_dump($newarray);
					foreach ( $newPost as $key=>$value ):						
						$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."variables` 
                                   SET `variable_value` = '".trim($value)."' WHERE `variable_name` = '".$key."'");
	   					$sth->execute();
						//echo $count =  $sth->rowCount();
					endforeach;
				endif;
				return empty( $this->errors ) ? true : false;
			endif; //save general
			
			if(isset( $_POST['preference'] )) :
				if(empty( $_POST['site_title'] )):
					$this->errors[] = 'Site Title is missing.';
				elseif(empty( $_POST['site_copyright'] )):
					$this->errors[] = 'Site Copyright is missing.';
				else:
					$newPost = array_slice($_POST, 0, -1);
					foreach ( $newPost as $key=>$value ):						
						$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."variables` 
                                   SET `variable_value` = '".trim($value)."' WHERE `variable_name` = '".$key."'");
	   					$sth->execute();
					endforeach;
				endif;
				return empty( $this->errors ) ? true : false;
			endif; //save preference
			
			if(isset( $_POST['media'] )) :
				$width = empty($_POST['thumbWidth']) ? '150' : $_POST['thumbWidth'];
				$height = empty($_POST['thumbHeight']) ? '150' : $_POST['thumbHeight'];
				$thumb = $width.'/'.$height;
				$maxsize = empty($_POST['site_max_upload']) ? '2' : $_POST['site_max_upload'];
				$postArray = array();
				$postArray['site_thumb'] = $thumb;
				$postArray['site_max_upload'] = $maxsize;
				foreach ( $postArray as $key=>$value ):
					$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."variables` 
                                  SET `variable_value` = '".trim($value)."' WHERE `variable_name` = '".$key."'");
	   				$sth->execute();
				endforeach;
				return empty( $this->errors ) ? true : false;
			endif; //save preference
			
			if(isset( $_POST['ordering'] )) :
				//var_dump($_POST);
				$newPost = array_slice($_POST, 0, -1);
				foreach ( $newPost as $key=>$value ):						
					$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."variables` 
                                  SET `variable_value` = '".trim($value)."' WHERE `variable_name` = '".$key."'");					
   					$sth->execute();
				endforeach;
				return empty( $this->errors ) ? true : false;
			endif; //save ordering
			
			if(isset( $_POST['social'] )) :
				var_dump($_POST);
				$social_images = $_POST['site_social_icons'];
				$social_links = $_POST['site_social_links'];
				$error_img = true;
				$error_lnk = 0;
				$links = array();
				$images = array();
				
				for ( $i = 0; $i < count($social_images); $i++):				
					if ( (!empty($social_images[$i])) && (@is_file( '../'.View::attachmentPathCorrect($social_images[$i]) ))) :
						$error_img = false;						
					endif;
				endfor;

				
				for ( $i = 0; $i < count($social_links); $i++):
					if ( (filter_var($social_links[$i], FILTER_SANITIZE_URL)) ) :
						$error_lnk = false;
					endif;
				endfor;
			
				if(empty( $_POST['site_social_title'] ))
					$this->errors[] = 'Social Name is missing.';
				if( $error_img )
					$this->errors[] = 'Select at least one social image.';
				if( $error_lnk )
					$this->errors[] = 'Enter at least one social link.';
				
				if( empty($this->errors) ):
					for ( $i = 0; $i < count($social_links); $i++):
						if ( (!empty($social_images[$i])) && (@is_file( '../'.View::attachmentPathCorrect($social_images[$i]) )) && (filter_var($social_links[$i], FILTER_SANITIZE_URL))) :
							$links[] = $social_links[$i];
							$images[] = $social_images[$i];
						endif;
					endfor;
					$links = serialize($links);
					$images = serialize($images);
					$sth_title = $this->db->prepare("UPDATE `".TABLE_PREFIX."variables` 
                                  SET `variable_value` = '".trim($_POST['site_social_title'])."' WHERE `variable_name` = 'site_social_title'");					
   					$sth_title->execute();
					$sth_title = $this->db->prepare("UPDATE `".TABLE_PREFIX."variables` 
                                  SET `variable_value` = '".trim($links)."' WHERE `variable_name` = 'site_social_links'");					
   					$sth_title->execute();
					$sth_title = $this->db->prepare("UPDATE `".TABLE_PREFIX."variables` 
                                  SET `variable_value` = '".trim($images)."' WHERE `variable_name` = 'site_social_icons'");					
   					$sth_title->execute();
					
					return true;
				endif;
				
				return false;
				
			endif; //save social
			if(isset( $_POST['assoc'] )) :
				var_dump($_POST);
				$assoc_images = $_POST['site_assoc_icons'];
				$assoc_links = $_POST['site_assoc_links'];
				$error_img = true;
				$error_lnk = 0;
				$links = array();
				$images = array();
				
				for ( $i = 0; $i < count($assoc_images); $i++):				
					if ( (!empty($assoc_images[$i])) && (@is_file( '../'.View::attachmentPathCorrect($assoc_images[$i]) ))) :
						$error_img = false;						
					endif;
				endfor;

				
				for ( $i = 0; $i < count($assoc_links); $i++):
					if ( (filter_var($assoc_links[$i], FILTER_SANITIZE_URL)) ) :
						$error_lnk = false;
					endif;
				endfor;
			
				if(empty( $_POST['site_assoc_title'] ))
					$this->errors[] = 'Association Name is missing.';
				if( $error_img )
					$this->errors[] = 'Select at least one assoc image.';
				if( $error_lnk )
					$this->errors[] = 'Enter at least one assoc link.';
				
				if( empty($this->errors) ):
					for ( $i = 0; $i < count($assoc_links); $i++):
						if ( (!empty($assoc_images[$i])) && (@is_file( '../'.View::attachmentPathCorrect($assoc_images[$i]) )) && (filter_var($assoc_links[$i], FILTER_SANITIZE_URL))) :
							$links[] = $assoc_links[$i];
							$images[] = $assoc_images[$i];
						endif;
					endfor;
					$links = serialize($links);
					$images = serialize($images);
					$sth_title = $this->db->prepare("UPDATE `".TABLE_PREFIX."variables` 
                                  SET `variable_value` = '".trim($_POST['site_assoc_title'])."' WHERE `variable_name` = 'site_assoc_title'");					
   					$sth_title->execute();
					$sth_title = $this->db->prepare("UPDATE `".TABLE_PREFIX."variables` 
                                  SET `variable_value` = '".trim($links)."' WHERE `variable_name` = 'site_assoc_links'");					
   					$sth_title->execute();
					$sth_title = $this->db->prepare("UPDATE `".TABLE_PREFIX."variables` 
                                  SET `variable_value` = '".trim($images)."' WHERE `variable_name` = 'site_assoc_icons'");					
   					$sth_title->execute();
					
					return true;
				endif;
				
				return false;
				
			endif; //save assoc
			
		}
		
		public function formBackupCreate() {

			$bkp_email = filter_var($_POST['backup_email'], FILTER_SANITIZE_EMAIL);
			$bkp_type = $_POST['backup_type'];
			$bkp_email = $bkp_type == 1 ? $bkp_email : '';
			$bkp_title = stripslashes(trim($_POST['backup_title']));
			$this->bkp_email = $bkp_email;
			if(empty( $bkp_title )):
				$this->errors[] = 'Backup title is missing.';
			elseif ( ($bkp_type == 1) && (!filter_var($bkp_email, FILTER_VALIDATE_EMAIL)) ):
				$this->errors[] = 'Email is invalid. Enter valid Email Address.';
			else:
				$bkp_name = $bkp_title.'_dbbkp_' . date("d.m.Y_H.i.s");
				define('BKP_NAME', $bkp_name);
				$pb4m = new phpBackup4MySQL();
				$sql_dump = $pb4m->backupSQL();
				if(!$pb4m->saveFile($sql_dump)) :
					$this->errors[] = 'Backup failed.';
				else :
					if ( $bkp_type == 1 ) :
						// send attachment email
                        if ($this->sendDBBackupEmail()) :
                            // when mail has been send successfully
							unlink(BACKUP_DIRECTORY.BKP_NAME.'.sql');
                            return 2;                            
                        else :
							unlink(BACKUP_DIRECTORY.BKP_NAME.'.sql');
                            $this->errors[] = 'Failed to send email. Please check  your email address.';
                        endif;						
						
					else:
						return 1;
					endif;					
				endif;
			endif;
		}
		
		/**
    	 * sendDBBackupEmail()
	     * sends an email to the provided email address
    	 * @return boolean gives back true if mail has been sent, gives back false if no mail could been sent
	     */    
		private function sendDBBackupEmail() {
			$mail = new PHPMailer;
			$mail->IsMail();
			$mail->From = SITE_EMAIL;
        	$mail->FromName = SITE_NAME;
	        $mail->AddAddress($this->bkp_email);
    	    $mail->Subject = 'Database Backup Email - '.SITE_NAME;
			$mail->Body	= 'Hello, <br /> You have recieved "'.SITE_NAME.'" database backup.<br /> Attachment is attached with this email<br />With Regards,<br />'.SITE_NAME;
			$mail->AddAttachment(BACKUP_DIRECTORY.BKP_NAME.'.sql');
			$mail->IsHTML(true);
			
			if(!$mail->Send()) :
				//echo 'Mailer error: ' . $mail->ErrorInfo;
				return false;
			else:
				return true;
			endif;
		}
		
		/**
    	 * fileExists()
	     * check file is exists or not
    	 * @return boolean gives back true if file found, gives back false if no file found
	     */    
		public function fileExists($path, $file) {
			$path_parts = pathinfo($path.$file);
			$extension = $path_parts['extension'];
			if(file_exists($path.$file) && $extension == 'sql'):
				return true;
			else:
				$this->errors[] = $file.' doesnot exists.';
				return false;
			endif;
		}
		
		public function formBackupRestore( $file ) {
			//Create a new phpbackup4mysql instance
			$pb4ms = new phpBackup4mysql();
			//Make a new db connexion
			//and restore db to new db "$retore_to_db_name"
			$dbh = $pb4ms->dbconnect();
			$sql_dump = $pb4ms->restoreSQL(BACKUP_DIRECTORY.$file, array(DB_NAME, $dbh));
			if ($sql_dump)
				return true;
			else
				$this->errors[] = 'Database restore failed.';
			return false;
		}
		
		##### COUNTER MODEL ########
		private function getOriginalSitePath(){
			$site_url = SITE_URL;			
			$site_url = str_replace('http://', '', $site_url);
			$pieces = explode("/", $site_url);			
			$removeFirst = array_shift($pieces);
			$pieces = implode("/", $pieces);
			$pieces = strlen($pieces) > 0 ? '/'.$pieces.'/' : '';
			return $pieces;
		}
		public function get_total_counter( $page = false ) {
			$site = $this->getOriginalSitePath();
			if( !$page )
				$sth = $this->db->prepare("SELECT * FROM `". TABLE_PREFIX ."ip2visits` WHERE `on_page` = '". $site ."'");
			else				
				$sth = $this->db->prepare("SELECT * FROM `". TABLE_PREFIX ."ip2visits` WHERE `on_page` != '". $site ."'");
	        $sth->execute();
			return $sth->rowCount();
		}
		
		public function getAllCounter( $limit, $page = false  ){
			$site = $this->getOriginalSitePath();
			if( !$page ) :
				$sth = $this->db->prepare("SELECT v.id, v.ip_adr, DATE_FORMAT(v.visit_date, '%a, %D %b. %Y') visit_date, DATE_FORMAT(v.time, '%r') times, c.country 
						FROM ".TABLE_PREFIX."ip2visits v JOIN ".TABLE_PREFIX."ip2nationcountries c 
						ON v.country = c.code 
						WHERE v.on_page = '". $site ."' ORDER BY visit_date, times DESC ".$limit."");				
			else:
				$sth = $this->db->prepare("SELECT v.id, v.ip_adr, DATE_FORMAT(v.visit_date, '%a, %D %b. %Y') visit_date, DATE_FORMAT(v.time, '%r') times, v.on_page, c.country 
						FROM ".TABLE_PREFIX."ip2visits v JOIN ".TABLE_PREFIX."ip2nationcountries c 
						ON v.country = c.code 
						WHERE v.on_page != '". $site ."' ORDER BY visit_date, times DESC ".$limit."");
			endif;
            $sth->execute();
            return $sth->fetchAll();
		}
		
		function show_visits_today() {
			$site = $this->getOriginalSitePath();
			$sql = sprintf("SELECT COUNT(*) AS counts FROM %s WHERE on_page = '". $site ."' AND visit_date = CURDATE()", TABLE_PREFIX."ip2visits");
			$sth = $this->db->prepare( $sql );
			$sth->execute();
			return $sth->fetch();
		}
		
		function get_popular_pages(){
			$site = $this->getOriginalSitePath();
			$sql = sprintf("SELECT `on_page`, COUNT(`on_page`) as cnt FROM `".TABLE_PREFIX."ip2visits` WHERE on_page != '". $site ."' GROUP BY `on_page` ORDER BY `cnt` DESC LIMIT 0, 10");
			$sth = $this->db->prepare( $sql );
			$sth->execute();
			return $sth->fetchAll();
		}
		
		function get_popular_countries(){
			$site = $this->getOriginalSitePath();
			$sql = "SELECT c.country code, COUNT(*) visits_country, n.country FROM ".TABLE_PREFIX."ip2visits c JOIN ".TABLE_PREFIX."ip2nationcountries n ON n.code = c.country WHERE  c.on_page = '".$site."' ORDER BY 2 DESC LIMIT 0,10";
			$sth = $this->db->prepare( $sql );
			$sth->execute();
			return $sth->fetchAll();
		}
		
	}