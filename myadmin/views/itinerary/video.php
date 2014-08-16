<?php
	/**
	 * gallery form for Itinerary
	 * @package admin-login
	 * @date July 7, 2014
	 */
	 
	require_once('views/_templates/sidebar.php');
	$videoParent = $this->video_parent;
	$newform = $this->newForm? "1" : "0";
	if ($this->newForm == 1 || empty( $_POST['banner_id'] )):
		$pageTitles = 'Create Itinerary Video';
	endif;
	
	if ($this->newForm == '' || !empty( $_POST['banner_id'] )):
		$pageTitles = 'Update Itinerary Video';
	endif;
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title"><?=$pageTitles?></h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/itineraries/lists">Videos</a> <span class="divider">/</span></li>
                <li class="active"><?=$pageTitles?></li>
            </ul>
            
           	<div class="container-fluid">
            	<div class="row-fluid">
                <?php if (isset($this->errors)) : ?>
                	
                <?php endif; ?>
					<div class="well">
        	            <div class="span6">
				            <div class="block-body">
                				<form id="pageForm" action="<?=ADMIN_URL?>/itineraries/videoSave" method="post" autocomplete="off">
						        <div class="control-group" id="fields">                        	
                        		    <div class="controls-field" id="b1">
                            		<label>Caption 1</label>
							        <input type="text" name="video_titles[]" value="" class="input-xlarge" placeholder="Enter caption here" />
                                    <label>Video Image 1</label>
                                    <div class="input-append">
                                        <input type="text" value="" id="videoimg1" name="video_image[]" class="input-xlarge" placeholder="Select video Image" />
                                        <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=videoimg1">Select</a>
                                    </div>
		                            <label class="control-label" for="video1">Video 1</label>
        	                    	<div class="input-append">
	    								<input type="text" value="" id="video1" name="video_path[]" class="input-xlarge" placeholder="Select video" />
								    	<a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=2&amp;field_id=video1">Select</a><button id="b1" class="btn btn-info add-more-video" type="button">+</button>
									</div>
	                            	</div>
        	                	</div>
        		                <hr />
                		        <div>
                       				<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
		                        </div>
        		                <input type="hidden" name="video_parent" value="<?=$videoParent?>" />
                		        <input type="hidden" name="form" value="<?=$newform?>" />
							    </form>
				                <div class="clearfix"></div>
            				</div>
			        	</div>
                        <?php if($this->newForm == false): ?>
				        <div class="block span6">
				            <p class="block-heading">Videos</p>
                            <table class="table table-striped">
    	                   	<thead>
        	                	<tr>
            	              		<th>#</th>
                                    <th>Caption</th>
                        		    <th></th>
                               	</tr>
                            </thead>
                            <tbody>
                            <?php 
								if( $this->allVideos ):
									$row = 1;
									foreach($this->allVideos as $video):
							?>
                            	<tr class="dintro">
                                	<td><?=$row?></td>

                                    <td><a href="#" id="caption" class="inline-edit" data-type="text" data-pk="<?=$video->video_id?>" data-url="<?=ADMIN_URL?>/itineraries/ajax_update_vcaption" data-title="Enter Title"><?=$video->video_title?></a></td></td>
									<td><a href="#" id="<?=$video->video_id?>" class="idelete_video" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>                                </tr>
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