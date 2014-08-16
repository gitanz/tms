<?php
	
	class Index_Model extends Model{
		public $errors = array();
		public $adjacencyLists = '';
		
		public function __construct() {        
	        parent::__construct();            
	    }
	    public function breadcrumb($id,$first_call = true){
	    static $breadarray = [];	
		static $breadcrumb;
		if($first_call)
			$breadcrumb .= "<div class = 'breadbrumb'><a href = '".SITE_URL."'>Home  &#0187; </a>";
		else
			$breadcrumb .= "";	
		$sql = "SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_id` = :slug";
		$sth = $this->db->prepare($sql);
		$sth->execute([':slug'=>$id]);
		$result = $sth->fetch();
		if($result->nav_parent != '0'){
			if($result->nav_tpl == "itinerary"){
			$list = "<a href = '".SITE_URL."/itineraries/show/".$result->nav_id."'>";
			$list .= $result->nav_title."  &#0187; </a>";
			$breadarray[] = $list;
			}elseif($result->nav_tpl = "default"){
			$list = "<a href = '".SITE_URL."/index/page/".$result->nav_alias."'>";
			$list .= $result->nav_title."  &#0187; </a>";
			$breadarray[] = $list;
			}
			$this->breadcrumb($result->nav_parent,false);
		}
		else {
			if($result->nav_tpl == "itinerary"){
			$list = "<a href = '".SITE_URL."/itineraries/show/".$result->nav_id."'>";
			$list .= $result->nav_title."  &#0187; </a>";
			$breadarray[] = $list;
			}elseif($result->nav_tpl = "default"){
			$list = "<a href = '".SITE_URL."/index/page/".$result->nav_alias."'>";
			$list .= $result->nav_title." &#0187; </a>";
			$breadarray[] = $list;
			}
			krsort($breadarray);
			foreach($breadarray as $array){
				$breadcrumb .= $array;
			}
			$breadcrumb.="</div>";
		}
		return $breadcrumb;
	}
	public function searchQuery(){
			$query = $_GET['query'];
			$sql = "SELECT `page_title` AS `title` , `page_alias` AS `slug` , `page_content` AS `content`, @table := 'page' AS `tablename`
					FROM `".TABLE_PREFIX."pages`
					WHERE `page_content` LIKE :query
					OR `page_title` LIKE :query
					";
			$sth = $this->db->prepare($sql);
			$sth->execute(array(':query'=>'%'.$query.'%'));
	        return $sth->fetchAll();

		}
		public function getAlbums(){
			$sql = "SELECT adc_itinerary_gallery . *, adc_itineraries . *
					FROM `adc_itinerary_gallery`
					INNER JOIN `adc_itineraries` ON adc_itinerary_gallery . gallery_parent = adc_itineraries . trip_id 
					GROUP BY `gallery_parent` ";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			return($sth->fetchAll());		
		}
		public function getAlbumImages($id){
			$sql = "SELECT *
					FROM `adc_itinerary_gallery`
					WHERE `gallery_parent` = :id ";
			$sth = $this->db->prepare($sql);
			$sth->execute([':id'=>$id]);
			return($sth->fetchAll());
		}
		public function getVAlbums(){
			$sql = "SELECT `adc_itinerary_video`.*, adc_itineraries . *
					FROM `adc_itinerary_video`
					INNER JOIN `adc_itineraries` ON adc_itinerary_video . video_parent = adc_itineraries . trip_id 
					GROUP BY `video_parent` ";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			return($sth->fetchAll());		
		}
		public function getAlbumVideos($id){
			$sql = "SELECT *
					FROM `adc_itinerary_video`
					WHERE `video_parent` = :id ";
			$sth = $this->db->prepare($sql);
			$sth->execute([':id'=>$id]);
			return($sth->fetchAll());
		}
		public function getMenuBySlug( $slug ) {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_alias` = :alias; AND `nav_status` = '1'");
	        $sth->execute(array(':alias' => $slug));
	        return $sth->fetch();
    	}
		public function getMenuAlias( $slug ) {
			$sql = "SELECT ".TABLE_PREFIX."navigations.* , ".TABLE_PREFIX."pages.*
					FROM `".TABLE_PREFIX."navigations`
					RIGHT JOIN ".TABLE_PREFIX."pages ON ".TABLE_PREFIX."navigations.nav_id = ".TABLE_PREFIX."pages.page_parent 
					WHERE `nav_alias` = :alias AND `nav_status` = '1'";
			$sth = $this->db->prepare($sql);
	        $sth->execute(array(':alias' => $slug));
	        return $sth->fetchAll();
    	}
    	public function getPage($id){
    		$sql = "SELECT ".TABLE_PREFIX."pages . *,".TABLE_PREFIX."navigations . * 
    				FROM ".TABLE_PREFIX."pages 
    				INNER JOIN ".TABLE_PREFIX."navigations ON ".TABLE_PREFIX."pages . page_parent = ".TABLE_PREFIX."navigations . nav_id 
    				WHERE `page_id` = :id";
    		$sth = $this->db->prepare($sql);
    		$sth->execute([':id'=>$id]);
    		return $sth->fetchAll();
    	}
		public function getPagebyParentID( $id ) {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."pages` WHERE `page_parent` = :id; AND `page_status` = '1'");
	        $sth->execute(array(':id' => $id));
	        return $sth->fetch();
    	}
		
		public function get_all_count( $id ) {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."pages` WHERE `page_parent` = :id; AND `page_status` = '1'");
	        $sth->execute(array(':id' => $id));
			return $sth->rowCount();
		}
		
		public function getPagesbyParentID( $limit, $id ) {
			$page_order = ORDER_PAGE == 'order' ? 'page_order' : 'page_added';
			$page_orderby = ORDER_PAGE_BY == 'asc' ? 'ASC' : 'DESC';

			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."pages` WHERE `page_parent` = :id AND `page_status` = '1' ORDER BY `".$page_order."` ".$page_orderby." ".$limit."");

	        $sth->execute(array(':id' => $id));
	        return $sth->fetchAll();
    	}
		
		public function getPageBySlug( $slug ) {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."pages` WHERE `page_alias` = :alias; AND `page_status` = '1'");
	        $sth->execute(array(':alias' => $slug));
	        return $sth->fetch();
    	}
		
		public function getGalleriesbyNavID( $id ) {
			$sth = $this->db->prepare("SELECT a.gly_id, a.gly_title, a.gly_alias, b.image FROM ".TABLE_PREFIX."galleries a INNER JOIN( SELECT gly_parent, gly_path image FROM ".TABLE_PREFIX."galleries WHERE gly_parent <> gly_id GROUP BY gly_parent ) b ON a.gly_id = b.gly_parent WHERE a.gly_navid = :id AND a.gly_status = '1' ORDER BY a.gly_added DESC");
	        $sth->execute(array(':id' => $id));
	        return $sth->fetchAll();
    	}
		
		public function getGalleryBySlug( $slug ) {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."galleries` WHERE `gly_alias` = :alias; AND `gly_status` = '1'");
	        $sth->execute(array(':alias' => $slug));
	        return $sth->fetch();
    	}
		
		public function getGalleriesbyParentID( $id ) {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."galleries` WHERE `gly_parent` = :id AND `gly_status` = '1' ORDER BY `gly_added` DESC");
	        $sth->execute(array(':id' => $id));
	        return $sth->fetchAll();
    	}
		
		public function getDemandsListing(){
			$sth = $this->db->prepare('SELECT cat.cat_title, ctr.ctry_title, ctr.ctry_alias, dmd.* FROM '.TABLE_PREFIX.'careers_categories cat LEFT JOIN '.TABLE_PREFIX.'careers_demands dmd ON cat.cat_id = dmd.dmd_category LEFT JOIN '.TABLE_PREFIX.'careers_countries ctr ON dmd.dmd_country = ctr.ctry_id WHERE dmd.dmd_status = "1" AND cat.cat_status = "1" AND ctr.ctry_status = "1" ORDER BY dmd.dmd_added DESC');
			$sth->execute();
	        return $sth->fetchAll();
		}
		
		public function getDemandsCategory(){
			$sth = $this->db->prepare('SELECT * FROM `'.TABLE_PREFIX.'careers_categories` ORDER BY `cat_title`;');
			$sth->execute();
	        return $sth->fetchAll();
		}
		
		public function getDemandsCountry(){
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."careers_countries` WHERE `ctry_status` = '1' ORDER BY `ctry_title`;");
	        $sth->execute();
			return $sth->fetchAll();
		}
		
		public function getCountryBySlug( $slug ) {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."careers_countries` WHERE `ctry_alias` = :alias; AND `ctry_status` = '1'");
	        $sth->execute(array(':alias' => $slug));
	        return $sth->fetch();
    	}
		
		public function getDemandsByCountrySlug( $id ){
			$sth = $this->db->prepare('SELECT cat.cat_title, ctr.ctry_title, ctr.ctry_alias, dmd.* FROM '.TABLE_PREFIX.'careers_categories cat LEFT JOIN '.TABLE_PREFIX.'careers_demands dmd ON cat.cat_id = dmd.dmd_category LEFT JOIN '.TABLE_PREFIX.'careers_countries ctr ON dmd.dmd_country = ctr.ctry_id WHERE dmd.dmd_country = "'.$id.'" AND dmd.dmd_status = "1" AND cat.cat_status = "1" AND ctr.ctry_status = "1" ORDER BY dmd.dmd_added DESC');			
			$sth->execute();
	        return $sth->fetchAll();
		}
		
		public function getCategoryBySlug( $slug ) {
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."careers_categories` WHERE `cat_alias` = :alias; AND `cat_status` = '1'");
	        $sth->execute(array(':alias' => $slug));
	        return $sth->fetch();
    	}
		
		public function getDemandsByCategorySlug( $id ){
			$sth = $this->db->prepare('SELECT cat.cat_title, ctr.ctry_title, ctr.ctry_alias, dmd.* FROM '.TABLE_PREFIX.'careers_categories cat LEFT JOIN '.TABLE_PREFIX.'careers_demands dmd ON cat.cat_id = dmd.dmd_category LEFT JOIN '.TABLE_PREFIX.'careers_countries ctr ON dmd.dmd_country = ctr.ctry_id WHERE dmd.dmd_category = "'.$id.'" AND dmd.dmd_status = "1" AND cat.cat_status = "1" AND ctr.ctry_status = "1" ORDER BY dmd.dmd_added DESC');			
			$sth->execute();
	        return $sth->fetchAll();
		}
		
		public function getJobBySlug( $slug ) {
			$sth = $this->db->prepare('SELECT cat.cat_title, cat.cat_alias, ctr.ctry_title, ctr.ctry_alias, dmd.* FROM '.TABLE_PREFIX.'careers_categories cat LEFT JOIN '.TABLE_PREFIX.'careers_demands dmd ON cat.cat_id = dmd.dmd_category LEFT JOIN '.TABLE_PREFIX.'careers_countries ctr ON dmd.dmd_country = ctr.ctry_id WHERE dmd.dmd_alias = "'.$slug.'" AND dmd.dmd_status = "1" AND cat.cat_status = "1" AND ctr.ctry_status = "1"');
	        $sth->execute(array(':alias' => $slug));
	        return $sth->fetch();
    	}
		
		public function formDataSave() {
			session_start();
			$_SESSION['form_token'] = isset ($_SESSION['form_token']) ? $_POST['form_token'] : '';
			if( ($_POST['form_token'] == $_SESSION['form_token']) ) :
				//var_dump( $_POST );
				
				$txtPostID = $_POST['txtID'];
				$txtPost = $_POST['txtPost'];
				$txtPostCountry = $_POST['txtPostCountry'];
				$txtName = $_POST['txtName'];
				$txtDOB = $_POST['txtDOB'];
				$txtEmail = $_POST['txtEmail'];
				$txtAddress = $_POST['txtAddress'];
				$txtPhone = $_POST['txtPhone'];
				$txtPPNo = $_POST['txtPPNo'];
				$txtDOI = $_POST['txtDOI'];
				$txtDOE = $_POST['txtDOE'];
				$txtCountry = $_POST['txtCountry'];
				$radGender = $_POST['radGender'];
				$radMarital = $_POST['radMarital'];
				$txtReligion = $_POST['txtReligion'];
				$txtKin = $_POST['txtKin'];
				$txtKinAddress = $_POST['txtKinAddress'];
				$radEduLvl = $_POST['radEduLvl'];
				$txtTechKnow = $_POST['txtTechKnow'];
				
				$txtDuration = serialize( $_POST['txtDuration'] );
				$txtComCon = serialize( $_POST['txtComCon'] );
				$txtPosition = serialize( $_POST['txtPosition'] );
				
				$language_eng_written = isset( $_POST['language_eng_written'] ) ? $_POST['language_eng_written'] : '';
				$language_eng_spoken = isset( $_POST['language_eng_spoken'] ) ? $_POST['language_eng_spoken'] : '';
				$language_hin_written = isset( $_POST['language_hin_written'] ) ? $_POST['language_hin_written'] : '';
				$language_hin_spoken = isset( $_POST['language_hin_spoken'] ) ? $_POST['language_hin_spoken'] : '';
				$language_oth_written = isset( $_POST['language_oth_written'] ) ? $_POST['language_oth_written'] : '';
				$language_oth_spoken = isset( $_POST['language_oth_spoken'] ) ? $_POST['language_oth_spoken'] : '';
				
				$language_eng = $language_eng_written[0] . '|' . $language_eng_spoken[0];
				$language_hin = $language_hin_written[0] . '|' . $language_hin_spoken[0];
				$language_oth = $language_oth_written[0] . '|' . $language_oth_spoken[0];
				
				if($_FILES['txtPhoto']['name']!=""):
					$photo = $_FILES['txtPhoto']['name'];																								
					$photo = str_replace(".JPG",".jpg", $photo);
					$photo = str_replace(" ","_", $photo);
					$photo = randomkeys(3)."__". $photo;				
				else:
					$photo = "";						
				endif;
				
				if($_FILES['txtDocument']['name']!=""):
					$docs = $_FILES['txtDocument']['name'];																								
					$docs = str_replace(".PDF",".pdf", $docs);
					$docs = str_replace(" ","_", $docs);
					$docs = randomkeys(3)."__". $docs;				
				else:
					$docs = "";						
				endif;
				
				
				
				$sth = $this->db->prepare("INSERT INTO `".TABLE_PREFIX."careers_applicants`
									  (`app_job_id`, `app_applied_post`, `app_applied_country`, `app_fullname`, `app_dob`, `app_email`, `app_address`, `app_contact`, `app_pp_no`, `app_pp_issue`, `app_pp_expiry`, `app_nationality`, `app_gender`, `app_marital_status`, `app_religion`, `app_kin`, `app_kin_address`, `app_photo`, `app_documents`, `app_education`, `app_tech_knowledge`, `app_exp_duration`, `app_exp_company`, `app_exp_position`, `app_lang_en`, `app_lang_hi`, `app_lang_ot`, `app_ip`, `app_added_date`) VALUES 
									  (:apppostid, :apppost, :appcountry, :appname, :appdob, :appemail, :appaddress, :appcontact, :appppno, :appppissue, :appppexpiry, :appnationality, :appgender, :appmstatus, :appreligion, :appkin, :appkinadd, :appphoto, :appdocs, :appeducation, :apptech, :appexpdur, :appexpcomapany, :appexpposition, :applangen, :applanghi, :applangot, :appip, :appdate);");
									  
				$user_ip = getUserIP();
				
				$data = array(
							':apppostid' => $txtPostID,
							':apppost' => ucfirst($txtPost),
							':appcountry' => ucfirst($txtPostCountry),
							':appname' => ucfirst($txtName),
							':appdob' => ucfirst($txtDOB),
							':appemail' => ucfirst($txtEmail),
							':appaddress' => ucfirst($txtAddress),
							':appcontact' => ucfirst($txtPhone),
							':appppno' => ucfirst($txtPPNo),
							':appppissue' => ucfirst($txtDOI),
							':appppexpiry' => ucfirst($txtDOE),
							':appnationality' => ucfirst($txtCountry),
							':appgender' => ucfirst($radGender),
							':appmstatus' => ucfirst($radMarital),
							':appreligion' => ucfirst($txtReligion),
							':appkin' => ucfirst($txtKin),
							':appkinadd' => ucfirst($txtKinAddress),
							':appphoto' => $photo,
							':appdocs' => $docs,
							':appeducation' => $radEduLvl,
							':apptech' => ucfirst($txtTechKnow),
							':appexpdur' => $txtDuration,
							':appexpcomapany' => $txtComCon,
							':appexpposition' => $txtPosition,
							':applangen' => ucfirst($language_eng),
							':applanghi' => ucfirst($language_hin),
							':applangot' => ucfirst($language_oth),
							':appip' => $user_ip,
							':appdate' => DATETIME);
				
				//var_dump( $data );
				
				$sth->execute( $data );
				$insertID = $this->db->lastInsertId();
				
				if( $insertID ) :
					
					if ( $photo != '')
						@move_uploaded_file($_FILES['txtPhoto']['tmp_name'], "uploads/applicants/$photo");
					if ( $docs != '')
						@move_uploaded_file($_FILES['txtDocument']['tmp_name'], "uploads/applicants/$docs");
						
					$mail = new PHPMailer;
					$mail->IsMail();
					$mail->From = SITE_EMAIL;
			        $mail->FromName = SITE_NAME;        
			        $mail->AddAddress($txtEmail, $txtName);
			        $mail->Subject = SITE_NAME. ': New Online Form Submission';
					$mail->Body = 'Hello Admin,<br /> New online form is submitted by '. $txtName .' for '. $txtPost .'<br />System Automated Mailer.';
					$mail->MsgHTML($mail->Body);
					unset($_SESSION['form_token']);
					if(!$mail->Send()):
						$this->errors[] ='<div class="alert alert-info">
								              <strong>Success!</strong> You successfully submitted online form.
								            </div>';
					else:						
						$this->errors[] = '<div class="alert alert-success">
								              <strong>Success!</strong> You successfully submitted online form.
							            	</div>';
					endif;
					
					return true;
				
				else:
					$this->errors[] = '<div class="alert alert-error"><strong>Error!</strong> We cannot accept your form application in this time. Please try again later.</div>';
					return false;
				endif;
			else:
				$this->errors[] = '<div class="alert alert-error"><strong>Error!</strong> Your application is already submitted..</div>';
					return false;
			endif;
		}
		
		public function formDataSend(){			
			session_start();
			$_SESSION['form_token'] = isset ($_SESSION['form_token']) ? $_POST['form_token'] : '';
			if( ($_POST['form_token'] == $_SESSION['form_token']) ) :
				
				$txtName = $_POST['txtName'];
				$txtEmail = $_POST['txtEmail'];
				$txtMessage = $_POST['txtMessage'];
				$txtPhone = $_POST['txtPhone'];
				
				$mail = new PHPMailer;
				$mail->IsMail();
				$mail->From = $txtEmail;
			    $mail->FromName = $txtName;        
			    $mail->AddAddress(SITE_EMAIL, SITE_NAME);
			    $mail->Subject = SITE_NAME. ': Contact Form Submission';
				$mail->Body = 'Hello Admin,<br /> '. $txtName .' have contacted you via site '. SITE_NAME .'<br /><hr />Name: '.$txtName.'<br />Email: '.$txtEmail.'<br />Contact No: '.$txtPhone.'<br />Message: '.$txtMessage.'<hr />System Automated Mailer.';
				$mail->MsgHTML($mail->Body);
				unset($_SESSION['form_token']);
				
				if(!$mail->Send()):
					$this->errors[] ='<div class="alert alert-info">
							              <strong>Success!</strong> Your message is successfully delivered.
						            </div>';
				else:						
					$this->errors[] = '<div class="alert alert-success">
							              <strong>Success!</strong> Your message is successfully delivered.
						            	</div>';
				endif;
					
				return true;
				
				
			
			else:
				$this->errors[] = '<div class="alert alert-error"><strong>Error!</strong> Your message is already submitted.</div>';
				return false;
			endif;
			
		}
		
		public function formDataReqSend(){			
			session_start();
			$_SESSION['form_token_req'] = !isset ($_SESSION['form_token_req']) ? '' : $_POST['form_token_req'];
			if( ($_POST['form_token_req'] == $_SESSION['form_token_req']) ) :
				
				$txtName = $_POST['txtName'];
				$txtEmail = $_POST['txtEmail'];
				$txtAddress = $_POST['txtAddress'];
				$txtPhone = $_POST['txtPhone'];
				$txtCountry = $_POST['txtCountry'];
				$txtCity = $_POST['txtCity'];
				$txtFax = $_POST['txtFax'];
				$txtContactPerson = $_POST['txtContactPerson'];
				$txtPostName = $_POST['txtPostName'];
				$txtJobReq = $_POST['txtJobReq'];
				$txtJobSalary = $_POST['txtJobSalary'];
				$radVisaType = $_POST['radVisaType'];
				$radTicket = $_POST['radTicket'];
				$radFood = $_POST['radFood'];
				$radAccomodation = $_POST['radAccomodation'];
				$radWrkingHr = $_POST['radWrkingHr'];
				$radWrkingDays = $_POST['radWrkingDays'];
				$radOT = $_POST['radOT'];
				$radContract = $_POST['radContract'];
				$txtOther = $_POST['txtOther'];

				
				$mail = new PHPMailer;
				$mail->IsMail();
				$mail->From = $txtEmail;
			    $mail->FromName = $txtName;        
			    $mail->AddAddress(SITE_EMAIL, SITE_NAME);
			    $mail->Subject = SITE_NAME. ': New Manpower Requirements';
				$mail->Body = 'Hello Admin,<br /> Company '. $txtName .' have contacted you via site '. SITE_NAME .' for manpower demands.<br />Here is the Details<hr /><strong>Company Details</strong><br />Company Name: '.$txtName.'<br />Country: '.$txtCountry.'<br />City: '.$txtCity.'<br /> Contact No.: '.$txtPhone.'<br /> Fax No.: '.$txtFax.'<br /> Email: '.$txtEmail.'<br /> Contact Person Name: '.$txtContactPerson.'<br /> Postal Address: '.$txtAddress.'<br /><br /><strong>Job Details</strong><br /> Post Title: '.$txtPostName.'<br />  Required No.: '.$txtJobReq.'<br /> Salary: '.$txtJobSalary.'<br /> Visa Type: '.$radVisaType.'<br /> Ticket: '.$radTicket.'<br /> Food: '.$radFood.'<br /> Accomodation: '.$radAccomodation.'<br /> Working Hour: '.$radWrkingHr.'<br /> Working Days: '.$radWrkingDays.'<br /> Over Time available: '.$radOT.'<br /> Contract Period: '.$radContract.'<br /> Other Requirements: '.$txtOther.'<hr />System Automated Mailer.';
				$mail->MsgHTML($mail->Body);

				unset($_SESSION['form_token_req']);
				
				if(!$mail->Send()):
					$this->errors[] ='<div class="alert alert-info">
							              <strong>Success!</strong> Your requirement is successfully delivered.
						            </div>';
				else:						
					$this->errors[] = '<div class="alert alert-success">
							              <strong>Success!</strong> Your requirement is successfully delivered.
						            	</div>';
				endif;
					
				return true;
				
				
			
			else:
				$this->errors[] = '<div class="alert alert-error"><strong>Error!</strong> Your requirement is already submitted.</div>';
				return false;
			endif;
			
		}
		
		public function formDataCVSend(){
			session_start();
			$_SESSION['form_token_cv'] = !isset ($_SESSION['form_token_cv']) ? '' : $_POST['form_token_cv'];
			if( ($_POST['form_token_cv'] == $_SESSION['form_token_cv']) ) :
				
				$txtName = $_POST['txtName'];
				$txtEmail = $_POST['txtEmail'];
				$txtAddress = $_POST['txtAddress'];
				$txtPhone = $_POST['txtPhone'];
				$txtCountry = $_POST['txtCountry'];
				$txtDOB = $_POST['txtDOB'];
				$txtPPNo = $_POST['txtPPNo'];
				$txtDOI = $_POST['txtDOI'];
				$txtDOE = $_POST['txtDOE'];
				$radGender = $_POST['radGender'];
				$radMarital = $_POST['radMarital'];
				$txtReligion = $_POST['txtReligion'];
				$txtKin = $_POST['txtKin'];
				$txtKinAddress = $_POST['txtKinAddress'];
				$radEduLvl = $_POST['radEduLvl'];
				$txtTechKnow = $_POST['txtTechKnow'];
				
				$experience = '';
				
				$_POST['txtDuration'] = array_filter($_POST['txtDuration']);
				$_POST['txtComCon'] = array_filter($_POST['txtComCon']);
				$_POST['txtPosition'] = array_filter($_POST['txtPosition']);
				
				if ( !empty( $_POST['txtDuration'] ) || !empty( $_POST['txtComCon'] ) || !empty( $_POST['txtPosition'] ) ):
					$txtDuration = $_POST['txtDuration'];
					$txtComCon = $_POST['txtComCon'];
					$txtPosition = $_POST['txtPosition'];
					
					$experience .= '<table class="table" width="100%;">
										<thead>
											<tr align="left">
											  <th>Duration</th>
											  <th>Company and Country</th>
											  <th>Position Held</th>
											</tr>
								  		</thead>
										<tbody>';
					for ( $i = 0; $i < count( $_POST['txtDuration'] ); $i++ ) :
						$experience .= '<tr>										  	
										  	<td>'. $txtDuration[$i] .'</td>
										  	<td>'. $txtComCon[$i] .'</td>
										  	<td>'. $txtPosition[$i] .'</td>
										</tr>';
					
					endfor;
					$experience .= '		</tbody>
									</table>';
				endif;
				
				$education = '<table class="table" width="100%">
								<tr>
									<td><strong>Languages</strong></td>
									<td><strong>Written</strong></td>
									<td><strong>Spoken</strong></td>
								</tr>
								<tr>
									<td>English</td>
									<td>'. (isset( $_POST['language_eng_written'] ) ? $_POST['language_eng_written'][0] : 'N/A')  .'</td>
									<td>'. (isset( $_POST['language_eng_spoken'] ) ? $_POST['language_eng_spoken'][0] : 'N/A')  .'</td>
								</tr>
								<tr>
									<td>Hindi</td>
									<td>'. (isset( $_POST['language_hin_written'] ) ? $_POST['language_hin_written'][0] : 'N/A')  .'</td>
									<td>'. (isset( $_POST['language_hin_spoken'] ) ? $_POST['language_hin_spoken'][0] : 'N/A')  .'</td>
								</tr>
								<tr>
									<td>Other</td>
									<td>'. (isset( $_POST['language_oth_written'] ) ? $_POST['language_oth_written'][0] : 'N/A')  .'</td>
									<td>'. (isset( $_POST['language_oth_spoken'] ) ? $_POST['language_oth_spoken'][0] : 'N/A')  .'</td>
								</tr>								
							</table>';
				
				$email_body = '<table class="table" width="100%;">
									<tbody>
										<tr>
											<td colspan="2"><strong>Personal Details</strong></td>
										</tr>
										<tr>
											<td>Full Name</td>
											<td> '. $txtName .' </td>
										</tr>
										<tr>
											<td>Date of birth</td>
											<td> '. $txtDOB .' </td>
										</tr>
										<tr>
											<td>Email</td>
											<td> '. $txtEmail .' </td>
										</tr>
										<tr>
											<td>Address</td>
											<td> '. $txtAddress .' </td>
										</tr>
										<tr>
											<td>Contact No.</td>
											<td> '. $txtPhone .' </td>
										</tr>
										<tr>
											<td>Passport No.</td>
											<td> '. $txtPPNo .' </td>
										</tr>
										<tr>
											<td>Date of Issue</td>
											<td> '. $txtDOI .' </td>
										</tr>
										<tr>
											<td>Date of Expiry</td>
											<td> '. $txtDOE .' </td>
										</tr>
										<tr>
											<td>Nationality</td>
											<td> '. $txtCountry .' </td>
										</tr><tr>
											<td>Gender</td>
											<td> '. $radGender .' </td>
										</tr>
										<tr>
											<td>Marital Status</td>
											<td> '. $radMarital .' </td>
										</tr>
										<tr>
											<td>Religion</td>
											<td> '. $txtReligion .' </td>
										</tr>
										<tr>
											<td>Next of Kin</td>
											<td> '. $txtKin .' </td>
										</tr>
										<tr>
											<td>Address of Kin</td>
											<td> '. $txtKinAddress .' </td>
										</tr>
										<tr height="10">
											<td colspan="2"><hr /></td>
										</tr>
										<tr>
											<td colspan="2"><strong>Education</srong></td>
										</tr>
										<tr>
											<td>Level</td>
											<td> '. $radEduLvl .' </td>
										</tr>
										<tr>
											<td>Technical Knowledge In</td>
											<td> '. $txtTechKnow .' </td>
										</tr>
										<tr height="10">
											<td colspan="2"><hr /></td>
										</tr>
										<tr>
											<td colspan="2"><strong>Work and Experience</srong></td>
										</tr>
										<tr>
											<td colspan="2">
											'. $experience .'
											</td>
										</tr>
										<tr height="10">
											<td colspan="2"><hr /></td>
										</tr>
										<tr>
											<td colspan="2"><strong>Languages</srong></td>
										</tr>
										<tr>
											<td colspan="2">
											'. $education .'
											</td>
										</tr>
									</tbody>
								</table>
								';
				
				$mail = new PHPMailer;
				$mail->IsMail();
				$mail->From = $txtEmail;
			    $mail->FromName = $txtName;        
			    $mail->AddAddress(SITE_EMAIL, SITE_NAME);
			    $mail->Subject = SITE_NAME. ': New CV Recieved';
				$mail->Body = 'Hello Admin,<br /> You have recieved new cv from manpower<br />'.$email_body;
				$mail->MsgHTML($mail->Body);

				unset($_SESSION['form_token_cv']);
				
				if(!$mail->Send()):
					$this->errors[] ='<div class="alert alert-info">
							              <strong>Success!</strong> Your CV is successfully delivered.
						            </div>';
				else:						
					$this->errors[] = '<div class="alert alert-success">
							              <strong>Success!</strong> Your CV is successfully delivered.
						            	</div>';
				endif;
					
				return true;
				
				
			
			else:
				$this->errors[] = '<div class="alert alert-error"><strong>Error!</strong> Your CV is already submitted.</div>';
				return false;
			endif;
			
		}
		
		public function formDataCVPrint(){
			
			$txtName = $_POST['txtName'];
			$txtEmail = $_POST['txtEmail'];
			$txtAddress = $_POST['txtAddress'];
			$txtPhone = $_POST['txtPhone'];
			$txtCountry = $_POST['txtCountry'];
			$txtDOB = $_POST['txtDOB'];
			$txtPPNo = $_POST['txtPPNo'];
			$txtDOI = $_POST['txtDOI'];
			$txtDOE = $_POST['txtDOE'];
			$radGender = $_POST['radGender'];
			$radMarital = $_POST['radMarital'];
			$txtReligion = $_POST['txtReligion'];
			$txtKin = $_POST['txtKin'];
			$txtKinAddress = $_POST['txtKinAddress'];
			$radEduLvl = $_POST['radEduLvl'];
			$txtTechKnow = $_POST['txtTechKnow'];
			
			$experience = '';
			
			$_POST['txtDuration'] = array_filter($_POST['txtDuration']);
			$_POST['txtComCon'] = array_filter($_POST['txtComCon']);
			$_POST['txtPosition'] = array_filter($_POST['txtPosition']);
				
			if ( !empty( $_POST['txtDuration'] ) || !empty( $_POST['txtComCon'] ) || !empty( $_POST['txtPosition'] ) ):
				$txtDuration = $_POST['txtDuration'];
				$txtComCon = $_POST['txtComCon'];
				$txtPosition = $_POST['txtPosition'];
				$experience .= '<h2>Work and Experience</h2>';
				$experience .= '<table class="table" width="100%;">
									<thead>
										<tr align="left">
										  <th>Duration</th>
										  <th>Company and Country</th>
										  <th>Position Held</th>
										</tr>
									</thead>
									<tbody>';
				for ( $i = 0; $i < count( $_POST['txtDuration'] ); $i++ ) :
					$experience .= '<tr>										  	
										<td>'. $txtDuration[$i] .'</td>
										<td>'. $txtComCon[$i] .'</td>
										<td>'. $txtPosition[$i] .'</td>
									</tr>';
				
				endfor;
				$experience .= '		</tbody>
								</table>';
			endif;
			
			$languages = '  <h2> Languages </h2>
							<table class="table" width="100%">
								<tr>
									<td><strong>Languages</strong></td>
									<td><strong>Written</strong></td>
									<td><strong>Spoken</strong></td>
								</tr>
								<tr>
									<td>English</td>
									<td>'. (isset( $_POST['language_eng_written'] ) ? $_POST['language_eng_written'][0] : 'N/A')  .'</td>
									<td>'. (isset( $_POST['language_eng_spoken'] ) ? $_POST['language_eng_spoken'][0] : 'N/A')  .'</td>
								</tr>
								<tr>
									<td>Hindi</td>
									<td>'. (isset( $_POST['language_hin_written'] ) ? $_POST['language_hin_written'][0] : 'N/A')  .'</td>
									<td>'. (isset( $_POST['language_hin_spoken'] ) ? $_POST['language_hin_spoken'][0] : 'N/A')  .'</td>
								</tr>
								<tr>
									<td>Other</td>
									<td>'. (isset( $_POST['language_oth_written'] ) ? $_POST['language_oth_written'][0] : 'N/A')  .'</td>
									<td>'. (isset( $_POST['language_oth_spoken'] ) ? $_POST['language_oth_spoken'][0] : 'N/A')  .'</td>
								</tr>								
							</table>';
			
			$template = '<!DOCTYPE html>
						 <html lang="en">
							<head>    	
								<meta charset="utf-8">
								<meta http-equiv="X-UA-Compatible" content="IE=edge">
								<meta name="viewport" content="width=device-width, initial-scale=1.0">
								<title>'.SITE_NAME.' &#8250; CV for '.$txtName.'</title>
								<style>
									#container {	margin: 0 auto; width: 800px; background:#fff;}
									#header { background:#fff; padding: 20px; text-align:center }
									#header h1 { margin: 0; }
									#content { clear: left; padding: 10px;}
									#content h2 { color:#000; font-size: 120%; margin: 0 0 .5em; border-bottom: 1px solid #ccc; padding: 0 0 .3em; }
								</style>
							</head>
						
							<body onload="window.print()">
								<div id="container">
									<div id="header">
										<h1>'.ucwords($txtName).'</h1>
										'. $txtAddress .', '. $txtCountry .' <br />
										Telephone: '. $txtPhone .' | Email: '. $txtEmail .'
									</div>									
									<div id="content">
										'. $experience .'<br />
										'. $languages .'<br />
										<h2>Education</h2><br />
										<table class="table" width="100%;">
											<tbody>
											<tr>
												<td width="22%">Level</td>
												<td> '. $radEduLvl .' </td>
											</tr>
											<tr>
												<td>Technical Knowledge In</td>
												<td> '. $txtTechKnow .' </td>
											</tr>
											</tbody>
										</table><br />
										<h2>Personal Details</h2>
										<table class="table" width="100%;">
										<tbody>

											<tr>
												<td width="22%">Full Name</td>
												<td> '. $txtName .' </td>
											</tr>
											<tr>
												<td>Date of birth</td>
												<td> '. $txtDOB .' </td>
											</tr>
											<tr>
												<td>Email</td>
												<td> '. $txtEmail .' </td>
											</tr>
											<tr>
												<td>Address</td>
												<td> '. $txtAddress .' </td>
											</tr>
											<tr>
												<td>Contact No.</td>
												<td> '. $txtPhone .' </td>
											</tr>
											<tr>
												<td>Passport No.</td>
												<td> '. $txtPPNo .' </td>
											</tr>
											<tr>
												<td>Date of Issue</td>
												<td> '. $txtDOI .' </td>
											</tr>
											<tr>
												<td>Date of Expiry</td>
												<td> '. $txtDOE .' </td>
											</tr>
											<tr>
												<td>Nationality</td>
												<td> '. $txtCountry .' </td>
											</tr><tr>
												<td>Gender</td>
												<td> '. $radGender .' </td>
											</tr>
											<tr>
												<td>Marital Status</td>
												<td> '. $radMarital .' </td>
											</tr>
											<tr>
												<td>Religion</td>
												<td> '. $txtReligion .' </td>
											</tr>
											<tr>
												<td>Next of Kin</td>
												<td> '. $txtKin .' </td>
											</tr>
											<tr>
												<td>Address of Kin</td>
												<td> '. $txtKinAddress .' </td>
											</tr>
										</tbody>
									</table>
									<br />
									<p>References available on request.</p>										
									
									</div>
								</div>
							</body>
						</html>';
						
			return $template;
			
		}
		
		public function getAllAvailableCategories( $parent_id = 0 ){
			
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."careers_categories` WHERE `cat_parent` = :parent_id AND `cat_status` = :status  ORDER BY `cat_title`;");
	        $sth->execute(array(':parent_id' => $parent_id, ':status' => 1));
	        $oCategories = $sth->fetchAll();
					
			foreach ( $oCategories as $key=>$value) :
				
				$in = $key == 0 ? 'in' : '';
				$this->adjacencyLists .= '<div class="accordion-group">
                                    	<div class="accordion-heading">
		                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$value->cat_id.'">'.$value->cat_title.'</a>
                        	            </div>
										<div id="collapse'.$value->cat_id.'" class="accordion-body collapse '.$in.'">
                                		    <div class="accordion-inner">
			                                    <div class="columns">';
					$sths = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."careers_categories` WHERE `cat_parent` = :parent_id AND `cat_status` = :status  ORDER BY `cat_title`;");
					$sths->execute(array(':parent_id' => $value->cat_id, ':status' => 1));
					$oSubCategories = $sths->fetchAll();
					$count =  $sths->rowCount();
					$this->adjacencyLists .= '<ul>';
					if ($count > 0) :
						foreach ( $oSubCategories as $value) :
							$this->adjacencyLists .= '<li><a href="'.SITE_URL.'/index/jobs/categories-wise/'.$value->cat_alias.'" title="View Category">'.$value->cat_title.'</a></li>';
						endforeach;
					else:
						$this->adjacencyLists .= '<li>No subcategory</li>';
					endif;
					$this->adjacencyLists .= '</ul>';
					
												
				$this->adjacencyLists .= '		</div>
											</div>
										</div>
										';
				$this->adjacencyLists .= '</div>';
				
			endforeach;
			
			return $this->adjacencyLists;
			
		}
		
	}