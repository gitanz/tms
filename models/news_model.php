<?php 
/**
 * class News_Model
 * handles page modules
 * @package HimalayanPursuits
 * @author 
 * @link 
 */
class News_Model extends Model{

	public function __construct(){
		parent::__construct();
	}
	public function getAllNews(){
		$sql = "SELECT * FROM `".TABLE_PREFIX."news` WHERE `news_status` = '1' ORDER BY `news_added`";
		$sth = $this->db->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
	}
	public function getNews($id){
		$sql = "SELECT * FROM `".TABLE_PREFIX."news` WHERE `news_status` = '1' AND `news_id` = :id";
		$sth = $this->db->prepare($sql);
        $sth->execute([':id'=>$id]);
        return $sth->fetch();
	}
	public function getNewsSidebar(){
		$sql = "SELECT * FROM `".TABLE_PREFIX."news` WHERE `news_status` = '1' ORDER BY `news_added` DESC LIMIT 2";
		$sth = $this->db->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
	}
}