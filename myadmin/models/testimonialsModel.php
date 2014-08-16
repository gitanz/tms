<?php 
Class Testimonials_Model extends Model{
	public $errors = [];
	public function __construct(){
		parent::__construct();
	}
	
	public function getAllTestimonials( $limit, $parent = false  ){
		
				$sth = $this->db->prepare("SELECT `testimonial_id`,`testimonial_title`, `testimonial_alias`,`testimonial_unseen`, FROM_UNIXTIME(testimonial_added, '%a, %D %b %Y. %h:%i %p') as `added` FROM `".TABLE_PREFIX."testimonials` ORDER BY `testimonial_added` DESC ".$limit."");				
				$sth->execute();
            return $sth->fetchAll();
		}
	public function get_all_count() {
		$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."testimonials`");
        $sth->execute();
		return $sth->rowCount();
	}
	public function saveFormData($postarray){
		foreach($postarray as $key=>$value):
			$$key = $value;
		endforeach;
		if(empty($testimonial_title)):
			$this->errors[] = "testimonial Title field is required";
		else:
			if($form):
				//insert new row
				$sql = "INSERT INTO `".TABLE_PREFIX."testimonials`(`testimonial_title`,
																	`testimonial_address`,
																	`testimonial_alias`,
																`testimonial_image`,
																`testimonial_status`,
																`testimonial_added`,
																`testimonial_unseen`,
																`testimonial_content`) VALUES(  :testimonialTitle,
																								:testimonialAlias,
																								:testimonialAddress,
																								:testimonialImage,
																								:testimonialStatus,
																								:testimonialAdded,
																								:testimonialUnseen,
																								:testimonialContent);";
				
					
				$alias = empty($testimonial_alias)? $this->create_alias($testimonial_title) : $this->create_alias($testimonial_alias);	
				$data = array(
					':testimonialTitle' => $testimonial_title,
					':testimonialAddress' => $testimonial_address,
					':testimonialAlias' => $alias,
					':testimonialImage' => $testimonial_image,
					':testimonialStatus' => $testimonial_status,
					':testimonialAdded' => DATETIME,
					':testimonialUnseen' => '0',
					':testimonialContent' => $testimonial_content, 
					);
				$sth = $this->db->prepare( $sql );
				$execute = $sth->execute( $data ); 
				$count = $sth->rowCount();
				if($count == 1):
					return 1;
				else:
					$this->errors[] = 'Testimonial could not be saved.';
				endif;
			else:
				//update the row
				
				$sql = "UPDATE `".TABLE_PREFIX."testimonials` SET `testimonial_title`= :testimonialTitle,
																	`testimonial_address`= :testimonialAddress,
																	`testimonial_alias`= :testimonialAlias,
																	`testimonial_image` =  :testimonialImage,
																	`testimonial_status` =  :testimonialStatus,
																	`testimonial_updated` = :testimonialUpdated,
																	`testimonial_unseen` = :testimonialUnseen,
																	`testimonial_content` =  :testimonialContent WHERE `testimonial_id`= :testimonialId
																	";
				$alias = empty($testimonial_alias)? $this->create_alias($testimonial_title) : $this->create_alias($testimonial_alias);
				$data = array(
							':testimonialTitle' =>$testimonial_title,
							':testimonialAlias' =>$alias,
							':testimonialAddress' => $testimonial_address,
							':testimonialImage' =>$testimonial_image,
							':testimonialStatus' =>$testimonial_status,
							':testimonialUpdated' =>DATETIME,
							':testimonialUnseen' =>"0",
							':testimonialContent' =>$testimonial_content,
							':testimonialId' => $testimonial_id
							);
				$sth = $this->db->prepare($sql);
				$sth->execute($data);
				$count = $sth->rowCount();
				if($count == 1):
					return 2;
				else:
					$this->errors[] = "Testimonial could not be saved";
				endif;
			endif;
		endif;
		return false;
	}
	public function getTestimonial($testimonial_id){
		$sql = "SELECT * FROM `".TABLE_PREFIX."testimonials` WHERE `testimonial_id`='$testimonial_id'";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		return $sth->fetch();
	}
	public function delete($testimonial_id,$confirmDelete){
		$sql = "SELECT * FROM `".TABLE_PREFIX."testimonials` WHERE `testimonial_id` = '$testimonial_id'";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		$count = $sth->rowCount();
		if($count == 1):
			return true;
		else:
			return false;
		endif;
	}

	public function deleteNow($testimonial_id){
		$sql = "DELETE FROM `".TABLE_PREFIX."testimonials` WHERE `testimonial_id`='$testimonial_id'";
		$sth = $this->db->prepare($sql);
		if($sth->execute()):
			$response = true;
		else:
			$response = false;
		endif;
		return $response;
	}
	public function deleteAll($testi_id_array){
		foreach($testi_id_array as $testi_id){
		$sql = "DELETE FROM `".TABLE_PREFIX."testimonials` WHERE `publication_id`='$testi_id'";
		$sth = $this->db->prepare($sql);
		$sth->execute();
	}
	return true;	
	}
	public function getAllTestimonialsOrder($id = NULL, $level = 0, $first_call = true) {
			$this->testList .=  $first_call == true ? '<ol id="sortableTesti" class = "sortable">' : '<ol>';
			$call = $first_call == true ? false : false;
			$id = isset($id) ? $id : 0;
			$sth = $this->db->prepare("SELECT `testimonial_id`, `testimonial_title`, `testimonial_order` FROM `".TABLE_PREFIX."testimonials` ORDER BY `testimonial_order` ASC;");
			
			$sth->execute();
			$objectMenu = $sth->fetchAll();
			foreach($objectMenu as $tbl_field => $tbl_value) :
				$testid = $tbl_value->testimonial_id;
				$testtitle = stripslashes($tbl_value->testimonial_title);
				$testorder = $tbl_value->testimonial_order;
				$this->testList .= '<li id="list_'.$testid.'"><div><span class="disclose"><span></span></span>'.$testtitle.'</div>';
				$this->testList .= '</li>';
			endforeach;
			$this->testList .=  '</ol>';
			return $this->testList;			
		}
		
	public function updateAllTestimonialsOrder(){
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
			$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."testimonials` SET 
										`testimonial_order` = '".$sort[$parentId]."'
									    WHERE `testimonial_id` = '".$id."'");
			$sth->execute();
    		// increment the sort order for this level
	        $sort[$parentId]++;
		endforeach;
	}
}
																				
		
			
			

																							
																							  
																							  
																
																							
																
																
																							  
																
															

			
                