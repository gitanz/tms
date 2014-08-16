<?php 
/**
 * class News_Model
 * handles page modules
 * @package HimalayanPursuits
 * @author 
 * @link 
 */
class Testimonial_Model extends Model{

	public function __construct(){
		parent::__construct();
	}
	public function getAllTestimonials(){
		$sql = "SELECT * FROM `".TABLE_PREFIX."testimonials` WHERE `testimonial_status` = '1' ORDER BY `testimonial_added`";
		$sth = $this->db->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
	}
	public function getTestimonial($id){
		$sql = "SELECT * FROM `".TABLE_PREFIX."testimonials` WHERE `testimonial_status` = '1' AND `testimonial_id` = :id";
		$sth = $this->db->prepare($sql);
        $sth->execute([':id'=>$id]);
        return $sth->fetch();
	}
	public function getTestimonialsFooter(){
		$sql = "SELECT * FROM `".TABLE_PREFIX."testimonials` WHERE `testimonial_status` = '1' ORDER BY `testimonial_added` DESC LIMIT 1";
		$sth = $this->db->prepare($sql);
        $sth->execute();
        return $sth->fetch();
	}

}