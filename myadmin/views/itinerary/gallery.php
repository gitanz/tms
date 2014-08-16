<?php
	/**
	 * gallery form for Itinerary
	 * @package admin-login
	 * @date July 7, 2014
	 */
	 
	require_once('views/_templates/sidebar.php');
	$galleryParent = $this->gallery_parent;
	$newform = $this->newForm? "1" : "0";
	if ($this->newForm == 1 || empty( $_POST['banner_id'] )):
		// $galleryTitle = isset($_POST['gallery_title']) ? $_POST['gallery_title'] : '';
		// $galleryAlias = isset($_POST['page_id']) ? $_POST['gallery_alias'] : "";
		// $galleryStatus = isset($_POST['gallery_id']) ? $_POST['gallery_status'] : "1";
		// $galleryParent = "";
		$pageTitles = 'Create Itinerary Gallery';
	endif;
	
	if ($this->newForm == '' || !empty( $_POST['banner_id'] )):
		// $galleryTitle = isset($_POST['gallery_title']) ? $_POST['gallery_title'] : $this->gallery->gly_title;	
		// $galleryAlias = isset($_POST['gallery_alias']) ? $_POST['gallery_alias'] : $this->gallery->gly_alias;	
		// $galleryParent = isset($_POST['gallery_id']) ? $_POST['gallery_id'] : $this->gallery->gly_id;
		// $galleryStatus = isset($_POST['gallery_id']) ? $_POST['gallery_status'] : $this->gallery->gly_status;
		$pageTitles = 'Update Itinerary Gallery';
	endif;
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title"><?=$pageTitles?></h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/itineraries/lists">Itineraries</a> <span class="divider">/</span></li>
                <li class="active"><?=$pageTitles?></li>
            </ul>
            
           	<div class="container-fluid">
            	<div class="row-fluid">
                <?php if (isset($this->errors)) : ?>
                	
                <?php endif; ?>
					<div class="well">
        	            <div class="span6">
				            <div class="block-body">
                				<form id="pageForm" action="<?=ADMIN_URL?>/itineraries/gallerySave" method="post" autocomplete="off">
						        <div class="control-group" id="fields">                        	
                        		    <div class="controls-field" id="b1">
                            		<label>Caption 1</label>
							        <input type="text" name="gallery_titles[]" value="" class="input-xlarge" placeholder="Enter caption here" />
		                            <label class="control-label" for="galleryImg1">Image 1</label>
        	                    	<div class="input-append">
	    								<input type="text" value="" id="galleryImg1" name="gallery_image[]" class="input-xlarge" placeholder="Select image" />
								    	<a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=galleryImg1">Select</a><button id="b1" class="btn btn-info add-more-gallery" type="button">+</button>
									</div>
	                            	</div>
    	                        	<small>For better image resolution, Image size should be 800x600 px</small>
        	                	</div>
        		                <hr />
                		        <div>
                       				<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
		                        </div>
        		                <input type="hidden" name="gallery_parent" value="<?=$galleryParent?>" />
                		        <input type="hidden" name="form" value="<?=$newform?>" />
							    </form>
				                <div class="clearfix"></div>
            				</div>
			        	</div>
                        <?php if($this->newForm == false): ?>
				        <div class="block span6">
				            <p class="block-heading">Images</p>
                            <table class="table table-striped">
    	                   	<thead>
        	                	<tr>
            	              		<th>#</th>
		                            <th>Image</th>
                                    <th>Caption</th>
                        		    <th></th>
                               	</tr>
                            </thead>
                            <tbody>
                            <?php 
								if( $this->allImages ):
									$row = 1;
									foreach($this->allImages as $image) :

							?>
                            	<tr class="dintro">
                                	<td><?=$row?></td>
                                    <td>
                                    	<a href="<?=View::attachmentFullPathCorrect($image->gallery_path)?>" class="iframe-btn" title="<?=$image->gallery_caption?>">
		                                <img class="img-polaroid" src="<?=View::attachmentThumbPathCorrect($image->gallery_path)?>">
        		                        </a>
                                    </td>
                                    <td><a href="#" id="caption" class="inline-edit" data-type="text" data-pk="<?=$image->gallery_id?>" data-url="<?=ADMIN_URL?>/itineraries/ajax_update_caption" data-title="Enter caption"><?=$image->gallery_caption?></a></td></td>
									<td><a href="#" id="<?=$image->gallery_id?>" class="idelete_image" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>                                </tr>
                            <?php
									$row++;
									endforeach;
								endif;
							?>
                            </tbody>
                            </table>
				        </div>                        
                        
                        <?php endif; ?>
                        <div class="clearfix"></div>				    
					</div>
               	</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->	