<?php
	/**
	 * class Itinerary_Model
	 * handles gallery modules
	 *
	 * @package admin-login
	 * @date 20th Jun 2014
	 */
	 
	class Itineraries_Model extends Model{
		public $errors = [];
		public function __construct() {        
	        parent::__construct();            
	    }
	    public function getBookings(){
			$sql = "SELECT * FROM `".TABLE_PREFIX."bookings`";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		public function getPlans(){
			$sql = "SELECT * FROM `".TABLE_PREFIX."planned_booking`";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		public function getBooking($id){
			$sql = "SELECT * FROM `".TABLE_PREFIX."bookings` WHERE `booking_id` = :id";
			$sth = $this->db->prepare($sql);
			$sth->execute([":id"=>$id]);
			return $sth->fetch();
		}
		public function getPlan($id){
			$sql = "SELECT * FROM `".TABLE_PREFIX."planned_booking` WHERE `plan_id` = :id";
			$sth = $this->db->prepare($sql);
			$sth->execute([":id"=>$id]);
			return $sth->fetch();
		}

	    public function saveItinerary(){
	    	if($_POST["form"] == 1):
	    	$sql = "INSERT INTO `".TABLE_PREFIX."itineraries` (  `trip_title`,
	    														  `category_id`,
																  `trip_alias`,
																  `trip_parent`,
																  `trip_feature`,
																  `trip_price_type`,
																  `trip_price`,
																  `trip_sd_price`,
																  `trip_d_price`,
																  `trip_ss_price`,
																  `trip_image`,
																  `trip_map`,
																  `trip_file`,
																  `trip_status`,
																  `trip_added`,
																  `trip_overview`,
																  `trip_outline`,
																  `trip_day2day`,
																  `trip_notes`
																  ) VALUES (:tripTitle,
																  			:categoryId,
																			:tripAlias,
																			:tripParent,
																			:tripFeature,
																			:tripPriceType,
																			:tripPrice,
																			:tripSDPrice,
																			:tripDPrice,
																			:tripSSPrice,
																			:tripImage,
																			:tripMap,
																			:tripFile,
																			:tripStatus,
																			:tripDate,
																			:tripOverview,
																			:tripOutline,
																			:tripDay2day,
																			:tripNotes)";

		$data = [":tripTitle"=>$_POST["trip_title"],
				":categoryId"=>$_POST["category_id"],
				 ":tripAlias"=>$_POST["trip_alias"],
				 ":tripParent"=>$_POST["trip_parent"],
				 ":tripFeature"=>$_POST["trip_feature"],
				 ":tripPriceType"=>$_POST["trip_price_type"],
				 ":tripPrice"=>$_POST["trip_price_dlx"]."/".$_POST["trip_price_sdlx"]."/".$_POST["trip_price_ss"],
				 ":tripSDPrice"=>$_POST["trip_sd_price_tent"]."/".$_POST["trip_sd_price_tea"],
				 ":tripDPrice"=>$_POST["trip_d_price_tent"]."/".$_POST["trip_d_price_tea"],
				 ":tripSSPrice"=>$_POST["trip_ss_price_tent"]."/".$_POST["trip_ss_price_tea"],
				 ":tripImage"=>$_POST["trip_image"],
				 ":tripMap"=>$_POST["trip_map"],
				 ":tripFile"=>$_POST["trip_file"],
				 ":tripStatus"=>$_POST["trip_status"],
				 ":tripDate"=>DATETIME,
				 ":tripOverview"=>$_POST["trip_overview"],
				 ":tripOutline"=>$_POST["trip_outline"],
				 ":tripDay2day"=>$_POST["trip_day2day"],
				 ":tripNotes"=>$_POST["trip_notes"]
				 ];
	    

	    
		$sth = $this->db->prepare($sql);
		$execute = $sth->execute($data);
		$count = $sth->rowCount();
		if($count == 1): return 1;
		else: $this->errors[] = "Sorry, your request could not be processed";
		endif;
		if(count($this->errors)>1): return false;endif;
	else:
		$sql = "UPDATE `".TABLE_PREFIX."itineraries` SET 	  `trip_title` 		= 	:tripTitle , 
															  `category_id` 	= 	:categoryId , 
															  `trip_alias` 		= 	:tripAlias , 
															  `trip_parent` 	= 	:tripParent , 
															  `trip_feature`	= 	:tripFeature , 
															  `trip_price_type` = 	:tripPriceType , 
															  `trip_price` 		= 	:tripPrice , 
															  `trip_sd_price` 	= 	:tripSDPrice , 
															  `trip_d_price` 	= 	:tripDPrice , 
															  `trip_ss_price` 	= 	:tripSSPrice , 
															  `trip_image` 		= 	:tripImage , 
															  `trip_map` 		= 	:tripMap , 
															  `trip_file` 		= 	:tripFile , 
															  `trip_status` 	= 	:tripStatus , 
															  `trip_added` 		= 	:tripDate , 
															  `trip_overview` 	= 	:tripOverview , 
															  `trip_outline` 	= 	:tripOutline , 
															  `trip_day2day` 	= 	:tripDay2day , 
															  `trip_notes` 		= 	:tripNotes 		WHERE `trip_id` = :tripID ";
	// echo $sql;															  
			$data = [":tripTitle"=>$_POST["trip_title"],
				 ":categoryId"=>$_POST["category_id"],
				 ":tripAlias"=>$_POST["trip_alias"],
				 ":tripParent"=>$_POST["trip_parent"],
				 ":tripFeature"=>$_POST["trip_feature"],
				 ":tripPriceType"=>$_POST["trip_price_type"],
				 ":tripPrice"=>$_POST["trip_price_dlx"]."/".$_POST["trip_price_sdlx"]."/".$_POST["trip_price_ss"],
				 ":tripSDPrice"=>$_POST["trip_sd_price_tent"]."/".$_POST["trip_sd_price_tea"],
				 ":tripDPrice"=>$_POST["trip_d_price_tent"]."/".$_POST["trip_d_price_tea"],
				 ":tripSSPrice"=>$_POST["trip_ss_price_tent"]."/".$_POST["trip_ss_price_tea"],
				 ":tripImage"=>$_POST["trip_image"],
				 ":tripMap"=>$_POST["trip_map"],
				 ":tripFile"=>$_POST["trip_file"],
				 ":tripStatus"=>$_POST["trip_status"],
				 ":tripDate"=>DATETIME,
				 ":tripOverview"=>$_POST["trip_overview"],
				 ":tripOutline"=>$_POST["trip_outline"],
				 ":tripDay2day"=>$_POST["trip_day2day"],
				 ":tripNotes"=>$_POST["trip_notes"],
				 ":tripID"=>$_POST["trip_id"]
				 ];
		$sth = $this->db->prepare($sql);
		$execute = $sth->execute($data);
		$count = $sth->rowCount();
		if($count == 1): return 1;
		else: $this->errors[] = "Sorry, your request could not be processed";
		endif;
		if(count($this->errors)>1): return false;endif;	 									  
																			
	endif;
	}
	public function saveItineraryInfo(){
		$form = $_POST['form'];
		if($form == 1):

			$sql = "INSERT INTO `".TABLE_PREFIX."itinerary_info` (
																  `info_code`, 
																  `info_supplement`, 
																  `info_grade`, 
																  `info_activities`, 
																  `info_groupsize`, 
																  `info_dlywlknghr`, 
																  `info_tour_duration`, 
																  `info_trek_duration`, 
																  `info_seasons`, 
																  `info_style`, 
																  `info_accommodation`, 
																  `info_transportation`, 
																  `info_flight_charge`,
																  `info_meals`, 
																  `info_high_alt`, 
																  `info_starts_from`, 
																  `info_end_at`,
																  `info_added`, 
																  `info_parent`
																  ) VALUES (:infoCode,
																			:infoSupplement,
																			:infoGrade,
																			:infoActivities,
																			:infoGroupsize,
																			:infoDlywlknghr,
																			:infoTour_duration,
																			:infoTrek_duration,
																			:infoSeasons,
																			:infoStyle,
																			:infoAccommodation,
																			:infoTransportation,
																			:infoFlight_charge,
																			:infoMeals,
																			:infoHigh_alt,
																			:infoStarts_from,
																			:infoEnd_at,
																			:infoAdded,
																			:infoParent
																			)";	
			$data = [
				':infoCode'=>$_POST['info_code'],
				':infoSupplement'=>$_POST['info_supplement'],
				':infoGrade'=>$_POST['info_grade'],
				':infoActivities'=>$_POST['info_activities'],
				':infoGroupsize'=>$_POST['info_groupsize'],
				':infoDlywlknghr'=>$_POST['info_dlywlknghr'],
				':infoTour_duration'=>$_POST['tour_duration_nights']."/".$_POST['tour_duration_days'],
				':infoTrek_duration'=>$_POST['trek_duration_nights']."/".$_POST['trek_duration_days'],
				':infoSeasons'=>serialize($_POST['info_seasons']),
				':infoStyle'=>$_POST['info_style'],
				':infoAccommodation'=>$_POST['info_accommodation'],
				':infoTransportation'=>$_POST['info_transportation'],
				':infoFlight_charge'=>$_POST['info_flight_charge'],
				':infoMeals'=>$_POST['info_meals'],
				':infoHigh_alt'=>$_POST['info_high_alt']." ".$_POST["alt_unit"],
				':infoStarts_from'=>$_POST['info_starts_from'],
				':infoEnd_at'=>$_POST['info_end_at'],
				':infoAdded'=>DATETIME,
				':infoParent'=>$_POST['info_parent']
				];
			$sth = $this->db->prepare($sql);
			$execute = $sth->execute($data);
			$count = $sth->rowCount();
			if($count == 1): return 1;
			else: $this->errors[] = "Sorry, your request could not be processed";
			endif;
			if(count($this->errors)>1): return false;endif;	 									  
		elseif($form == 0):
			$sql = "UPDATE `".TABLE_PREFIX."itinerary_info` SET  
														`info_code` 			= 	:infoCode,
														`info_supplement` 		= 	:infoSupplement,
														`info_grade` 			= 	:infoGrade,
														`info_activities` 		= 	:infoActivities,
														`info_groupsize` 		= 	:infoGroupsize,
														`info_dlywlknghr` 		= 	:infoDlywlknghr,
														`info_tour_duration` 	= 	:infoTour_duration,
														`info_trek_duration` 	= 	:infoTrek_duration,
														`info_seasons` 			= 	:infoSeasons,
														`info_style` 			= 	:infoStyle,
														`info_accommodation` 	= 	:infoAccommodation,
														`info_transportation` 	=   :infoTransportation,
														`info_flight_charge` 	= 	:infoFlight_charge,
														`info_meals` 			= 	:infoMeals,
														`info_high_alt` 		= 	:infoHigh_alt,
														`info_starts_from` 		= 	:infoStarts_from,
														`info_end_at` 			= 	:infoEnd_at,
														`info_added` 			= 	:infoAdded
															  WHERE `info_parent` = :infoParent ";
			$data = [
				':infoCode'				=> 		$_POST['info_code'],
				':infoSupplement'		=> 		$_POST['info_supplement'],
				':infoGrade'			=> 		$_POST['info_grade'],
				':infoActivities'		=> 		$_POST['info_activities'],
				':infoGroupsize'		=> 		$_POST['info_groupsize'],
				':infoDlywlknghr'		=> 		$_POST['info_dlywlknghr'],
				':infoTour_duration'	=> 		$_POST['tour_duration_nights']."/".$_POST['tour_duration_days'],
				':infoTrek_duration'	=> 		$_POST['trek_duration_nights']."/".$_POST['trek_duration_days'],
				':infoSeasons'			=> 		serialize($_POST['info_seasons']),
				':infoStyle'			=> 		$_POST['info_style'],
				':infoAccommodation'	=> 		$_POST['info_accommodation'],
				':infoTransportation'	=> 		$_POST['info_transportation'],
				':infoFlight_charge'	=> 		$_POST['info_flight_charge'],
				':infoMeals'			=> 		$_POST['info_meals'],
				':infoHigh_alt'			=> 		$_POST['info_high_alt']." ".$_POST["alt_unit"],
				':infoStarts_from'		=> 		$_POST['info_starts_from'],
				':infoEnd_at'			=> 		$_POST['info_end_at'],
				':infoAdded'			=> 		DATETIME,
				':infoParent'			=> 		$_POST['info_parent']
				];

			$sth = $this->db->prepare($sql);
			$execute = $sth->execute($data);
			$count = $sth->rowCount();
			if($count == 1): return 1;
			else: $this->errors[] = "Sorry, your request could not be processed";
			endif;
			if(count($this->errors)>1): return false;endif;	 									  
		

		endif;
	}
	public function saveItineraryCost(){
		// dd($_POST);
		$form = $_POST['form'];
		
		if($form == 1):

		foreach($_POST as $key=>$value)
		$$key = $value;

		$count = count($cost_ss);
		// dd($count);
		for($i = 0; $i<$count; $i++):
				if(!empty($cost_code[$i]) && !empty($cost_starts[$i]) && !empty($cost_ends[$i]) ):
				$sql = "INSERT INTO `".TABLE_PREFIX."itinerary_cost` (  
																	`cost_parent`,
																	`cost_code`,
																	`cost_starts`,
																	`cost_ends`,
																	`cost_d`,
																	`cost_d_availability`,
																	`cost_ss`,
																	`cost_ss_availability`,
																	`cost_sd`,
																	`cost_sd_availability`,
																	`cost_added`
																	) VALUES (
																			:costParent,
																			:costCode,
																			:costStarts,
																			:costEnds,
																			:costD,
																			:costD_availability,
																			:costSs,
																			:costSs_availability,
																			:costSd,
																			:costSd_availability,
																			:costAdded
																			)";	
				$data = [
					':costParent'=>$trip_id,
					':costCode'=>$cost_code[$i],
					':costStarts'=>strtotime($cost_starts[$i]),
					':costEnds'=>strtotime($cost_ends[$i]),
					':costD'=>$cost_d[$i],
					':costD_availability'=>$cost_d_avai[$i],
					':costSs'=>$cost_ss[$i],
					':costSs_availability'=>$cost_ss_avai[$i],
					':costSd'=>$cost_sd[$i],
					':costSd_availability'=>$cost_sd_avai[$i],
					':costAdded'=> DATETIME
					];
				$sth = $this->db->prepare($sql);
				$execute = $sth->execute($data);
				endif;
		endfor;
				$sql1 = "UPDATE `".TABLE_PREFIX."itineraries` SET		`trip_pr_includes` = :tripPr_includes, 
																		`trip_pr_n_includes` = :tripPr_n_includes, 
																		`trip_information` = :tripInformation 
																				 WHERE `trip_id` = :tripId";	
				// echo $sql1;exit;
				$data = [
				':tripPr_includes' => $trip_pr_includes, 
				':tripPr_n_includes' => $trip_pr_n_includes, 
				':tripInformation' => $trip_information ,
				':tripId'=> $trip_id
				];
				$sth1 = $this->db->prepare($sql1);
				$execute = $sth1->execute($data);
				$count1 = $sth1->rowCount();
			if($count1 == 1): return 1;
			else: $this->errors[] = "Sorry, your request could not be processed";
			endif;
			if(count($this->errors)>1): return false;endif;	 


		elseif($form == 0):
			foreach($_POST as $key=>$value)
		$$key = $value;

		$count = count($cost_ss);
		// dd($count);
		for($i = 0; $i<$count; $i++):
				if(!empty($cost_code[$i]) && !empty($cost_starts[$i]) && !empty($cost_ends[$i]) ):
				$sql = "INSERT INTO `".TABLE_PREFIX."itinerary_cost` (  
																	`cost_parent`,
																	`cost_code`,
																	`cost_starts`,
																	`cost_ends`,
																	`cost_d`,
																	`cost_d_availability`,
																	`cost_ss`,
																	`cost_ss_availability`,
																	`cost_sd`,
																	`cost_sd_availability`,
																	`cost_added`
																	) VALUES (
																			:costParent,
																			:costCode,
																			:costStarts,
																			:costEnds,
																			:costD,
																			:costD_availability,
																			:costSs,
																			:costSs_availability,
																			:costSd,
																			:costSd_availability,
																			:costAdded
																			)";	
				$data = [
					':costParent'=>$trip_id,
					':costCode'=>$cost_code[$i],
					':costStarts'=>strtotime($cost_starts[$i]),
					':costEnds'=>strtotime($cost_ends[$i]),
					':costD'=>$cost_d[$i],
					':costD_availability'=>$cost_d_avai[$i],
					':costSs'=>$cost_ss[$i],
					':costSs_availability'=>$cost_ss_avai[$i],
					':costSd'=>$cost_sd[$i],
					':costSd_availability'=>$cost_sd_avai[$i],
					':costAdded'=> DATETIME
					];
				$sth = $this->db->prepare($sql);
				$execute = $sth->execute($data);
				endif;
		endfor;
				$sql1 = "UPDATE `".TABLE_PREFIX."itineraries` SET		`trip_pr_includes` = :tripPr_includes, 
																		`trip_pr_n_includes` = :tripPr_n_includes, 
																		`trip_information` = :tripInformation 
																				 WHERE `trip_id` = :tripId";	
				// echo $sql1;exit;
				$data = [
				':tripPr_includes' => $trip_pr_includes, 
				':tripPr_n_includes' => $trip_pr_n_includes, 
				':tripInformation' => $trip_information ,
				':tripId'=> $trip_id
				];
				$sth1 = $this->db->prepare($sql1);
				$execute = $sth1->execute($data);
				$count1 = $sth1->rowCount();
			if($count1 == 1): return 1;
			else: $this->errors[] = "Sorry, your request could not be processed";
			endif;
			if(count($this->errors)>1): return false;endif;	 
			foreach($_POST as $key=>$value)
				$$key = $value;
			$sql = "UPDATE `".TABLE_PREFIX."itinerary_cost` SET					
																				`cost_code`				= :costCode ,
																				`cost_starts` 			= :costStarts ,
																				`cost_ends` 			= :costEnds ,
																				`cost_d` 				= :costD ,
																				`cost_d_availability` 	= :costD_availability ,
																				`cost_ss` 				= :costSs ,
																				`cost_ss_availability` 	= :costSs_availability ,
																				`cost_sd` 				= :costSd ,
																				`cost_sd_availability` 	= :costSd_availability ,
																				`cost_updated` 			= :costUpdated
																						WHERE `cost_id` = :costId";	
							$data = [
								':costId'=>$_POST["cost_id"],
								':costCode'=>$cost_code,
								':costStarts'=>strtotime($cost_starts),
								':costEnds'=>strtotime($cost_ends),
								':costD'=>$cost_d,
								':costD_availability'=>$cost_d_availability,
								':costSs'=>$cost_ss,
								':costSs_availability'=>$cost_ss_availability,
								':costSd'=>$cost_sd,
								':costSd_availability'=>$cost_sd_availability,
								':costUpdated'=> DATETIME
								];
							// echo "inserting";
							$sth = $this->db->prepare($sql);
							$execute = $sth->execute($data);			$count = 0;
						if($count == 1): return 1;
						else: $this->errors[] = "Sorry, your request could not be processed";
						endif;
						if(count($this->errors)>1): return false;endif;	 									  

		endif;
	}
	public function get_all_count() {
		$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itineraries`");
        $sth->execute();
		return $sth->rowCount();
	}
	public function getAllItineraries( $limit){
		$sth = $this->db->prepare("SELECT `trip_id`, `trip_title`, `trip_parent`, `trip_feature`, FROM_UNIXTIME(trip_added, '%a, %D %b %Y. %h:%i %p') as `added` FROM `".TABLE_PREFIX."itineraries` ORDER BY `trip_added` DESC ".$limit."");				
		$sth->execute();
        return $sth->fetchAll();
	}
	public function getItineraryInfo($id){
		$sth  = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_info` WHERE `info_parent` = '".$id."'");
		$sth->execute();
		return $sth->fetch();
	}

	public function getItineraryDetails($id){
		$sth  = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itineraries` WHERE `trip_id` = '".$id."'");
		$sth->execute();
		return $sth->fetch();
	}
	public function deleteItinerary($id){

		$sth = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."itineraries` WHERE `trip_id` = :id;");
		$sth->execute([":id"=>$id]);
		if($sth->rowCount() == 1): 
		$sth1 = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."itinerary_info` WHERE `info_parent` = :id;");
		$sth1->execute([":id"=>$id]);
		$sth2 = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."itinerary_cost` WHERE `cost_parent` = :id;");
		$sth2->execute([":id"=>$id]);
		$sth2 = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."navigations` WHERE `nav_id` = :nid;");
		$sth2->execute([":nid"=>$id]);
		else: 
			$this->errors[] = "Sorry, your request could not be processed";
			return false;
		endif;
	}
	public function deleteBooking($id){
		$sth = $this->db->prepare("DELETE FROM `".TABLE_PREFIX."bookings` WHERE `booking_id` = :id;");
		$sth->execute([":id"=>$id]);
		if($sth->rowCount() == 1): return 1;
		else: 
			$this->errors[] = "Sorry, your request could not be processed";
			return false;
		endif;
	}			
	public function checkInfo($id){
		$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_info` WHERE `info_parent` = '".$id."'");
		$sth->execute([":id"=>$id]);
		if($sth->rowCount() == 1):return 1;
		else: return 0;
		endif;
	}
	public function checkCost($id){
		$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_cost` WHERE `cost_parent` = '".$id."'");
		$sth->execute([":id"=>$id]);
		if($sth->rowCount() > 0):return 1;
		else: return 0;
		endif;
	}
	public function checkReview($id){
		$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_review` WHERE `review_parent` = '".$id."'");
		$sth->execute([":id"=>$id]);
		if($sth->rowCount() > 0):return 1;
		else: return 0;
		endif;
	}
	public function checkGallery($id){
		$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_gallery` WHERE `gallery_parent` = '".$id."'");
		$sth->execute([":id"=>$id]);
		if($sth->rowCount() > 1):return 1;
		else: return 0;
		endif;
	}
	public function checkVideo($id){
		$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_video` WHERE `video_parent` = '".$id."'");
		$sth->execute([":id"=>$id]);
		if($sth->rowCount() > 0):return 1;
		else: return 0;
		endif;
	}
	public function getItineraryGallery($id){
		$sth  = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_gallery` WHERE `gallery_parent` = '".$id."'");
		$sth->execute();
		return $sth->fetchAll();
	}
	public function getItineraryVideo($id){
		$sth  = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_video` WHERE `video_parent` = '".$id."'");
		$sth->execute();
		return $sth->fetchAll();
	}
	public function getItineraryCost($id){
		$sth  = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_cost` WHERE `cost_parent` = '".$id."'");
		$sth->execute();
		return $sth->fetchAll();
	}
	public function getItineraryCostInc($id){
		$sth  = $this->db->prepare("SELECT `trip_pr_includes`, `trip_pr_n_includes`, `trip_information` FROM `".TABLE_PREFIX."itineraries` WHERE `trip_id` = '".$id."'");
		$sth->execute();
		return $sth->fetch();
	}
	public function saveItineraryGallery(){
		// dd($_POST["gallery_image"][0]);
    	$count = count($_POST["gallery_titles"]);
	    	for($i = 0; $i<$count; $i++):
		    	$sql = "INSERT INTO `".TABLE_PREFIX."itinerary_gallery`( 
																	  `gallery_parent`,
																	  `gallery_path`,
																	  `gallery_caption`,
																	  `gallery_added`
																	  ) VALUES (:galleryParent,
																				:galleryPath,
																				:galleryCaption,
																				:galleryAdded)";
				// echo $sql;
				$data = [":galleryParent"=>$_POST["gallery_parent"],
						 ":galleryPath"=>$_POST["gallery_image"][$i],
						 ":galleryCaption"=>$_POST["gallery_titles"][$i],
						 ":galleryAdded"=>DATETIME
						 ];
			    
			    
				$sth = $this->db->prepare($sql);
				$execute = $sth->execute($data);
				$countrows = $sth->rowCount();
			endfor;
		return 1;
	}

	public function updateCaption(){
		$sql = "UPDATE `".TABLE_PREFIX."itinerary_gallery` SET `gallery_caption`= :caption WHERE `gallery_id` = :galleryId";
		$sth = $this->db->prepare($sql);
		$sth->execute([":caption"=>$_POST["value"],":galleryId"=>$_POST["pk"]]);
		return $sth->rowCount();																				
	}
	public function deleteImage(){
		$sql = "DELETE FROM `".TABLE_PREFIX."itinerary_gallery` WHERE `gallery_id` = :galleryId";
		$sth = $this->db->prepare($sql);
		$sth->execute([":galleryId"=>$_POST["pk"]]);
		return $sth->rowCount();																				
	}
	public function saveItineraryVideo(){
    	$count = count($_POST["video_titles"]);
	    	for($i = 0; $i<$count; $i++):
		    	$sql = "INSERT INTO `".TABLE_PREFIX."itinerary_video`(`video_parent`,
																	  `video_path`,
																	  `video_image`,
																	  `video_title`,
																	  `video_added`
																	  ) VALUES (:videoParent,
																				:videoPath,
																				:videoImage,
																				:videoTitle,
																				:videoAdded)";
				// echo $sql;
				$data = [":videoParent"=>$_POST["video_parent"],
						 ":videoPath"=>$_POST["video_path"][$i],
						 ":videoImage"=>$_POST["video_image"][$i],
						 ":videoTitle"=>$_POST["video_titles"][$i],
						 ":videoAdded"=>DATETIME
						 ];
				$sth = $this->db->prepare($sql);
				$execute = $sth->execute($data);
				$countrows = $sth->rowCount();
			endfor;
		return 1;
	}
	public function updateVCaption(){
		$sql = "UPDATE `".TABLE_PREFIX."itinerary_video` SET `video_title`= :caption WHERE `video_id` = :videoId";
		$sth = $this->db->prepare($sql);
		$sth->execute([":caption"=>$_POST["value"],":videoId"=>$_POST["pk"]]);
		return $sth->rowCount();																				
	}
	public function deleteVideo(){
		$sql = "DELETE FROM `".TABLE_PREFIX."itinerary_video` WHERE `video_id` = :videoId";
		$sth = $this->db->prepare($sql);
		$sth->execute([":videoId"=>$_POST["pk"]]);
		return $sth->rowCount();																				
	}
	public function getallreviews($id){
		$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_review` WHERE `review_parent` = '".$id."'");
		$sth->execute([":id"=>$id]);
		return $sth->fetchAll();
	}
	public function getreview($id){
		$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_review` WHERE `review_id` = :id");
		$sth->execute([":id"=>$id]);
		return $sth->fetch();
	}
	public function saveReview(){
		 $sql = "UPDATE `".TABLE_PREFIX."itinerary_review` SET 
														`review_title` = :title,
														`review_experience` = :experience,
														`review_name` = :name,
														`review_image` = :image,
														`review_address` = :address,
														`review_email` = :email,
														`review_company` = :company,
														`review_designation` = :designation,
														`review_website` = :website,
														`review_status` = :status,
														`review_added` = :added 
														WHERE `review_id` = :id";

					$data = [
							":id"=>$_POST["review_id"],
							":title"=>$_POST["review_title"],
							":experience"=>$_POST["review_experience"],
							":name"=>$_POST["review_name"],
							":image"=>$_POST["review_image"],
							":address"=>$_POST["review_address"],
							":email"=>$_POST["review_email"],
							":company"=>$_POST["review_company"] ,
							":designation"=>$_POST["review_designation"],
							":website"=>$_POST["review_website"],
							":status"=>$_POST["review_status"],
							":added"=>DATETIME
							];

					$sth = $this->db->prepare($sql);
					$sth->execute($data);
					if($sth->rowCount()==1)return 1;
	}
	public function confirmDelete($id){
		$sql = "DELETE FROM `".TABLE_PREFIX."itinerary_review` WHERE `review_id` = :id";
		$sth = $this->db->prepare($sql);
		$sth->execute([":id"=>$id]);
		if($sth->rowCount()==1)return true;
	}
	//category model
	public function saveCategory(){
		if($_POST['newform']==1){
		$sql = "INSERT INTO `".TABLE_PREFIX."itinerary_categories` (
																	`category_title`,
																	`category_alt_title`,
																	`category_overview`,
																	`category_image`
																	) VALUES (
																				:catTitle,
																				:catAltTitle,
																				:catOverview,
																				:catImage
																				)";
		$sth = $this->db->prepare($sql);
		$sth->execute([ ':catTitle'=>$_POST['category_title'],
						':catAltTitle'=>$_POST['category_alt_title'],
						':catOverview'=>$_POST['category_overview'],
						':catImage'=>$_POST['category_image']
						]);
			if($sth->rowCount()==1)
				return true;
			else{
				$this->errors = "Category could not be saved";
				return false;
			}
		}
		elseif($_POST['newform']==0){
			$sql = "UPDATE ".TABLE_PREFIX."itinerary_categories SET
																	`category_title` = :catTitle,
																	`category_alt_title` = :catAltTitle,
																	`category_overview` = :catOverview,
																	`category_image` = :catImage
																	WHERE `category_id` = :catId";

			$sth = $this->db->prepare($sql);
			$sth->execute([ ':catTitle'=>$_POST['category_title'],
						':catAltTitle'=>$_POST['category_alt_title'],
						':catOverview'=>$_POST['category_overview'],
						':catImage'=>$_POST['category_image'],
						':catId'=>$_POST['catid']
						]);
			// dd($sth->rowCount());
			if($sth->rowCount()==1)
				return true;
			else{
				return true;
			}														
		}
	}

	public function allCats(){
		$sql = "SELECT * FROM ".TABLE_PREFIX."itinerary_categories";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		return($sth->fetchAll());
	}
	public function getCat($id){
		$sql = "SELECT * FROM ".TABLE_PREFIX."itinerary_categories WHERE category_id = :id";
		$sth = $this->db->prepare($sql);
		$sth->execute([':id'=>$id]);
		return $sth->fetch();
	}
	public function getAllCatsOrder($id = NULL, $level = 0, $first_call = true) {
			$this->catList .=  $first_call == true ? '<ol id="sortableCats" class = "sortable">' : '<ol>';
			$call = $first_call == true ? false : false;
			$id = isset($id) ? $id : 0;
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."itinerary_categories` ORDER BY `category_order` ASC;");
			
			$sth->execute();
			$objectMenu = $sth->fetchAll();
			foreach($objectMenu as $tbl_field => $tbl_value) :
				$catid = $tbl_value->category_id;
				$catTitle = stripslashes($tbl_value->category_title);
				$catorder = $tbl_value->category_order;
				$this->catList .= '<li id="list_'.$catid.'"><div><span class="disclose"><span></span></span>'.$catTitle.'</div>';
				$this->catList .= '</li>';
			endforeach;
			$this->catList .=  '</ol>';
			return $this->catList;			
	}
	public function updateAllCatsOrder(){
		//print_r($_POST);
		$list = $_POST['list'];
		// an array to keep the sort order for each level based on the parent id as the key
	    $sort = array();
		foreach ($list as $id => $parentId):
			/* a null value is set for parent id by nested sortable for root level elements
           		so you set it to 0 to work in your case (from what I could deduct from your code) */
		    $parentId = ($parentId === 'null') ? 0 : $parentId;
			// init the sort order value to 1 if this element is on a new level
    		if (!array_key_exists($parentId, $sort))
        		$sort[$parentId] = 1;
    	
			//echo $sort[$parentId].' &raquo; '.$parentId.' &raquo; '.$id.'<br />';
			$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."itinerary_categories` SET 
										`category_order` = '".$sort[$parentId]."'
									    WHERE `category_id` = '".$id."'");
			$sth->execute();
    		// increment the sort order for this level
	        $sort[$parentId]++;
		endforeach;
	}
	public function deleteCat($id){
		$sth = $this->db->prepare("DELETE FROM ".TABLE_PREFIX."itinerary_categories WHERE category_id = :id");
		$sth->execute([':id'=>$id]);
		if($sth->rowCount()===1)return true;
		else{
			$this->errors = "Could not be deleted";
			return true;
		}
	}
};
								  
																			