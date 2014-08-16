<?php 
Class News_Model extends Model{
	public $errors = [];
	public function __construct(){
		parent::__construct();
	}
	
	public function getAllNews( $limit, $parent = false  ){
		$sth = $this->db->prepare("SELECT `news_id`,`news_title`, `news_alias`, `news_type`,FROM_UNIXTIME(news_added, '%a, %D %b %Y. %h:%i %p') as `added` FROM `".TABLE_PREFIX."news` ORDER BY `news_added` DESC ".$limit."");				
		$sth->execute();
    	return $sth->fetchAll();
	}
	public function get_all_count() {
		$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."news`");
        $sth->execute();
		return $sth->rowCount();
	}
	public function saveFormData($postarray){
		foreach($postarray as $key=>$value):
			$$key = $value;
		endforeach;
		if(empty($news_title)):
			$this->errors[] = "news Title field is required";
		else:
			if($form):
				//insert new row
				$sql = "INSERT INTO `".TABLE_PREFIX."news`(`news_title`,
																`news_alias`,
																`news_date`,
																`news_file`,
																`news_image`,
																`news_type`,
																`news_status`,
																`news_added`,
																`news_content`) VALUES(  :newsTitle,
																								:newsAlias,
																								:newsDate,
																								:newsFile,
																								:newsImage,
																								:newsType,
																								:newsStatus,
																								:newsAdded,
																								:newsContent);";
				
					
				$alias = empty($news_alias)? $this->create_alias($news_title) : $this->create_alias($news_alias);	
				$data = array(
					':newsTitle' => $news_title,
					':newsAlias' => $alias,
					':newsDate' => strtotime($news_date),
					':newsFile' => $news_file,
					':newsImage' => $news_image,
					':newsType' => $news_type,
					':newsStatus' => $news_status,
					':newsAdded' => DATETIME,
					':newsContent' => $news_content, 
					);
				$sth = $this->db->prepare( $sql );
				$execute = $sth->execute( $data ); 
				$count = $sth->rowCount();
				if($count == 1):
					return 1;
				else:
					$this->errors[] = 'News could not be saved.';
				endif;
			else:
				//update the row
				
				$sql = "UPDATE `".TABLE_PREFIX."news` SET `news_title`= :newsTitle,
																`news_date`= :newsDate,
																	`news_alias`= :newsAlias,
																	`news_image` =  :newsImage,
																	`news_file` =  :newsFile,
																	`news_type` =  :newsType,
																	`news_status` =  :newsStatus,
																	`news_updated` = :newsUpdated,
																	`news_content` =  :newsContent WHERE `news_id`= :newsId
																	";
				$alias = empty($news_alias)? $this->create_alias($news_title) : $this->create_alias($news_alias);
				$data = array(
							':newsTitle' =>$news_title,
							':newsAlias' =>$alias,
							':newsDate' =>strtotime($news_date),
							':newsFile' =>$news_file,
							':newsImage' =>$news_image,
							':newsType' =>$news_type,
							':newsStatus' =>$news_status,
							':newsUpdated' =>DATETIME,
							':newsContent' =>$news_content,
							':newsId' => $news_id
							);
				$sth = $this->db->prepare($sql);
				$sth->execute($data);
				$count = $sth->rowCount();
				if($count == 1):
					return 2;
				else:
					$this->errors[] = "News could not be saved";
				endif;
			endif;
		endif;
		return false;
	}
	public function getNews($news_id){
		$sql = "SELECT * FROM `".TABLE_PREFIX."news` WHERE `news_id`='$news_id'";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		return $sth->fetch();
	}
	public function delete($news_id,$confirmDelete){
		$sql = "SELECT * FROM `".TABLE_PREFIX."news` WHERE `news_id` = '$news_id'";
		$sth = $this->db->prepare($sql);
		$sth->execute();
		$count = $sth->rowCount();
		if($count == 1):
			return true;
		else:
			return false;
		endif;
	}

	public function deleteNow($news_id){
		$sql = "DELETE FROM `".TABLE_PREFIX."news` WHERE `news_id`='$news_id'";
		$sth = $this->db->prepare($sql);
		if($sth->execute()):
			$response = true;
		else:
			$response = false;
		endif;
		return $response;
	}
	public function deleteAll($pub_id_array){
		foreach($pub_id_array as $pub_id){
		$sql = "DELETE FROM `".TABLE_PREFIX."news` WHERE `news_id`='$pub_id'";
		$sth = $this->db->prepare($sql);
		$sth->execute();
	}
	return true;	
	}

}
																				
		
			
			

																							
																							  
																							  
																
																							
																
																
																							  
																
															

			
                