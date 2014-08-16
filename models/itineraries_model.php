<?php 
/**
 * class Itineraries_Model
 * handles Itineraries modules
 * @package HimalayanPursuits
 * @author 
 * @link 
 */
class Itineraries_Model extends Model{

	public function __construct(){
		parent::__construct();
	}
	public function getItineraryRoots(){
		$sql = "SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_itinerary` = '1' && `nav_status` = '1'";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}
	public function fetchGallery($parent){
		$sql = "SELECT  ".TABLE_PREFIX."itinerary_gallery . *, ".TABLE_PREFIX."itinerary_video . * FROM `".TABLE_PREFIX."itinerary_gallery` 
				LEFT JOIN  
				".TABLE_PREFIX."itinerary_video 
				ON 
				".TABLE_PREFIX."itinerary_gallery.gallery_parent = ".TABLE_PREFIX."itinerary_video.video_parent
				WHERE 
				".TABLE_PREFIX."itinerary_gallery.gallery_parent = :id 
				LIMIT 1
				";
		$sth = $this->db->prepare($sql);
		$sth->execute([":id"=>$parent]);
		return $sth->fetch();
	}
	public function getRandomTrips($cat_id,$tr_id){
		$sql = "SELECT ".TABLE_PREFIX."itineraries . *,".TABLE_PREFIX."itinerary_info . *
				FROM ".TABLE_PREFIX."itineraries 
				LEFT JOIN ".TABLE_PREFIX."itinerary_info ON ".TABLE_PREFIX."itineraries.trip_id = ".TABLE_PREFIX."itinerary_info.info_parent
				WHERE ".TABLE_PREFIX."itineraries.category_id = :catId AND ".TABLE_PREFIX."itineraries.trip_id != :trId
				ORDER BY RAND()
				LIMIT 10";
		$sth = $this->db->prepare($sql);
		$sth->execute([":catId"=>$cat_id,":trId"=>$tr_id]);
		return $sth->fetchAll();
	}
	public function getGalleryImage($parent){
		$sql = "SELECT ".TABLE_PREFIX."itinerary_gallery . * , ".TABLE_PREFIX."itineraries . *, ".TABLE_PREFIX."itinerary_info . *, ".TABLE_PREFIX."itinerary_video . *
				 FROM `".TABLE_PREFIX."itinerary_gallery`
 				 LEFT JOIN ".TABLE_PREFIX."itinerary_video ON ".TABLE_PREFIX."itinerary_gallery.gallery_parent = ".TABLE_PREFIX."itinerary_video.video_parent 
				 INNER JOIN ".TABLE_PREFIX."itineraries ON ".TABLE_PREFIX."itinerary_gallery.gallery_parent = ".TABLE_PREFIX."itineraries.trip_id 
				 LEFT JOIN ".TABLE_PREFIX."itinerary_info ON ".TABLE_PREFIX."itineraries.trip_id = ".TABLE_PREFIX."itinerary_info.info_parent
				 WHERE ".TABLE_PREFIX."itinerary_gallery.gallery_parent = :id";
		$sth = $this->db->prepare($sql);
		$sth->execute([":id"=>$parent]);
		return $sth->fetchAll();
	}
	public function getVideos($parent){
		$sql = "SELECT DISTINCT ".TABLE_PREFIX."itinerary_video . * , ".TABLE_PREFIX."itineraries . *, ".TABLE_PREFIX."itinerary_info . *, ".TABLE_PREFIX."itinerary_gallery . *
				FROM `".TABLE_PREFIX."itinerary_video`
				LEFT JOIN ".TABLE_PREFIX."itineraries ON ".TABLE_PREFIX."itinerary_video.video_parent = ".TABLE_PREFIX."itineraries.trip_id 
				LEFT JOIN ".TABLE_PREFIX."itinerary_info ON ".TABLE_PREFIX."itineraries.trip_id = ".TABLE_PREFIX."itinerary_info.info_parent 
				LEFT JOIN ".TABLE_PREFIX."itinerary_gallery ON ".TABLE_PREFIX."itinerary_info.info_parent = ".TABLE_PREFIX."itinerary_gallery.gallery_parent
				WHERE ".TABLE_PREFIX."itinerary_video.video_parent = :id";
		$sth = $this->db->prepare($sql);
		$sth->execute([":id"=>$parent]);
		return $sth->fetchAll();
	}
	//Function to fetch itinerary adjacencies
	public function getItineraries($parent) {
		$itineraries = [];
		$sql = "SELECT ".TABLE_PREFIX."navigations . *,".TABLE_PREFIX."itineraries . *,".TABLE_PREFIX."itinerary_info . *
				FROM ".TABLE_PREFIX."navigations
				RIGHT JOIN ".TABLE_PREFIX."itineraries ON ".TABLE_PREFIX."navigations.nav_id = ".TABLE_PREFIX."itineraries.trip_parent
				LEFT JOIN ".TABLE_PREFIX."itinerary_info ON ".TABLE_PREFIX."itineraries.trip_id = ".TABLE_PREFIX."itinerary_info.info_parent
				WHERE ".TABLE_PREFIX."navigations.nav_tpl = 'itinerary' LIMIT 6";
		$sth = $this->db->prepare($sql);
		$sth->execute([':parent'=>$parent]);
		foreach($sth->fetchAll() as $itinerary):
			$nav = $this->getRootNav($itinerary->nav_parent);
			if($nav->nav_id == $parent)$itineraries[] = $itinerary;
			else continue;
		endforeach;
			return($itineraries);
	}
	public function getCats(){
		$sql = "SELECT *
				FROM ".TABLE_PREFIX."itinerary_categories
				ORDER BY category_order
				LIMIT 3 ";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		return($sth->fetchAll());
	}
	public function getAllCategories(){
		$sql = "SELECT *
				FROM ".TABLE_PREFIX."itinerary_categories
				ORDER BY category_order
				";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		return($sth->fetchAll());
	}
	public function getCategory($id){
		$sql = "SELECT ".TABLE_PREFIX."itinerary_categories.*, ".TABLE_PREFIX."itineraries.*
				FROM ".TABLE_PREFIX."itinerary_categories
				LEFT JOIN ".TABLE_PREFIX."itineraries 
				ON ".TABLE_PREFIX."itinerary_categories.category_id = ".TABLE_PREFIX."itineraries.category_id
				WHERE ".TABLE_PREFIX."itinerary_categories.category_id = :id";
		$sth = $this->db->prepare($sql);
		$sth->execute([":id"=>$id]);
		return $sth->fetchAll();
	}

	public function getRootNav($id){
		static $navigation;
		$sql1 = "SELECT * FROM ".TABLE_PREFIX."navigations WHERE `nav_id` = :id";
		$sth = $this->db->prepare($sql1);
		$sth->execute([':id'=>$id]);
		$nav = $sth->fetch();
		if($nav->nav_parent == 0)
			{
			if(is_object($nav))
			$navigation = $nav;	
		}
		else
			$this->getRootNav($nav->nav_parent);
		return $navigation;
		}
	public function fetchWithParentNav($id){

		$sql = "SELECT ".TABLE_PREFIX."itineraries . * , ".TABLE_PREFIX."itinerary_info . *
				FROM ".TABLE_PREFIX."itineraries
				INNER JOIN ".TABLE_PREFIX."itinerary_info ON ".TABLE_PREFIX."itineraries.trip_id = ".TABLE_PREFIX."itinerary_info.info_parent
				WHERE ".TABLE_PREFIX."itineraries.trip_parent = :tParent
				ORDER BY ".TABLE_PREFIX."itineraries.trip_added
				";
		$sth = $this->db->prepare($sql);
		$sth->execute([':tParent'=>$id]);
		return $sth->fetch();
	}
	public function fetchItinerary($id){
		$sql = "SELECT ".TABLE_PREFIX."itineraries . * , ".TABLE_PREFIX."itinerary_info . *, ".TABLE_PREFIX."itinerary_review . * FROM ".TABLE_PREFIX."itineraries 
				INNER JOIN ".TABLE_PREFIX."itinerary_info 
				ON ".TABLE_PREFIX."itineraries.trip_id = ".TABLE_PREFIX."itinerary_info.info_parent 
				LEFT JOIN ".TABLE_PREFIX."itinerary_review 
				ON ".TABLE_PREFIX."itineraries.trip_id = ".TABLE_PREFIX."itinerary_review.review_parent 
				WHERE ".TABLE_PREFIX."itineraries.trip_id = :tId
				";
		$sth = $this->db->prepare($sql);
		$sth->execute([':tId'=>$id]);
		return $sth->fetchAll();
	}
	public function breadcrumb($parent,$first_call = true){
		static $breadarray = [];	
		static $breadcrumb;
		if($first_call)
			$breadcrumb .= "<div class = 'breadbrumb'><a href = '".SITE_URL."'>Home &#0187; </a>";
		else
			$breadcrumb .= "";	
		$sql = "SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_id` = :parent";
		$sth = $this->db->prepare($sql);
		$sth->execute([':parent'=>$parent]);
		$result = $sth->fetch();
		if($result->nav_parent != '0'){
			if($result->nav_tpl == "itinerary"){
			$list = "<a href = '".SITE_URL."/itineraries/show/".$result->nav_id."'>";
			$list .= $result->nav_title." &#0187; </a>";
			$breadarray[] = $list;
			}elseif($result->nav_tpl = "default"){
			$list = "<a href = '".SITE_URL."/index/page/".$result->nav_alias."'>";
			$list .= $result->nav_title."&#0187;</a>";
			$breadarray[] = $list;
			}
			$this->breadcrumb($result->nav_parent,false);
		}
		else {
			if($result->nav_tpl == "itinerary"){
			$list = "<a href = '".SITE_URL."/itineraries/show/".$result->nav_id."'>";
			$list .= $result->nav_title." &#0187; </a>";
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
	public function getDestinations(){
		static $destination = "";
		$sql = "SELECT * FROM `".TABLE_PREFIX."navigations` WHERE `nav_destination` = 1";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}
	public function bookItinerary(){
	
	$sql = "INSERT INTO `".TABLE_PREFIX."bookings` (
														`booking_trip_id`,
														`booking_trip_destination`,
														`booking_trip_holiday`,
														`booking_departure`,
														`booking_arrival`,
														`booking_nop`,
														`booking_intl_flights`,
														`booking_first_name`,
														`booking_last_name`,
														`booking_email`,
														`booking_phone`,
														`booking_address1`,
														`booking_address2`,
														`booking_city`,
														`booking_country`,
														`booking_zip`,
														`booking_price_type`,
														`booking_total`,
														`booking_payment_method`,
														`booking_ip`,
														`booking_added`
														) VALUES (
																	:id,
																	:destination,
																	:holiday,
																	:book_depart,
																	:book_arriv,
																	:book_nop,
																	:book_req_intl_flights,
																	:fname,
																	:lname,
																	:email,
																	:phone,
																	:address1,
																	:address2,
																	:city,
																	:country,
																	:zip,
																	:p_type,
																	:total,
																	:paymethod,
																	:ip,
																	:added
																	)";
	$sth = $this->db->prepare($sql);
	$data = [
		":id"=>$_POST["id"],
		":destination"=>$_POST["destination"],
		":holiday"=>$_POST["holiday"],
		":book_depart"=>strtotime($_POST["book_depart"]),
		":book_arriv"=>strtotime($_POST["book_arriv"]),
		":book_nop"=>$_POST["book_nop"],
		":book_req_intl_flights"=>$_POST["book_req_intl_flights"],
		":fname"=>$_POST["fname"],
		":lname"=>$_POST["lname"],
		":email"=>$_POST["email"],
		":phone"=>$_POST["phone"],
		":address1"=>$_POST["address1"],
		":address2"=>$_POST["address2"],
		":city"=>$_POST["city"],
		":country"=>$_POST["country"],
		":zip"=>$_POST["zip"],
		":p_type"=>isset($_POST["p-type"])?$_POST["p-type"]:" ",
		":total"=>isset($_POST["total"])?$_POST["total"]:" ",
		":paymethod"=>isset($_POST["payment"])?$_POST["payment"]:" ",
		":ip"=>"192.168.0.21",
		":added"=>DATETIME
		];
	$sth->execute($data);
	$count = $sth->rowCount();
	if($count == 1)://send email
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$fullname = $fname." ".$lname;
		$email = trim($_POST['email']);
		$to_email = SITE_EMAIL;
		$to_name = SITE_NAME;
		$subject = "Booking Form Submission";
		$body = "<p> $fullname booked a trip via ".SITE_URL."</p>
				 Name:  	$fullname<br/>
				 Email:		$email<br/>
				 Address: 	".$_POST['address1']." , ".$_POST['address2'].", ".$_POST['city'].", ".$_POST['country']."<br/>
				 Zip:		".$_POST['zip']."<br/>
				 Trip ID 	".$_POST['id']."<br/>

				 please see your site admin for more details.
				 with regards,<br/>
				 ".SITE_NAME." bot";
		$altbody = $body;
		require 'libraries/classes/external/PHPMailerAutoload.php';
		$mail = new PHPmailer();
		$mail->From = $email;
		$mail->FromName = $fullname;
		$mail->addAddress($to_email,$to_name);
		$mail->Subject    = $subject;
		$mail->isHTML(true);    
		$mail->Body    = $body;
		$mail->MsgHTML($body); 
		if(!$mail->send()){
			return "Email could not be sent!<br>Mailer Error: ".$mail->ErrorInfo;
		}
		else{
			return "Booking successfully completed";
		}
	else://return error
		return "Error! Try again later. We will fix this soon.";
	endif;
	}
public function planbook(){
	
	$sql = "INSERT INTO `".TABLE_PREFIX."planned_booking` (
														`plan_destination`,
														`plan_holiday_duration`,
														`plan_services`,
														`plan_name`,
														`plan_email`,
														`plan_telephone`,
														`plan_address1`,
														`plan_address2`,
														`plan_city`,
														`plan_zip`,
														`plan_country`,
														`plan_added`
														) VALUES (
																	:destination,
																	:holiday,
																	:services,
																	:name,
																	:email,
																	:phone,
																	:address1,
																	:address2,
																	:city,
																	:country,
																	:zip,
																	:added
																	)";
	$sth = $this->db->prepare($sql);
	$data = [
		":destination"=>$_POST["destination"],
		":holiday"=>serialize($_POST["holiday"])."---hol---".serialize($_POST['duration']),
		":services"=>$_POST["services"],
		":name"=>ucfirst($_POST["fname"])." ".ucfirst($_POST["lname"]),
		":email"=>$_POST["email"],
		":phone"=>$_POST["telephone"],
		":address1"=>$_POST["address1"],
		":address2"=>$_POST["address2"],
		":city"=>$_POST["city"],
		":country"=>$_POST["country"],
		":zip"=>$_POST["zipcode"],
		":added"=>DATETIME
		];
	$sth->execute($data);
	$count = $sth->rowCount();
	if($count == 1)://send email
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$fullname = $fname." ".$lname;
		$email = trim($_POST['email']);
		$to_email = SITE_EMAIL;
		$to_name = SITE_NAME;
		$subject = "Plan a Trip Form Submission";
		$body = "<p> $fullname booked a trip via ".SITE_URL."</p>
				 Name:  	$fullname<br/>
				 Email:		$email<br/>
				 Address: 	".$_POST['address1']." , ".$_POST['address2'].", ".$_POST['city'].", ".$_POST['country']."<br/>
				 Zip:		".$_POST['zipcode']."<br/>

				 please see your site admin for more details.
				 with regards,<br/>
				 ".SITE_NAME." bot";
		$altbody = $body;
		require 'libraries/classes/external/PHPMailerAutoload.php';
		$mail = new PHPmailer();
		$mail->From = $email;
		$mail->FromName = $fullname;
		$mail->addAddress($to_email,$to_name);
		$mail->Subject    = $subject;
		$mail->isHTML(true);    
		$mail->Body    = $body;
		$mail->MsgHTML($body); 
		if(!$mail->send()){
			return "Email could not be sent!<br>Mailer Error: ".$mail->ErrorInfo;
		}
		else{
			return "Form successfully completed";
		}
	else://return error
		return "Error! Try again later. We will fix this soon.";
	endif;
	}
	public function saveReviewForm(){
		$extensions = array("jpg","jpeg","png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if (($_FILES["file"]["size"] < 20000)&& in_array($extension, $extensions))
		  {
		  if ($_FILES["file"]["error"] > 0)
		    {
		    $errors[] = "Error: " . $_FILES["file"]["error"] . "<br>";
		    }
		  else
		    {
		    if (file_exists("uploads/reviews/" . $_FILES["file"]["name"]))
			      {
			      $errors[] = $_FILES["file"]["name"] . " already exists.";
			      }
			else
			      {
			      $uploadpath = "uploads/reviews/review_".DATETIME.$_FILES["file"]["name"];
			      move_uploaded_file($_FILES["file"]["tmp_name"],$uploadpath);
			     //update database;
			        $sql = "INSERT INTO `".TABLE_PREFIX."itinerary_review` (
														`review_parent`,
														`review_title`,
														`review_experience`,
														`review_name`,
														`review_image`,
														`review_address`,
														`review_email`,
														`review_company`,
														`review_designation`,
														`review_website`,
														`review_status`,
														`review_added`
														) VALUES (
																	:pid,
																	:title,
																	:experience,
																	:name,
																	:image,
																	:address,
																	:email,
																	:company,
																	:designation,
																	:website,
																	:status,
																	:added
																	)";
					$data = [
							":pid"=>$_POST["id"],
							":title"=>$_POST["title"],
							":experience"=>$_POST["testimonial"],
							":name"=>$_POST["name"],
							":image"=>SITE_URL."/".$uploadpath,
							":address"=>$_POST["address"],
							":email"=>$_POST["email"],
							":company"=>$_POST["company"] ,
							":designation"=>$_POST["designation"],
							":website"=>$_POST["url"],
							":status"=>0,
							":added"=>DATETIME
							];

					$sth = $this->db->prepare($sql);
					$sth->execute($data);
					if($sth->rowCount()==1)return 1;
		        }
		    }
		  }
		else
		{
		  $errors[] = "Invalid File! Only pdf, doc and docx type are accepted.";
		}

	} 
}