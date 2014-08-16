<?php

	/**
	 * Publication form for add/edit
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 24th Dec 2013
	 */
	 
	require_once('views/_templates/sidebar.php');
	 
	if ($this->new_form == 1 || empty( $_POST['news_id'] )):
		$newsTitle = isset($_POST['news_id']) ? $_POST['news_title'] : "";
		$newsAlias = isset($_POST['news_id']) ? $_POST['news_alias'] : "";
		$newsImg = isset($_POST['news_image']) ? $_POST['news_image'] : "";
		$newsFile = isset($_POST['news_file']) ? $_POST['news_file'] : "";
		$newsDate = isset($_POST['news_date']) ? $_POST['news_date'] : "";
		$newsStatus = isset($_POST['news_id']) ? $_POST['news_status'] : "1";
		$newsType = isset($_POST['news_id']) ? $_POST['news_type'] : "0";
		$newsAdded = isset($_POST['news_added']) ? $_POST['news_added'] : $this->datetime;
		$newsContent = isset($_POST['news_content']) ? $_POST['news_content'] : "";
		$newsId = "";
		$newsTitles = 'Create news';
	endif;
	
	if ($this->new_form == '' || !empty( $_POST['news_id'] )):
		$newsTitle = isset($_POST['news_id']) ? $_POST['news_title'] : $this->news->news_title;
	// dd($this->news->news_date);
		$newsDate = isset($_POST['news_date']) ? $_POST['news_date'] : date('Y-m-d H:i:s', $this->news->news_date);
		$newsAlias = isset($_POST['news_id']) ? $_POST['news_alias'] : $this->news->news_alias;
		$newsImg = isset($_POST['news_image']) ? $_POST['news_image'] : $this->news->news_image;
		$newsFile = isset($_POST['news_file']) ? $_POST['news_file'] : $this->news->news_file;
		$newstatus = isset($_POST['news_id']) ? $_POST['news_status'] : $this->news->news_status;
		$newsType = isset($_POST['news_type']) ? $_POST['news_type'] : $this->news->news_type;
		$newsAdded = isset($_POST['news_datetime']) ? $_POST['news_datetime'] : $this->datetime;
		$newsContent = isset($_POST['news_content']) ? $_POST['news_content'] :$this->news->news_content;
		$newsId = isset($_POST['news_id']) ? $_POST['news_id'] : $this->news->news_id;		
		$newsTitles = 'Update news';
	endif;
	//var_dump($this->page);
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title"><?=$newsTitles?></h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/news/lists">News</a> <span class="divider">/</span></li>
                <li class="active"><?=$newsTitles?></li>
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
				    <form id="newsForm" action="<?=ADMIN_URL?>/news/save" method="post" autocomplete="off">
				        <div class = "span6">	
				        <label>Title *</label>
				        <input type="text" name="news_title" value="<?=$newsTitle?>" class="input-xlarge" placeholder="Enter title here" />
				        <label>Alias</label>
				        <input type="text" name="news_alias" value="<?=$newsAlias?>" class="input-xlarge" placeholder="Auto generated from title"  id="disabledInput" />
						<label>Date *</label>
				        <input type="text" name="news_date" value="<?=$newsDate?>" class="input-xlarge" id = "datetime"placeholder="Enter title here" />
                        <label>Image</label>
				        <div class="input-append">
	    					<input type="text" value="<?=$newsImg?>" id="newsImg" name="news_image" class="input-xlarge" />
						    <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=newsImg">Select</a>
						</div>
                        <?php if (is_file( '../'.View::attachmentPathCorrect($newsImg) )) : ?>
                        <div class="block-body">
			                <a href="<?=View::attachmentFullPathCorrect($newsImg)?>" class="iframe-btn">
								<img class="img-polaroid" src="<?=View::attachmentThumbPathCorrect($newsImg)?>">
                            </a>
				            <div class="clearfix"></div>
				        </div>
                        <?php endif; ?>
                        <label>File</label>
                        <div class="input-append">
	    					<input type="text" value="<?=$newsFile?>" id="newsFile" name="news_file" class="input-xlarge" />
						    <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=2&amp;field_id=newsFile">Select</a>
						</div>
                        
						<label>Type</label>
				        <select name="news_type" id="newsType" class="input-small span4">
                            <option value="0"<?=$newsType == '0' ? ' selected' : '' ?>>News</option>
                        	<option value="1"<?=$newsType == '1' ? ' selected' : '' ?>>Announcement</option>
                            <option value="2"<?=$newsType == '2' ? ' selected' : '' ?>>Notices</option>
                            <option value="3"<?=$newsType == '3' ? ' selected' : '' ?>>Upcomming Events</option>

                        </select>

                        <label>Publish</label>
				        <select name="news_status" id="newsStatus" class="input-small">
                        	<option value="1"<?=$newsStatus == '1' ? ' selected' : '' ?>>Yes</option>
                            <option value="0"<?=$newsStatus == '0' ? ' selected' : '' ?>>No</option>
                        </select>
                        <label>Date</label>
				        <input type="text" name="news_added" value="<?=$newsAdded?>" class="input-xlarge" id="datetime" />
				        </div>
				        <div class="span6">
                        <label>Content</label>
				        <textarea rows="3" class="input-xxlarge" name="news_content" id="tinyEditor"><?=stripslashes($newsContent)?></textarea>
                        <hr />
                        </div>
                        <div>
                       		<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
                        </div>
                        <input type="hidden" name="news_id" value="<?=$newsId?>" />
                        <input type="hidden" name="form" value="<?=$this->new_form?>" />
				    </form>
					</div>
               	</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->