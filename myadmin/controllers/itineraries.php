<?php 
	/**
	 * Itinerary module controller page
	 *
	 * @package admin-login
	 * @date 03rd Jan 2014
	 */

	class Itineraries extends Controller{
		function __construct(){
			parent::__construct();
			$redirect_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
			Authorize::handleLogin($redirect_link); //check user is logged or not
		}
		public function index(){
			$this->lists();
		}
		public function lists(){
			$pages = new Paginator(PER_PAGE,'page');
			$pages->set_total( $this->model->get_all_count() );
			$this->view->itineraries = $this->model->getAllItineraries( $pages->get_limit());
			$this->view->links = $pages->page_links();
			$this->view->deleteError = $this->model->errors;
			$this->view->confirmDelete = isset($this->view->confirmDelete) ? true : false;
			$this->view->render("itinerary/index");
		}
		public function update($id){
			$details = $this->model->getItineraryDetails($id);
			$this->view->details = $details;
			$this->view->adjacency = $this->model->menu_adjacency(0, $details->trip_parent, 0, 0,"itinerary");
			$this->view->catAdjacency = $this->model->cat_adjacency($details->category_id);
			$this->view->newForm = false;  
			$this->view->render("itinerary/form");
		}
		public function info($id){
			$this->view->info_parent = $id;
			$info = $this->model->checkInfo($id);
			if($info == 1):
				$this->view->details = $this->model->getItineraryInfo($id);
				$this->view->newForm = false;
			elseif($info == 0):
				$this->view->newForm = true;
			endif;
			$this->view->render("itinerary/info");  
		}
		public function cost($id){
			$this->view->cost_parent = $id;
			$cost = $this->model->checkCost($id);
			if($cost == 1):
				$this->view->details = $this->model->getItineraryCost($id);
				$this->view->includes = $this->model->getItineraryCostInc($id);
				$this->view->newForm = false;
			elseif($cost == 0):
				$this->view->includes = $this->model->getItineraryCostInc($id);
				$this->view->newForm = true;
			endif;
			$this->view->render("itinerary/cost");  
		}

		public function create(){
			$this->view->newForm = true;
			$this->view->adjacency = $this->model->menu_adjacency(0, 0, 0, 0,"itinerary");
			$this->view->catAdjacency = $this->model->cat_adjacency(0);
			$this->view->render("itinerary/form");
		}

		public function save(){
			$response = $this->model->saveItinerary();
			if($response == 1)
				header("Location:".ADMIN_URL."/itineraries/lists");
		}
		public function saveInfo(){
			$response = $this->model->saveItineraryInfo();
			if($response == 1)
				header("Location:".ADMIN_URL."/itineraries/lists");
		}
		public function saveCost(){
			$response = $this->model->saveItineraryCost();
			if($response == 1)
				header("Location:".ADMIN_URL."/itineraries/lists");
		}
		public function delete($id,$nid,$confirm = false){
			if(!$confirm):
				$this->view->delid = $id;
				$this->view->nid = $nid;
				$this->view->confirmDelete = true;
				$this->lists();
			elseif($confirm==1):
				$response = $this->model->deleteItinerary($id,$nid);
				if($response == 1):return header("Location:".ADMIN_URL."/itineraries/lists");
				else:
					return header("Location:".ADMIN_URL."/itineraries/lists");
				endif; 
			endif;	
		}		
		public function bookings($id = false){
			if(!$id):
				$bookings = $this->model->getBookings();
				$this->view->bookings = $bookings;
				$this->view->deleteError = $this->model->errors;
				$this->view->confirmDelete = isset($this->view->confirmDelete) ? true : false;
				$this->view->render("itinerary/bookings");
			else:
				$booking = $this->model->getBooking($id);
				$this->view->booking = $booking;
				$this->view->render("itinerary/showbooking");
			endif;
		}
		public function deletebooking($id,$confirm = false){
			if(!$confirm):
				$this->view->delid = $id;
				$this->view->confirmDelete = true;
				$this->bookings();
			elseif($confirm==1):
				$response = $this->model->deleteBooking($id);
				if($response == 1):return header("Location:".ADMIN_URL."/itineraries/bookings");
				else:
					return header("Location:".ADMIN_URL."/itineraries/bookings");
				endif; 
			endif;	
		}
		public function plans($id = false){
			if(!$id):
				$plans = $this->model->getPlans();
				$this->view->plans = $plans;
				$this->view->deleteError = $this->model->errors;
				$this->view->confirmDelete = isset($this->view->confirmDelete) ? true : false;
				$this->view->render("itinerary/plans");
			else:
				$plans = $this->model->getPlan($id);
				$this->view->plan = $plans;
				$this->view->render("itinerary/showplans");
			endif;
		}
		public function gallery($id){
			$this->view->gallery_parent = $id;
			$gallery = $this->model->checkGallery($id);
			if($gallery == 1):
				$this->view->allImages = $this->model->getItineraryGallery($id);
				// $this->view->includes = $this->model->getItineraryCostInc($id);
				$this->view->newForm = false;
			elseif($gallery == 0):
				$this->view->newForm = true;
			endif;
			$this->view->render("itinerary/gallery");  
		}
		public function gallerySave(){
			$response = $this->model->saveItineraryGallery();
			if($response == 1)
				header("Location:".ADMIN_URL."/itineraries/lists");
		}
		public function videoSave(){
			$response = $this->model->saveItineraryVideo();
			if($response == 1)
				header("Location:".ADMIN_URL."/itineraries/lists");
		}
		public function ajax_update_caption(){
			$response = $this->model->updateCaption();
			if($response == 1)return true;
		}
		public function ajax_image_delete(){
			$response = $this->model->deleteImage();
			if($response == 1)return true;
		}
		public function video($id){
			$this->view->video_parent = $id;
			$video = $this->model->checkVideo($id);
			if($video == 1):
				$this->view->allVideos = $this->model->getItineraryVideo($id);
				// dd($this->view->allVideos);
				$this->view->newForm = false;
			elseif($video == 0):
				$this->view->newForm = true;
			endif;
			$this->view->render("itinerary/video");  
		}
		public function ajax_update_vcaption(){
			$response = $this->model->updateVCaption();
			if($response == 1)return true;
		}
		public function ajax_video_delete(){
			$response = $this->model->deleteVideo();
			if($response == 1)return true;
		}
// review
		public function review($id){
			$this->view->review_parent = $id;
			$review = $this->model->checkReview($id);
			$this->view->reviews = $this->model->getallreviews($id);
			$this->view->render("itinerary/reviews");
		}
		public function editreview($id){
			$this->view->review = $this->model->getreview($id);
			$this->view->render("itinerary/editreview");
		}
		public function reviewsave(){
			$response = $this->model->saveReview();
			$this->lists();
		}
		public function deleteReview($id,$parent=false){
			if(isset($_GET['confirm']) == "true"):
				$response = $this->model->confirmDelete($id);
				if($response == 1) $this->review($parent);
				else dd("somethingwentwrong");
			else:
				$this->view->deleteid = $id;
				$this->review($parent);
			endif;

		}
// categories
		public function categories(){
			$this->view->categories = $this->model->allCats();
			$this->view->render("itinerary/categories");
		}
		public function catsave(){
			$response = $this->model->saveCategory();
			if($response)
			header("Location:".ADMIN_URL."/itineraries/categories");
			else{
			$this->view->errors = $this->model->errors; 
			header("Location:".ADMIN_URL."/itineraries/categories");
			}
		}	
		public function ordercats(){
			$this->view->categories = $this->model->getAllCatsOrder();
			$this->view->render('itinerary/ordercats');
		}

		public function ajax_order_cats(){
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
				$this->model->updateAllCatsOrder();
				return true;
			else :
				$this->view->render('error/index');
			endif;
		}
		public function editCat($id){
			$this->view->category = $this->model->getCat($id);
			$this->view->categories = $this->model->allCats();
			$this->view->render("itinerary/categories");
		}
		public function deleteCat($id){
			if(isset($_GET['confirm'])&&($_GET['confirm']==true)){
				$this->model->deletecat($id);
				header("Location:".ADMIN_URL."/itineraries/categories");
			}
			else{
				$this->view->delid = $id;
				$this->view->invokedel = true;
				$this->view->render("itinerary/categories");

			}

		}
} 