<?php
	/**
	 * itinerary form
	 * @package admin-login
	 * @date 17th June 2014
	 */
	require_once('views/_templates/sidebar.php');
    $review = $this->review;
    $reviewId = $review->review_id;
    $reviewParent = $review->review_parent;
    $reviewTitle = $review->review_title;
    $reviewExperience = $review->review_experience;
    $reviewName = $review->review_name;
    // dd($review->review_image);
    $reviewImage =$review->review_image;
    $reviewEmail = $review->review_email;
    $reviewAddress = $review->review_address;
    $reviewCompany = $review->review_company;
    $reviewDesignation = $review->review_designation;
    $reviewWebsite = $review->review_title;
    $reviewStatus = $review->review_status;
    $reviewAdded = $review->review_added;
    ?>
	<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Edit Review</h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/itineraries/lists">Itinerary</a> <span class="divider">/</span></li>
                <li class="active">Edit review</li>
            </ul>
            
           	<div class="container-fluid">
            	<div class="row-fluid">
                <?php  if (isset($this->errors)) : ?>
                	<div class="alert alert-error">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
						<?php 
                            foreach ($this->errors as $error) : 
                                echo $error;
                            endforeach; 
                        ?>
                	</div>
                <?php endif; ?>
					<div class="well">
				    <form id="itineraryForm" action="<?=ADMIN_URL?>/itineraries/reviewsave" method="post" autocomplete="off">
				    
                        <label>Review Title</label>
				        <input type="text" name="review_title" value="<?=$reviewTitle?>" class="input-xlarge" placeholder="Enter Review title here" />

                        <label>Review Name </label>
                        <input type="text" name="review_name" value="<?=$reviewTitle?>" class="input-xlarge" placeholder="Enter Review title here" />

                        <label>Image</label>
                        <div class="input-append">
                            <input type="text" value="<?=$reviewImage?>" id="reviewImg" name="review_image" class="input-xlarge" />
                            <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=reviewImg">Select</a>
                        </div>
                        <?php if (is_file( '../'.View::attachmentPathCorrect($reviewImage) )) : ?>
                        <div class="block-body">
                            <a href="<?=View::attachmentFullPathCorrect($reviewImage)?>" class="iframe-btn">
                                <img class="img-polaroid" src="<?=View::attachmentThumbPathCorrect($reviewImage)?>">
                            </a>
                            <div class="clearfix"></div>
                        </div>
                        <?php endif; ?>

                        
                        <label>Review Email</label>
                        <input type="text" name="review_email" value="<?=$reviewEmail?>" class="input-xlarge" placeholder="Enter Review title here" />

                        <label>Review Address</label>
                        <input type="text" name="review_address" value="<?=$reviewAddress?>" class="input-xlarge" placeholder="Enter Review title here" />

                        <label>Review Company</label>
                        <input type="text" name="review_company" value="<?=$reviewCompany?>" class="input-xlarge" placeholder="Enter Review title here" />

                        <label>Review Designation</label>
                        <input type="text" name="review_designation" value="<?=$reviewDesignation?>" class="input-xlarge" placeholder="Enter Review title here" />

                        <label>Review Website</label>
                        <input type="text" name="review_website" value="<?=$reviewWebsite?>" class="input-xlarge" placeholder="Enter Review title here" />

                        <label>Review Status</label>
                        <select name = "review_status">
                            <option value = "1"<?php if($reviewStatus == 1) echo "selected"?>>Publish</option>
                            <option value = "0"<?php if($reviewStatus == 0) echo "selected"?>>Unpublish</option>
                        </select>
                        <label>Review Experience<label>
                        <textarea style = "width:100%;height:100px" name = "review_experience"><?=$reviewExperience?></textarea>  
                        <div>
                            <button class="btn btn-primary"><i class="icon-save"></i> Save</button>
                        </div>
                        <input type="hidden" name="review_id" value="<?=$reviewId?>" />
                    </form>
                    </div>
                </div> <!-- .row-fluid -->
                <?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->
                      
