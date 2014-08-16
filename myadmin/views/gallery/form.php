<?php
	/**
	 * gallery form for add/edit
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 31th Dec 2013
	 */
	 
	require_once('views/_templates/sidebar.php');
	
	if ($this->new_form == 1 || empty( $_POST['banner_id'] )):
		$galleryTitle = isset($_POST['gallery_title']) ? $_POST['gallery_title'] : '';
		$galleryAlias = isset($_POST['page_id']) ? $_POST['gallery_alias'] : "";
		$galleryStatus = isset($_POST['gallery_id']) ? $_POST['gallery_status'] : "1";
		$galleryId = "";
		$pageTitles = 'Create Gallery';
	endif;
	
	if ($this->new_form == '' || !empty( $_POST['banner_id'] )):
		$galleryTitle = isset($_POST['gallery_title']) ? $_POST['gallery_title'] : $this->gallery->gly_title;	
		$galleryAlias = isset($_POST['gallery_alias']) ? $_POST['gallery_alias'] : $this->gallery->gly_alias;	
		$galleryId = isset($_POST['gallery_id']) ? $_POST['gallery_id'] : $this->gallery->gly_id;
		$galleryStatus = isset($_POST['gallery_id']) ? $_POST['gallery_status'] : $this->gallery->gly_status;
		$pageTitles = 'Update Gallery';
	endif;
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title"><?=$pageTitles?></h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/gallery/lists">Gallery</a> <span class="divider">/</span></li>
                <li class="active"><?=$pageTitles?></li>
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
        	            <div class="span6">
				            <div class="block-body">
                				<form id="pageForm" action="<?=ADMIN_URL?>/gallery/save" method="post" autocomplete="off">
		                    	<label>Gallery Category</label>
						        <input type="text" name="gallery_title" value="<?=$galleryTitle?>" class="input-xlarge" placeholder="Enter gallery title here" />
                                <label>Alias</label>
						        <input type="text" name="gallery_alias" value="<?=$galleryAlias?>" class="input-xlarge" placeholder="Auto generated from title" />
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
						        <label>Parent Item</label>
						        <select name="gallery_parent" id="gallery_parent">
                		            <?=$this->adjacency?>
                        		</select>				        
		                        <label>Publish</label>
						        <select name="gallery_status" id="gallery_status" class="input-small">
                		        	<option value="1"<?=$galleryStatus == '1' ? ' selected' : '' ?>>Yes</option>
                        		    <option value="0"<?=$galleryStatus == '0' ? ' selected' : '' ?>>No</option>
		                        </select>
        		                <hr />
                		        <div>
                       				<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
		                        </div>
        		                <input type="hidden" name="gallery_id" value="<?=$galleryId?>" />
                		        <input type="hidden" name="form" value="<?=$this->new_form?>" />
							    </form>
				                <div class="clearfix"></div>
            				</div>
			        	</div>
                        <?php if($this->new_form == false): ?>
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
                                    	<a href="<?=View::attachmentFullPathCorrect($image->gly_path)?>" class="iframe-btn" title="<?=$image->gly_title?>">
		                                <img class="img-polaroid" src="<?=View::attachmentThumbPathCorrect($image->gly_path)?>">
        		                        </a>
                                    </td>
                                    <td><a href="#" id="caption" class="inline-edit" data-type="text" data-pk="<?=$image->gly_id?>" data-url="<?=ADMIN_URL?>/gallery/ajax_update_caption" data-title="Enter caption"><?=$image->gly_title?></a></td></td>
                                    <td><a href="#" id="<?=$image->gly_id?>" class="delete_image" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>
                                </tr>
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