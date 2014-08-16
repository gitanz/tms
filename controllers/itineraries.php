<?php
	/**
	 * Controller index page
	 * @package himalayanPursuits
	 */
	class Itineraries extends Controller {
		public $loadCSS = array();
		public $loadJS = array();
		
		function __construct() {
        	parent::__construct();
    	}
        function ajax_holidays(){
            $results = $this->model->getItineraries($_POST['id'],'0','');
            $selects = "<option>Select Trip</option>";
            if(count($results)>0):
            foreach($results as $result){
                $selects .= "<option value = '$result->trip_parent'>$result->trip_title</option>\n";
            }
            endif;
            if($selects == "") $selects .= "<option>No itineraies found</option>";
            $data = ['success'=>true,"message"=>$selects];
            echo json_encode($data);
        }
    	function do_ajax(){
            $id = $_POST['iTid'];
            $results = $this->model->getItineraries($id);
            //makehtml
    		$html = "";
            $i = 1;
            // dd($results);
    		foreach($results as $result):
                if($i===3){
                $html .= '<div class="tabDivLast fltLeft">';
                $i=0;
                }
                else
                $html .= '<div class="tabDiv fltLeft">';
                $html .= '<img class = "tabImg" src="'.$result->trip_image.'" alt="'.$result->trip_title.'">';
                $html .= '<div class="tabTitle fltLeft"><strong>'.$result->trip_title.'</strong></div>';
                $html .= '<div class="fltRight"><strong>'.explode('/',$result->info_trek_duration)[0].' Days</strong></div>';
                $html .= '<div class="tabButDiv fltLeft"><a href="'.SITE_URL.'/itineraries/show/'.$result->trip_parent.'"><img src="'.SITE_URL.'/assets/images/og-view-trip.jpg" width="110" height="30" alt="View Trip"></a></div><div class="tabButDiv fltLeft"><a href="'.SITE_URL.'/itineraries/book/'.$result->trip_id.'"><img src="'.SITE_URL.'/assets/images/gr-book-trip.jpg" width="111" height="30" alt="Book Trip"></a></div>';
                $html .= '<div class="clear"></div>';
                $html .= '</div>';
                
                $i++;                                    
    		endforeach;
                
                $nohtml = (empty($html))?true:false;
                $html .= '<div class = "clear"></div>';
    			if(!$nohtml)
							$data = array('success'=>true , 'message'=>$html);
				elseif($nohtml)
							$data = array('success'=>false , 'message'=>'Could not load the content! Try again later');
				echo json_encode($data);
    	}
	    
        function show($id){
            $result = $this->model->fetchWithParentNav($id);
            if(is_object($result))
            $sideGallery = $this->model->fetchGallery($result->trip_id);
            $site_title = $result ? $result->trip_title : "";
            $site_desc = $result ? $result->trip_overview : "";                
            $seo = new phpSEO( $site_desc );
            $keywords = $seo->getKeyWords(12);
            $desc = $seo->getMetaDescription(150); 

            $breadcrumb = $this->model->breadcrumb($id);
            $this->view->breadcrumb = $breadcrumb;
            $this->view->Set_Site_Title( SITE_TITLE.' &#8250; '.$site_title );          
            $this->view->Set_Meta_Keywords( $keywords );
            $this->view->Set_Meta_Description( $desc );

            $this->view->Set_CSS();
            $this->view->Set_JS();

            if(isset($sideGallery)&&is_object($sideGallery))
            $this->view->sidegallery = $sideGallery;    
            $this->view->result = $result;
            if(is_object($result))
            $this->view->render('itinerary/show');
            else{
            $this->view->title =$site_title;    
            $this->view->render('itinerary/undercons');
            }
        }
        function planatrip(){
            $this->view->destinations = $this->model->getDestinations();
            $this->view->render('itinerary/planatrip');
        }
        function category($id){
            if(!$id):
            $results = $this->model->getAllCategories();
            $this->view->listing = true;
            $this->view->results = $results;
            $this->view->render("content/categories");
            else:
            $result = $this->model->getCategory($id);
            // dd($result);
            $this->view->listing = false;
            $this->view->result = $result;
            $this->view->render("content/categories");
            endif;
     
        }
        function gallery($id){
            $results = $this->model->getGalleryImage($id);
            $result = $results[0];
            $breadcrumb = $this->model->breadcrumb($result->trip_parent);
            $this->view->breadcrumb = $breadcrumb;
            $site_title = $result ? $result->trip_title : "";
            $site_desc = $result ? $result->trip_overview : "";                
            $seo = new phpSEO( $site_desc );
            $keywords = $seo->getKeyWords(12);
            $desc = $seo->getMetaDescription(150); 
            $this->view->Set_Site_Title( SITE_TITLE.' &#8250; '.$site_title );          
            $this->view->Set_Meta_Keywords( $keywords );
            $this->view->Set_Meta_Description( $desc );

            $this->view->Set_CSS();
            $this->view->Set_JS();
            $this->view->results = $results;
            $this->view->title =$site_title;    
            if(is_object($result))
                $this->view->result = $result;
            if(count($results)>0)
            $this->view->render('itinerary/gallery');
            else{
            $this->view->render('itinerary/undercons');
            }

        }
        function videos($id){
            $results = $this->model->getVideos($id);
            $result = $results[0];
            $breadcrumb = $this->model->breadcrumb($result->trip_parent);
            $this->view->breadcrumb = $breadcrumb;
            $site_title = $result ? $result->trip_title : "";
            $site_desc = $result ? $result->trip_overview : "";                
            $seo = new phpSEO( $site_desc );
            $keywords = $seo->getKeyWords(12);
            $desc = $seo->getMetaDescription(150); 
            $this->view->Set_Site_Title( SITE_TITLE.' &#8250; '.$site_title );          
            $this->view->Set_Meta_Keywords( $keywords );
            $this->view->Set_Meta_Description( $desc );

            $this->view->Set_CSS();
            $this->view->Set_JS();
            $this->view->results = $results;
            $this->view->title =$site_title;    
            if(is_object($result))
                $this->view->result = $result;
            if(count($results)>0)
            $this->view->render('itinerary/video');
            else{
            $this->view->render('itinerary/undercons');
            }

        }
        function book($id){
                $result = $this->model->fetchWithParentNav($id);
                $site_title = $result ? $result->trip_title."&#8250;Book" : "";
                $site_desc = $result ? $result->trip_overview : "";                
                $seo = new phpSEO( $site_desc );
                $keywords = $seo->getKeyWords(12);
                $desc = $seo->getMetaDescription(150); 
                $this->view->Set_Site_Title( SITE_TITLE.' &#8250; '.$site_title );          
                $this->view->Set_Meta_Keywords( $keywords );
                $this->view->Set_Meta_Description( $desc );
                $this->view->Set_CSS();
                $this->view->Set_JS();
                $this->view->result = $result;
                $this->view->render('itinerary/book');
        }
        function ajax_book(){
            $result = $this->model->bookItinerary();
            $html = "<div class = 'alert alert-info'>".$result."</div>";
            $data = ["success"=>true, "message"=>$html];
            echo json_encode($data);
        }
        function plannedbooking(){
            $result = $this->model->planbook();
            $html = "<div class = 'alert alert-info'>".$result."</div>";
            $data = ["success"=>true, "message"=>$html];
            echo json_encode($data);
        }
        function getAjax($thing){
            $results = $this->model->fetchItinerary($_POST['tId']);
            $details = $results[0];
            $html = "";
            switch($thing):
                case("outline-itinerary"):
                    $html .= "<div class = 'tabconts'>".$details->trip_outline."</div>";
                break;
                case("detailed-itinerary"):
                    $html .= "<div class = 'tabconts'>".$details->trip_day2day."</div>";
                break;
                case("notes"):
                    $html .= "<div class = 'tabconts'>".$details->trip_notes."</div>";
                break;
                case("map"):
                    $html .= "<div class = 'tabconts'><img width = '100%' src = '".$details->trip_map."'></div>";
                break;
                case("reviews"):
                    $c_reviews = count($details);
                    $revs = 0;
                    foreach($results as $review):
                            $html .= '<div class = "tabconts">';
                        if(!empty($review->review_title) && $review->review_status = "1"):
                            $revs++;
                            $html .=   '<div class="media">
                                          <div class="pull-left" style = "width:200px;" href="javascript:void(0)">
                                            <img class="media-object" src="'.$review->review_image.'" alt="'.$review->review_title.'">
                                            <p>'.$review->review_name.'</p>
                                            <p>'.$review->review_address.'</p>
                                            <p>'.$review->review_company.'</p>
                                            <p>'.$review->review_designation.'</p>
                                          </div>
                                          <div class="media-body">
                                            <h4 class="media-heading">'.$review->review_title.'</h4>
                                            <p>'.$review->review_experience.'</p>
                                          </div>
                                        </div><hr><div class = "clear"></div>';
                        endif;
                    endforeach;

                    if($revs == 0):    
                    $html .= "There are no reviews yet. Be the first one to add.<br><a id = 'addreview' href = 'javascript:void(0)' class = 'btn btn-primary'>Add review</a></div>";
                    else:
                    $html .= "Add your review.<br><a id = 'addreview' href = 'javascript:void(0)' class = 'btn btn-primary'>Add review</a>";
                    endif;
                    $html .="<script>
                                $('#addreview').click(function(){
                                    $.ajax({
                                        type:'POST',
                                        url:'".SITE_URL."/itineraries/getReviewForm',
                                        dataType:'json',
                                        cache:'false',
                                        data:{
                                            pid:'".$details->trip_id."',
                                        },
                                        beforeSend:function(){
                                            $('.tab-content').html('<img src = \"".SITE_URL."/assets/images/loading.gif\" align = \"absmiddle\"/> processing...');
                                        },
                                        success:function(data){
                                            $('.tab-content').html(data.message);
                                        }
                                    });                
                                });
                            </script>";  
                    
                break;
            endswitch;
                if($html == '')
                    $nohtml = true;
                else
                    $nohtml = false;
                $html .= ' <hr>
                                    <div class = "fltRight">
                                        <a href = "'.SITE_URL.'/itineraries/book/'.$details->trip_parent.'?tailormade=1"><img src = "'.SITE_URL.'/assets/images/tailor-made-trip-btn.png" alt = "Tailor Made Trip"></a>
                                        <a href = "'.SITE_URL.'/itineraries/book/'.$details->trip_parent.'"><img src = "'.SITE_URL.'/assets/images/book-trip.jpg" alt = "Book Trip"></a>
                                    </div>
                                    <div class = "clear"></div>    ';
                // dd($nohtml);                    
                if(!$nohtml)
                $data = ["success"=>true,
                         "message"=>$html   
                        ];
                if($nohtml)
                $data = ["success"=>false,
                         "message"=>"Sorry the content cannot be loaded at this time. Please try later!"   
                        ];
                echo json_encode($data);    
        }
        function getReviewForm(){
            $id = $_POST['pid'];
            $html = "";
            $html .= '<div class="spacer1"></div>';
            $html .= '<h4>Share Your Experience</h4>';
            $html .= '<div class="spacer1"></div>';
            $html .= '<div id="msgContainer"><div id="reviewForm-message"></div></div>';
            $html .= '<div class="formWrapper">
                    <form method="post" action="#" id="reviewForm" name="reviewForm" autocomplete="off" enctype="multipart/form-data">
                    <label for="Title">Title:</label>
                    <input type="text" name="title" id="title" placeholder="Enter your testimonial title" />
                    
                    <label for="Experience">Experience:</label>
                    <textarea name="testimonial" placeholder="Enter your Experience here" id="testimonial" class="required" minlength="15"></textarea>
                    <label for="Full Name">Full Name:</label>
                    <input type="text" name="name" id="name" class="required" minlength="3" placeholder="Enter your full name" />
                    
                    <label for="Image">Image:</label>
                    <input type="file" id="upload-btn" name = "file" class="btn btn-primary btn-large clearfix" value="Choose file">
                    
                    <label for="Email">Email:</label>
                    <input type="text" name="email" id="email" placeholder="Enter your email" />
                    
                    <label for="Address">Address:</label>
                    <input type="text" name="address" id="address" placeholder="Enter your address" />
                    
                    <label for="Company">Company:</label>
                    <input type="text" name="company" id="company" placeholder="Enter your company name" />
                    
                    <label for="Designation">Designation:</label>
                    <input type="text" name="designation" id="designation" placeholder="Enter your designation in the company" />
                    
                    <label for="Website">Website:</label>
                    <input type="text" name="url" id="url" class="url" placeholder="Enter website address" />
                    
                    <label for="sumit">&nbsp;</label>
                    <input type="submit" name="submit" value="Submit" id="sbmt" class="submit-button" />
                    <input type="button" name="cancel" value="Cancel" id="cancel" class="submit-button" />
                    <input type="hidden" name="action" value="Dosubmit" />
                    <input type="hidden" name="id" value="'.$id.'" />
                    </form>
                </div>';
            $html .= '<script src="'.SITE_URL.'/assets/js/jquery.form.js"></script>';
            $html .= '<script src="'.SITE_URL.'/assets/js/js.val.js"></script>';
                 $data = [
                        "success"=>true,
                        "message"=>$html  
                            ];
                echo json_encode($data);    
        }
    function saveReviewForm(){
        $response = $this->model->saveReviewForm();
        if($response == '1') $data = ["success"=>true,"message"=>"Your review has been successfully submitted, pending for administrator verification"];
        echo json_encode($data);        
    }    
}
