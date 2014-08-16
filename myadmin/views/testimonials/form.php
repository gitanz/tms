<?php

	 
	require_once('views/_templates/sidebar.php');
	 
	if ($this->new_form == 1 || empty( $_POST['testimonial_id'] )):
		$testimonialTitle = isset($_POST['testimonial_id']) ? $_POST['testimonial_title'] : "";
		$testimonialAddress = isset($_POST['testimonial_address']) ? $_POST['testimonial_address'] : "";

		$testimonialAlias = isset($_POST['testimonial_id']) ? $_POST['testimonial_alias'] : "";
		$testimonialImg = isset($_POST['testimonial_image']) ? $_POST['testimonial_image'] : "";
		
		$testimonialStatus = isset($_POST['testimonial_id']) ? $_POST['testimonial_status'] : "1";
		
		$testimonialDate = isset($_POST['testimonial_added']) ? $_POST['testimonial_added'] : $this->datetime;
		$testimonialContent = isset($_POST['testimonial_content']) ? $_POST['testimonial_content'] : "";
		$testimonialId = "";
		$testimonialTitles = 'Create Testimonial';
	endif;
	
	if ($this->new_form == '' || !empty( $_POST['testimonial_id'] )):
		$testimonialTitle = isset($_POST['testimonial_id']) ? $_POST['testimonial_title'] : $this->testimonials->testimonial_title;
		$testimonialAddress = isset($_POST['testimonial_address']) ? $_POST['testimonial_address'] : $this->testimonials->testimonial_address;

		$testimonialAlias = isset($_POST['testimonial_id']) ? $_POST['testimonial_alias'] : $this->testimonials->testimonial_alias;
		$testimonialImg = isset($_POST['testimonial_image']) ? $_POST['testimonial_image'] : $this->testimonials->testimonial_image;
		
		$testimonialStatus = isset($_POST['testimonial_id']) ? $_POST['testimonial_status'] : $this->testimonials->testimonial_status;
		
		$testimonialDate = isset($_POST['testimonial_datetime']) ? $_POST['testimonial_datetime'] : $this->datetime;
		$testimonialContent = isset($_POST['testimonial_content']) ? $_POST['testimonial_content'] :$this->testimonials->testimonial_content;
		$testimonialId = isset($_POST['testimonial_id']) ? $_POST['testimonial_id'] : $this->testimonials->testimonial_id;		
		$testimonialTitles = 'Update Testimonial';
	endif;
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title"><?=$testimonialTitles?></h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/testimonials/lists">Testimonials</a> <span class="divider">/</span></li>
                <li class="active"><?=$testimonialTitles?></li>
            </ul>
            
           	<div class="container-fluid">
            	<div class="row-fluid">
                <?php if (isset($this->errors)) : ?>
                	
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
				    <form id="testimonialsForm" action="<?=ADMIN_URL?>/testimonials/save" method="post" autocomplete="off">
				        <label>Testimonial Title *</label>
				        <input type="text" name="testimonial_title" value="<?=$testimonialTitle?>" class="input-xlarge" placeholder="Enter testimonial title here" />

				        <label>Address</label>
				        <input type="text" name="testimonial_address" value="<?=$testimonialAddress?>" class="input-xlarge" placeholder="Enter Address here" />

				        <label>Alias</label>
				        <input type="text" name="testimonial_alias" value="<?=$testimonialAlias?>" class="input-xlarge" placeholder="Auto generated from title"  id="disabledInput" />
				                         
                        <label>Testimonial Image</label>
				        <div class="input-append">
	    					<input type="text" value="<?=$testimonialImg?>" id="testimonialImg" name="testimonial_image" class="input-xlarge" />
						    <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=testimonialImg">Select</a>
						</div>
                        <?php if (is_file( '../'.View::attachmentPathCorrect($testimonialImg) )) : ?>
                        <div class="block-body">
			                <a href="<?=View::attachmentFullPathCorrect($testimonialImg)?>" class="iframe-btn">
								<img class="img-polaroid" src="<?=View::attachmentThumbPathCorrect($testimonialImg)?>">
                            </a>
				            <div class="clearfix"></div>
				        </div>
                        <?php endif; ?>
                       
                        </select>

                        <label>Publish</label>
				        <select name="testimonial_status" id="testimonialStatus" class="input-small">
                        	<option value="1"<?=$testimonialStatus == '1' ? ' selected' : '' ?>>Yes</option>
                            <option value="0"<?=$testimonialStatus == '0' ? ' selected' : '' ?>>No</option>
                        </select>
                        <label>Date</label>
				        <input type="text" name="testimonial_added" value="<?=$testimonialDate?>" class="input-xlarge" id="datetime" />
                        <label>Content</label>
				        <textarea rows="3" class="input-xxlarge" name="testimonial_content" id="tinyEditor"><?=stripslashes($testimonialContent)?></textarea>
                        <hr />
                        <div>
                       		<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
                        </div>
                        <input type="hidden" name="testimonial_id" value="<?=$testimonialId?>" />
                        <input type="hidden" name="form" value="<?=$this->new_form?>" />
				    </form>
					</div>
               	</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->