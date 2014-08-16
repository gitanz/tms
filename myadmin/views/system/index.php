<?php
	/**
	 * setting and confiuration page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 13th Dec 2013
	 */
	 
	require_once('views/_templates/sidebar.php');
		
	$timezoneList = timezoneList();
	
	//assign value of submitted or default (general)
	$sitename = isset($_POST['general']) ? $_POST['site_name'] : $this->sitename->variable_value;
	$siteurl = isset($_POST['general']) ? $_POST['site_url'] : $this->siteurl->variable_value;
	$siteemail = isset($_POST['general']) ? $_POST['site_email'] : $this->siteemail->variable_value;
	$sitephone = isset($_POST['general']) ? $_POST['site_phone'] : $this->sitephone->variable_value;
	$sitetz = isset($_POST['general']) ? $_POST['site_timezone'] : $this->sitetz->variable_value;
	$siteoffline = isset($_POST['general']) ? $_POST['site_offline'] : $this->siteoffline->variable_value;
	$siteoffmsg = isset($_POST['general']) ? $_POST['site_offlinemsg'] : $this->siteoffmsg->variable_value;
	$sitelimit = isset($_POST['general']) ? $_POST['site_list_limit'] : $this->sitelimit->variable_value;
	// preference
	$sitetitle = isset($_POST['preference']) ? $_POST['site_title'] : $this->sitetitle->variable_value;
	$sitekeywrds = isset($_POST['preference']) ? $_POST['site_meta_keywords'] : $this->sitekeywrds->variable_value;
	$sitedesc = isset($_POST['preference']) ? $_POST['site_meta_description'] : $this->sitedesc->variable_value;
	$sitecopyright = isset($_POST['preference']) ? $_POST['site_copyright'] : $this->sitecopyright->variable_value;
	// media
	$thumbnail = isset($_POST['media']) ? $_POST['thumbWidth'].'/'.$_POST['thumbHeight'] : $this->sitethumb->variable_value;
	$uploadThumbSize = explode('/', $thumbnail);
	$thumbWidth = empty($uploadThumbSize[0]) ? '150' : $uploadThumbSize[0];
	$thumbHeight = empty($uploadThumbSize[1]) ? '150' : $uploadThumbSize[1];
	$siteuploadsize = isset($_POST['media']) ? $_POST['site_max_upload'] : $this->siteuploadsize->variable_value;
	// preference
	$sitemenuorder = isset($_POST['orderby']) ? $_POST['menu_order'] : $this->sitemenuorder->variable_value;
	$sitemenuorderby = isset($_POST['orderby']) ? $_POST['menu_orderby'] : $this->sitemenuorderby->variable_value;
	$sitepageorder = isset($_POST['orderby']) ? $_POST['page_order'] : $this->sitepageorder->variable_value;
	$sitepageorderby = isset($_POST['orderby']) ? $_POST['page_orderby'] : $this->sitepageorderby->variable_value;
	$sitebannerorder = isset($_POST['orderby']) ? $_POST['banner_order'] : $this->sitebannerorder->variable_value;
	$sitebannerorderby = isset($_POST['orderby']) ? $_POST['banner_orderby'] : $this->sitebannerorderby->variable_value;
	//social
	$sitesocialtitle = isset($_POST['social']) ? $_POST['site_social_title'] : $this->sitesocialtitle->variable_value;
	$sitesociallink = isset($_POST['social']) ? $_POST['site_social_links'][0] : '';
	$sitesocialicon = isset($_POST['social']) ? $_POST['site_social_icons'][0] : '';
	$sitelinksunserialize = unserialize($this->sitesociallinks->variable_value);
	$siteiconsunserialize = unserialize($this->sitesocialicons->variable_value);
	//assoc
    $siteassoctitle = isset($_POST['assoc']) ? $_POST['site_assoc_title'] : $this->siteassoctitle->variable_value;
    $siteassoclink = isset($_POST['assoc']) ? $_POST['site_assoc_links'][0] : '';
    $siteassocicon = isset($_POST['assoc']) ? $_POST['site_assoc_icons'][0] : '';
    $assoclinksunserialize = unserialize($this->siteassoclinks->variable_value);
    $associconsunserialize = unserialize($this->siteassocicons->variable_value);
	//print_r($_POST);
	
?>
		<div class="content">
	        <div class="header">            
	            <h1 class="page-title">Site Settings</h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li class="active">Site Settings &amp; Configuration</li>
            </ul>
            
        	<div class="container-fluid">
            	<div class="row-fluid">
                <?php if (isset($this->errors)) : ?>
                	<div class="alert alert-error">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
						<?php 
                            foreach ($this->errors as $error) : 
                                echo $error.'<br />';
                            endforeach; 
                        ?>
                	</div>
                <?php endif; ?>
	                <div class="well">
    					<ul class="nav nav-tabs">
					    	<!--<li<?=( (!isset($_POST['preference'])) || (!isset($_POST['media'])) || (!isset($_POST['ordering'])) || (!isset($_POST['social'])) ) ? ' class="active"' : '' ?>><a href="#general" data-toggle="tab">General Settings</a></li>-->
                            <li<?=( (!isset($_POST['preference'])) && (!isset($_POST['media'])) && (!isset($_POST['ordering'])) && (!isset($_POST['social'])) ) ? ' class="active"' : '' ?>><a href="#general" data-toggle="tab">General Settings</a></li>
					    	<li<?=isset($_POST['preference']) ? ' class="active"' : '' ?>><a href="#preference" data-toggle="tab">Site Preference</a></li>
	                        <!--<li<?=isset($_POST['media']) ? ' class="active"' : '' ?>><a href="#media" data-toggle="tab">Media</a></li>-->
                            <li<?=isset($_POST['ordering']) ? ' class="active"' : '' ?>><a href="#ordering" data-toggle="tab">Order By</a></li>
                            <li<?=isset($_POST['social']) ? ' class="active"' : '' ?>><a href="#social" data-toggle="tab">Social Links</a></li>
                            <li<?=isset($_POST['assoc']) ? ' class="active"' : '' ?>><a href="#assoc" data-toggle="tab">Association Links</a></li>

                        </ul>
					
                    	<div id="myTabContent" class="tab-content">
      						<div class="tab-pane <?=( (!isset($_POST['preference'])) && (!isset($_POST['media'])) && (!isset($_POST['ordering'])) && (!isset($_POST['social'])) ) ? 'active in"' : 'fade' ?>" id="general">
                            <form id="tab" method="post" action="<?=ADMIN_URL?>/system/save" autocomplete="off">
                                <label>Site Name</label>
                                <input type="text" value="<?php echo stripslashes($sitename); ?>" class="input-xxlarge" required name="site_name" />
                                <label>Site URL</label>
                                <input type="text" value="<?php echo stripslashes($siteurl); ?>" class="input-xxlarge" required name="site_url" />
                                <label>Site Email</label>
                                <input type="email" value="<?php echo stripslashes($siteemail); ?>" class="input-xxlarge" required name="site_email" />
                                <label>Site Phone</label>
                                <input type="text" value="<?php echo stripslashes($sitephone); ?>" class="input-xxlarge" name="site_phone" />
                                
                                <label>Site Post Limit</label>
                                <input type="text" pattern="\d*" name="site_list_limit" min="2" max="100" value="<?php echo stripslashes($sitelimit); ?>" required="required">
                                <label>Time Zone</label>
                                <select name="site_timezone" id="DropDownTimezone" class="input-xxlarge" required>
                                	<option value="">Select Timezone</option>
                                <?php foreach ($timezoneList as $value => $label): ?>
                                	<option value="<?=$value?>" <?php if($value == $sitetz) echo 'selected';?>><?=$label?></option>
                                <?php endforeach; ?>
                                </select>
                                <label>Site Offline</label>
                                <label class="radio inline">
                                    <input type="radio" name="site_offline" id="optionsRadios1" value="Yes" <?php if('Yes' == $siteoffline) echo 'checked';?>> Yes
                                </label>
                                <label class="radio inline">
                                    <input type="radio" name="site_offline" id="optionsRadios2" value="No" <?php if('No' == $siteoffline) echo 'checked';?>> No
                                </label>
                                <label>Site Offline Message</label>
                                <textarea rows="3" class="input-xxlarge" name="site_offlinemsg"><?php echo $siteoffmsg; ?></textarea>
                                <div>
                                    <button class="btn btn-primary" type="submit" autocomplete="off">Update</button>
                                </div>
                                <input type="hidden" value="true" name="general" />
                            </form>
                            </div>
                            <div class="tab-pane <?=isset($_POST['preference']) ? 'active in"' : 'fade' ?>" id="preference">
                            	<form id="tab1" method="post" action="<?=ADMIN_URL?>/system/save" autocomplete="off">
                                    <label>Site Title</label>
                                    <input type="text" value="<?php echo stripslashes($sitetitle); ?>" class="input-xxlarge" name="site_title" required="required" />
                                    <label>Site Meta Keywords</label>
                                    <input type="text" value="<?php echo stripslashes($sitekeywrds); ?>" class="input-xxlarge" name="site_meta_keywords" />
                                    <label>Site Meta Description</label>
                                    <input type="text" value="<?php echo stripslashes($sitedesc); ?>" class="input-xxlarge" name="site_meta_description" />
                                    <label>Site Copyright</label>
                                    <input type="text" value="<?php echo stripslashes($sitecopyright); ?>" class="input-xxlarge" name="site_copyright" required="required" />
                                    <div>
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                    <input type="hidden" value="true" name="preference" />
                                </form>
                            </div>
                            <!--<div class="tab-pane <?=isset($_POST['media']) ? 'active in"' : 'fade' ?>" id="media">
                            	<form id="tab2" method="post" action="<?=ADMIN_URL?>/system/save" autocomplete="off">
                                	<label>Thumbnail Size</label>
                                    <label class="inline">
                                    	<input type="text" value="<?=$thumbWidth?>" name="thumbWidth" id="optionsRadios1" class="input-mini" /> Width
                                    </label>
                                    <label class="inline">
                                        <input type="text" value="<?=$thumbHeight?>" name="thumbHeight" id="optionsRadios2" class="input-mini" /> Height
                                    </label>
                                    <label>Upload Limit Size</label>
                                    <div class="input-append">
										<input class="span1" value="<?=$siteuploadsize; ?>" id="appendedInput" type="text" name="site_max_upload" />
										<span class="add-on">MB</span>
									</div>
                                    <div>
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                    <input type="hidden" value="true" name="media" />
                                </form>
                          	</div>-->
                            <div class="tab-pane <?=isset($_POST['ordering']) ? 'active in"' : 'fade' ?>" id="ordering">
                                <form id="tab3" method="post" action="<?=ADMIN_URL?>/system/save" autocomplete="off">
                                	<small>Select Order Type:</small>
                                    <label>Menu</label>
                                    <label class="select inline">
                                    	<select class="input-medium inline" name="site_menu_order">
                                        	<option value="order" <?php if($sitemenuorder == 'order') echo 'selected'; ?>>Order</option>
                                            <option value="added_date" <?php if($sitemenuorder == 'added_date') echo 'selected'; ?>>Added Date</option>
                                        </select>
                                    	By
                                        <select class="input-medium inline" name="site_menu_orderby">
                                        	<option value="asc" <?php if($sitemenuorderby == 'asc') echo 'selected'; ?>>Acending</option>
                                            <option value="desc" <?php if($sitemenuorderby == 'desc') echo 'selected'; ?>>Descending</option>
                                        </select>
                                    </label>
                                    <label>Pages</label>
                                    <label class="inline">
                                    	<select class="input-medium" name="site_page_order">
                                        	<option value="order" <?php if($sitepageorder == 'order') echo 'selected'; ?>>Order</option>
                                            <option value="added_date" <?php if($sitepageorder == 'added_date') echo 'selected'; ?>>Added Date</option>
                                        </select>
                                    	By
                                        <select class="input-medium" name="site_page_orderby">
                                        	<option value="asc" <?php if($sitepageorderby == 'asc') echo 'selected'; ?>>Acending</option>
                                            <option value="desc" <?php if($sitepageorderby == 'desc') echo 'selected'; ?>>Descending</option>
                                        </select>
                                    </label>
                                    <label>Banners</label>
                                    <label class="inline">
                                    	<select class="input-medium" name="site_banner_order">
                                        	<option value="order" <?php if($sitebannerorder == 'order') echo 'selected'; ?>>Order</option>
                                            <option value="added_date" <?php if($sitebannerorder == 'added_date') echo 'selected'; ?>>Added Date</option>
                                        </select>
                                    	By
                                        <select class="input-medium" name="site_banner_orderby">
                                        	<option value="asc" <?php if($sitebannerorderby == 'asc') echo 'selected'; ?>>Acending</option>
                                            <option value="desc" <?php if($sitebannerorderby == 'desc') echo 'selected'; ?>>Descending</option>
                                        </select>
                                    </label>
                                    <div>
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                    <input type="hidden" value="true" name="ordering" />
                                </form>
                            </div>
                            <div class="tab-pane <?=isset($_POST['social']) ? 'active in"' : 'fade' ?>" id="social">
                            	<form id="tab4" method="post" action="<?=ADMIN_URL?>/system/save" autocomplete="off">
                                	<label>Social Title</label>
                                    <input type="text" value="<?php echo stripslashes($sitesocialtitle); ?>" class="input-xxlarge" name="site_social_title" required="required" />
                                    <div class="control-group" id="fields">
                                    <?php
										for ( $i = 0; $i < count($sitelinksunserialize); $i++):
											if ( (filter_var($sitelinksunserialize[$i], FILTER_SANITIZE_URL)) ) :
												$num = rand(100, 200)
									?>
                                    	<div class="controls-field" id="b1">
                                            <label>Social Link</label>
                                            <input type="url" pattern="https?://.+" name="site_social_links[]" value="<?=$sitelinksunserialize[$i]?>" class="input-xxlarge" placeholder="Enter social URL." />
                                            <label class="control-label" for="socialImg1">Social Icon</label>
                                            <div class="input-append">
                                            <input type="text" value="<?=$siteiconsunserialize[$i]?>" id="socialImg<?=$num?>" name="site_social_icons[]" class="input-xxlarge" placeholder="Select social icon" />
                                            <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=socialImg<?=$num?>">Select</a>
                                            </div>
                                        </div>
                                        <?php if (is_file( '../'.View::attachmentPathCorrect($siteiconsunserialize[$i]) )) : ?>
                                        <div class="block-body">
	                                        <img class="img-polaroid" src="<?=View::attachmentFullPathCorrect($siteiconsunserialize[$i])?>">
                                            <div class="clearfix"></div>
                                        </div>
                                        <?php endif; ?>
                                    <?php
											endif;
										endfor;
									?>
                                        <div class="controls-field" id="b1">
                                            <label>Social Link 1</label>
                                            <input type="url" pattern="https?://.+" name="site_social_links[]" value="<?=$sitesociallink?>" class="input-xxlarge" placeholder="Enter social URL." />
                                            <label class="control-label" for="socialImg1">Social Icon 1</label>
                                            <div class="input-append">
                                            <input type="text" value="<?=$sitesocialicon?>" id="socialImg1" name="site_social_icons[]" class="input-xxlarge" placeholder="Select social icon" />
                                            <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=socialImg1">Select</a><button id="b1" class="btn btn-info add-more-social" type="button">+</button>
                                            </div>
                                        </div>
                                        <small>For better image resolution, Image size should be 32x32 px</small>
                                    </div>
	                                <div>
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                    <input type="hidden" value="true" name="social" />
                                </form>
                            </div> 
                            <!-- associations -->
                            <div class="tab-pane <?=isset($_POST['assoc']) ? 'active in"' : 'fade' ?>" id="assoc">
                                <form id="tab4" method="post" action="<?=ADMIN_URL?>/system/save" autocomplete="off">
                                    <label>Association Title</label>
                                    <input type="text" value="<?php echo stripslashes($siteassoctitle); ?>" class="input-xxlarge" name="site_assoc_title" required="required" />
                                    <div class="control-group" id="fields">
                                    <?php
                                        for ( $i = 0; $i < count($assoclinksunserialize); $i++):
                                            if ( (filter_var($assoclinksunserialize[$i], FILTER_SANITIZE_URL)) ) :
                                                $num = rand(100, 200)
                                    ?>
                                        <div class="controls-field" id="b1">
                                            <label>Association Link</label>
                                            <input type="url" pattern="https?://.+" name="site_assoc_links[]" value="<?=$assoclinksunserialize[$i]?>" class="input-xxlarge" placeholder="Enter associaton URL." />
                                            <label class="control-label" for="assocImg1">Association Icon</label>
                                            <div class="input-append">
                                            <input type="text" value="<?=$associconsunserialize[$i]?>" id="assocImg<?=$num?>" name="site_assoc_icons[]" class="input-xxlarge" placeholder="Select assoc icon" />
                                            <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=assocImg<?=$num?>">Select</a>
                                            </div>
                                        </div>
                                        <?php if (is_file( '../'.View::attachmentPathCorrect($associconsunserialize[$i]) )) : ?>
                                        <div class="block-body">
                                            <img class="img-polaroid" src="<?=View::attachmentFullPathCorrect($associconsunserialize[$i])?>">
                                            <div class="clearfix"></div>
                                        </div>
                                        <?php endif; ?>
                                    <?php
                                            endif;
                                        endfor;
                                    ?>
                                        <div class="controls-field" id="b1">
                                            <label>Association Link 1</label>
                                            <input type="url" pattern="https?://.+" name="site_assoc_links[]" value="<?=$siteassoclink?>" class="input-xxlarge" placeholder="Enter association URL." />
                                            <label class="control-label" for="assocImg1">Association Icon 1</label>
                                            <div class="input-append">
                                            <input type="text" value="<?=$siteassocicon?>" id="assocImg1" name="site_assoc_icons[]" class="input-xxlarge" placeholder="Select association icon" />
                                            <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=assocImg1">Select</a><button id="b1" class="btn btn-info add-more-assoc" type="button">+</button>
                                            </div>
                                        </div>
                                        <small>For better image resolution, Image size should be ?x? px</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                    <input type="hidden" value="true" name="assoc" />
                                </form>
                            </div>                           
						</div> <!-- .tab-content -->
					</div> <!-- .well -->
				</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->