<?php
	/**
	 * page form for add/edit
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 24th Dec 2013
	 */
	 
	require_once('views/_templates/sidebar.php');
	 
	if ($this->new_form == 1 || empty( $_POST['page_id'] )):
		$pageTitle = isset($_POST['page_id']) ? $_POST['page_title'] : "";
		$pageAlias = isset($_POST['page_id']) ? $_POST['page_alias'] : "";
		$pageImg = isset($_POST['page_image']) ? $_POST['page_image'] : "";
		$pageFile = isset($_POST['page_file']) ? $_POST['page_file'] : "";
		$pageInclude = isset($_POST['page_include']) ? $_POST['page_include'] : "";
		$pageStatus = isset($_POST['page_id']) ? $_POST['page_status'] : "1";
		$pageHome = isset($_POST['page_id']) ? $_POST['page_home'] : "0";
		$pageDate = isset($_POST['page_datetime']) ? $_POST['page_datetime'] : $this->datetime;
		$pageContent = isset($_POST['page_content']) ? $_POST['page_content'] : "";
		$pageOrder = isset($_POST['page_order']) ? $_POST['page_order'] : $this->order;
		$pageId = "";
		$pageTitles = 'Create Page';
	endif;
	
	if ($this->new_form == '' || !empty( $_POST['page_id'] )):
		$pageTitle = isset($_POST['page_id']) ? $_POST['page_title'] : $this->page->page_title;
		$pageAlias = isset($_POST['page_id']) ? $_POST['page_alias'] : $this->page->page_alias;
		$pageImg = isset($_POST['page_image']) ? $_POST['page_image'] : $this->page->page_image;
		$pageInclude = isset($_POST['page_include']) ? $_POST['page_include'] : $this->page->page_include;
		$pageFile = isset($_POST['page_file']) ? $_POST['page_file'] : $this->page->page_file;
		$pageStatus = isset($_POST['page_id']) ? $_POST['page_status'] : $this->page->page_status;
		$pageHome = isset($_POST['page_id']) ? $_POST['page_home'] : $this->page->page_home;
		$pageDate = isset($_POST['page_datetime']) ? $_POST['page_datetime'] : $this->datetime;
		$pageContent = isset($_POST['page_content']) ? $_POST['page_content'] :$this->page->page_content;
		$pageOrder = isset($_POST['page_order']) ? $_POST['page_order'] : $this->page->page_order;
		$pageId = isset($_POST['page_id']) ? $_POST['page_id'] : $this->page->page_id;		
		$pageTitles = 'Update Page';
	endif;
	//var_dump($this->page);
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title"><?=$pageTitles?></h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/pages/lists">Pages</a> <span class="divider">/</span></li>
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
				    <form id="pageForm" action="<?=ADMIN_URL?>/pages/save" method="post" autocomplete="off">
				        <label>Page Title *</label>
				        <input type="text" name="page_title" value="<?=$pageTitle?>" class="input-xlarge" placeholder="Enter page title here" />
				        <label>Alias</label>
				        <input type="text" name="page_alias" value="<?=$pageAlias?>" class="input-xlarge" placeholder="Auto generated from title"  id="disabledInput" />
				        <label>Parent Item</label>
				        <select name="page_parent" id="page_parent">
                        	<option value="0">Page Item Root</option>
                            <?=$this->adjacency?>
                        </select>                        
                        <label>Image</label>
				        <div class="input-append">
	    					<input type="text" value="<?=$pageImg?>" id="pageImg" name="page_image" class="input-xlarge" />
						    <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=pageImg">Select</a>
						</div>
                        <?php if (is_file( '../'.View::attachmentPathCorrect($pageImg) )) : ?>
                        <div class="block-body">
			                <a href="<?=View::attachmentFullPathCorrect($pageImg)?>" class="iframe-btn">
								<img class="img-polaroid" src="<?=View::attachmentThumbPathCorrect($pageImg)?>">
                            </a>
				            <div class="clearfix"></div>
				        </div>
                        <?php endif; ?>
                        <label>File</label>
                        <div class="input-append">
	    					<input type="text" value="<?=$pageFile?>" id="pageFile" name="page_file" class="input-xlarge" />
						    <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=2&amp;field_id=pageFile">Select</a>
						</div>
						<label>Include</label>
				        <select name="page_include" id="page_include" class="input-small">
                            <option value="0"<?=$pageInclude == '0' ? ' selected' : '' ?>>Nothing</option>
                        	<option value="1"<?=$pageInclude == '1' ? ' selected' : '' ?>>Contact Us form</option>
                        	<option value="2"<?=$pageInclude == '2' ? ' selected' : '' ?>>Booking Form</option>
                        </select>
                        <label>Display in Homepage</label>
				        <select name="page_home" id="page_home" class="input-small">
                        	<option value="1"<?=$pageHome == '1' ? ' selected' : '' ?>>Yes</option>
                            <option value="0"<?=$pageHome == '0' ? ' selected' : '' ?>>No</option>
                        </select>
                        <label>Publish</label>
				        <select name="page_status" id="page_status" class="input-small">
                        	<option value="1"<?=$pageStatus == '1' ? ' selected' : '' ?>>Yes</option>
                            <option value="0"<?=$pageStatus == '0' ? ' selected' : '' ?>>No</option>
                        </select>
                        <label>Display Order</label>
				        <input type="text" name="page_order" value="<?=$pageOrder?>" class="input-xlarge" />
                        <label>Date</label>
				        <input type="text" name="page_datetime" value="<?=$pageDate?>" class="input-xlarge" id="datetime" />
                        <label>Content</label>
				        <textarea rows="3" class="input-xxlarge" name="page_content" id="tinyEditor"><?=stripslashes($pageContent)?></textarea>
                        <hr />
                        <div>
                       		<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
                        </div>
                        <input type="hidden" name="page_id" value="<?=$pageId?>" />
                        <input type="hidden" name="form" value="<?=$this->new_form?>" />
				    </form>
					</div>
               	</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->