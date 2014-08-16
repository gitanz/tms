<?php
	/**
	 * banner form for add/edit
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 31th Dec 2013
	 */
	 
	require_once('views/_templates/sidebar.php');
	
	if ($this->new_form == 1 || empty( $_POST['banner_id'] )):
		$bannerStatus = isset($_POST['banner_id']) ? $_POST['banner_status'] : "1";
		$bannerId = "";
		$pageTitles = 'Create Banner';
		$showNew = true;
	endif;
	
	if ($this->new_form == '' || !empty( $_POST['banner_id'] )):
		$bannerTitle = isset($_POST['banner_title']) ? $_POST['banner_title'][0] : $this->banner->bnr_title; 
		$bannerImg = isset($_POST['banner_image']) ? $_POST['banner_image'][0] : $this->banner->bnr_imgpath; 
		$bannerId = isset($_POST['banner_id']) ? $_POST['banner_id'] : $this->banner->bnr_id;
		$bannerStatus = isset($_POST['banner_id']) ? $_POST['banner_status'] : $this->banner->bnr_status;
		$bannerOrder = isset($_POST['banner_order']) ? $_POST['banner_order'] : $this->banner->bnr_order;
		$pageTitles = 'Update Banner';
		$showNew = false;
	endif;
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title"><?=$pageTitles?></h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/banners/lists">Banners</a> <span class="divider">/</span></li>
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
				    <form id="pageForm" action="<?=ADMIN_URL?>/banners/save" method="post" autocomplete="off">
                    <?php if ( $showNew == true): ?>
				        <div class="control-group" id="fields">                        	
                            <div class="controls-field" id="b1">
                            	<label>Banner Title 1</label>
						        <input type="text" name="banner_title[]" value="" class="input-xlarge" placeholder="Enter banner title here" />
	                            <label class="control-label" for="bannerImg1">Image 1</label>
                            	<div class="input-append">
	    						<input type="text" value="" id="bannerImg1" name="banner_image[]" class="input-xlarge" placeholder="Select image" />
						    	<a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=bannerImg1">Select</a><button id="b1" class="btn btn-info add-more" type="button">+</button>
								</div>
                            </div>
                            <small>For better image resolution, Image size should be 1920x898 px</small>
                        </div>
				        <label>Parent Item</label>
				        <select name="banner_parent" id="banner_parent">
                        	<option value="0">Site Banner</option>
                            <?=$this->adjacency?>
                        </select>				        
                        <label>Publish</label>
				        <select name="banner_status" id="banner_status" class="input-small">
                        	<option value="1"<?=$bannerStatus == '1' ? ' selected' : '' ?>>Yes</option>
                            <option value="0"<?=$bannerStatus == '0' ? ' selected' : '' ?>>No</option>
                        </select>
                        <hr />
                        <div>
                       		<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
                        </div>
                        <input type="hidden" name="banner_id" value="<?=$bannerId?>" />
                        <input type="hidden" name="form" value="<?=$this->new_form?>" />
                    <?php endif; ?>
                    <?php if ( $showNew == false): ?>                  	
                       	<label>Banner Title</label>
				        <input type="text" name="banner_title[]" value="<?=$bannerTitle?>" class="input-xlarge" placeholder="Enter banner title here" />
                        <label class="control-label" for="bannerImg1">Image </label>
                       	<div class="input-append">
  						<input type="text" value="<?=$bannerImg?>" id="bannerImg1" name="banner_image[]" class="input-xlarge" placeholder="Select image" />
				    	<a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=bannerImg1">Select</a>
						</div>
                        <?php if (is_file( '../'.View::attachmentPathCorrect($bannerImg) )) : ?>
                        <div class="block-body">
			                <a href="<?=View::attachmentFullPathCorrect($bannerImg)?>" class="iframe-btn">
								<img class="img-polaroid" src="<?=View::attachmentThumbPathCorrect($bannerImg)?>">
                            </a>
				            <div class="clearfix"></div>
				        </div>
                        <?php endif; ?>
                        <small>For better image resolution, Image size should be 1920x898 px</small>                        
				        <label>Parent Item</label>
				        <select name="banner_parent" id="banner_parent">
                        	<option value="0">Site Banner</option>
                            <?=$this->adjacency?>
                        </select>				        
                        <label>Publish</label>
				        <select name="banner_status" id="banner_status" class="input-small">
                        	<option value="1"<?=$bannerStatus == '1' ? ' selected' : '' ?>>Yes</option>
                            <option value="0"<?=$bannerStatus == '0' ? ' selected' : '' ?>>No</option>
                        </select>
                        <hr />
                        <div>
                       		<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
                        </div>
                        <input type="hidden" name="banner_id" value="<?=$bannerId?>" />
                        <input type="hidden" name="form" value="<?=$this->new_form?>" />
                        <input type="hidden" name="banner_order" value="<?=$bannerOrder?>" />
                    <?php endif; ?>
				    </form>
					</div>
               	</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->	