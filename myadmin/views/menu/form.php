<?php
	/**
	 * menu form for add/edit
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 17th Dec 2013
	 */
	 
	require_once('views/_templates/sidebar.php');
	 
	if ($this->new_form == 1 || empty( $_POST['menu_id'] )):
		$menuTitle = isset($_POST['menu_id']) ? $_POST['menu_title'] : "";

		$menuOnTab = isset($_POST['menu_id']) ? $_POST['ontabs'] : "No";
		$menuAltName = isset($_POST['menu_id']) ? $_POST['altname'] : "";
		$menuImg = isset($_POST['menu_image']) ? $_POST['menu_image'] : "";
		$menuAlias = isset($_POST['menu_id']) ? $_POST['menu_alias'] : "";
		$menuType = isset($_POST['menu_id']) ? $_POST['menu_type'] : "";
		$menuURL = isset($_POST['menu_id']) ? $_POST['menu_url'] : "";
		$menuDestination = isset($_POST['menu_id']) ? $_POST['menu_destination'] : "0";
		$menuIti = isset($_POST['menu_id']) ? $_POST['menu_itinerary'] : "0";
		$menuInclude = isset($_POST['menu_id']) ? $_POST['menu_destination'] : "0";
		$menuTempType = isset($_POST['menu_temp_type']) ? $_POST['menu_temp_type'] : "default";
		$menuStatus = isset($_POST['menu_id']) ? $_POST['menu_status'] : "1";
		$menuStatus = isset($_POST['menu_id']) ? $_POST['menu_status'] : "1";
		$menuLoc = isset($_POST['menu_location']) ? unserialize(serialize($_POST['menu_location'])) : "";
		$menuOrder = isset($_POST['menu_order']) ? $_POST['menu_order'] : "";
		$menuId = "";
		$pageTitle = 'Create Menu';
		$formAction = 'save';
	endif;
	
	if ($this->new_form == '' || !empty( $_POST['menu_id'] )):
		$menuTitle = isset($_POST['menu_id']) ? $_POST['menu_title'] : $this->menu->nav_title;

		$menuOnTab = isset($_POST['menu_id']) ? $_POST['ontabs'] : $this->menu->nav_ontabs;
		$menuAltName = isset($_POST['menu_id']) ? $_POST['altname'] : $this->menu->nav_altname;
	
		$menuImg = isset($_POST['menu_image']) ? $_POST['menu_image'] : $this->menu->nav_image;
		$menuAlias = isset($_POST['menu_id']) ? $_POST['menu_alias'] : $this->menu->nav_alias;
		$menuType = isset($_POST['menu_id']) ? $_POST['menu_type'] : $this->menu->nav_type;
		$menuURL = isset($_POST['menu_id']) ? $_POST['menu_url'] : $this->menu->nav_url;
		$menuDestination = isset($_POST['menu_id']) ? $_POST['menu_destination'] : $this->menu->nav_destination;
		$menuIti = isset($_POST['menu_id']) ? $_POST['menu_itinerary'] : $this->menu->nav_itinerary;
		$menuInclude = isset($_POST['menu_id']) ? $_POST['menu_destination'] : $this->menu->nav_include;
		$menuTempType = isset($_POST['menu_temp_type']) ? $_POST['menu_temp_type'] : $this->menu->nav_tpl;
		$menuStatus = isset($_POST['menu_id']) ? $_POST['menu_status'] : $this->menu->nav_status;
		$menuLoc = isset($_POST['menu_id']) ? unserialize(serialize($_POST['menu_location'])) : unserialize($this->menu->nav_location);
		$menuId = isset($_POST['menu_id']) ? $_POST['menu_id'] : $this->menu->nav_id;
		$menuOrder = isset($_POST['menu_order']) ? $_POST['menu_order'] : $this->menu->nav_order;
		$pageTitle = 'Update Menu';
		$formAction = 'editSave';
	endif;
	//var_dump($this->menu);
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title"><?=$pageTitle?></h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/menu/lists">Menu</a> <span class="divider">/</span></li>
                <li class="active"><?=$pageTitle?></li>
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
				    <form id="menuForm" action="<?=ADMIN_URL?>/menu/save" method="post" autocomplete="off">
				        <label>Menu Title *</label>
				        <input type="text" name="menu_title" value="<?=$menuTitle?>" class="input-xlarge" placeholder="Enter menu title here" />
				        <label>Alias</label>
				        <input type="text" name="menu_alias" value="<?=$menuAlias?>" class="input-xlarge" placeholder="Auto generated from title"  id="disabledInput" />
				        <label>Parent Item</label>
				        <select name="menu_parent" id="menu_parent">
                        	<option value="0">Menu Item Root</option>
                            <?=$this->adjacency?>
                        </select>
					    
                        <label>Itinerary Root Menu</label>
					    <input type="radio" class = "styledradio" id="radio1" name="menu_itinerary" value="1" <?php echo $menuIti == '1'?"checked":""?>>
					    <label for="radio1">Yes</label>
					    <input type="radio" class = "styledradio" id="radio2" name="menu_itinerary" value="0" <?php echo $menuIti == '0'?"checked":""?>>
					    <label for="radio2">No</label><br>
                        <span style = "font-size:10px;font-style:italic">Select yes if menu is to be set as Itinerary Root Menu(eg, Expeditions, PeakClimbing, Trekking, Cultural Tours) </span>

                        <div id = "ifItinerary" style = "margin:10px 0 10px 0;display:none;">
							<label class="checkbox inline">
								<input type="checkbox" id="homechecked" name="ontabs" value = "<?=$menuOnTab?>" <?php if($menuOnTab == 'Yes') echo 'checked';?>> Show on Homepage Tabs
						    </label>
						    <div id = "altNameforTab" style = "margin-top:10px 0 10px 0;display:none;">
						    	<label>Alternative Name</label>
				        		<input type="text" name="altname" value="<?=$menuAltName?>" class="input-xlarge" placeholder="Enter alternative title here" />
						    </div>                        
					    </div>
					    
					    <label>Destination Menu</label>
					    <input type="radio" class = "styledradio" id="radio3" name="menu_destination" value="1" <?php echo $menuDestination == '1'?"checked":""?>>
					    <label for="radio3">Yes</label>
					    <input type="radio" class = "styledradio" id="radio4" name="menu_destination"value="0" <?php echo $menuDestination == '0'?"checked":""?>>
					    <label for="radio4">No</label><br>
                        <span style = "font-size:10px;font-style:italic">Select yes if menu is to be set as Destination Country </span>

						<label>Image</label>
				        <div class="input-append">
	    					<input type="text" value="<?=$menuImg?>" id="menuImg" name="menu_image" class="input-xlarge" />
						    <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=menuImg">Select</a>
						</div>
                        <?php if (is_file( '../'.View::attachmentPathCorrect($menuImg) )) : ?>
                        <div class="block-body">
			                <a href="<?=View::attachmentFullPathCorrect($menuImg)?>" class="iframe-btn">
								<img class="img-polaroid" src="<?=View::attachmentThumbPathCorrect($menuImg)?>">
                            </a>
				            <div class="clearfix"></div>
				        </div>
                        <?php endif; ?>                        

                        <label>Menu Item Type *</label>
						<select name="menu_type" id="menu_type">
                        	<option value="">Menu Content Type</option>
                            <option value="custom"<?=$menuType == 'custom' ? ' selected' : '' ?>>Custom Link</option>
                            <option value="page"<?=$menuType == 'page' ? ' selected' : '' ?>>Single Page</option>
                            <option value="post"<?=$menuType == 'post' ? ' selected' : '' ?>>Multiple Page</option>
                        </select>
                        <label>URL</label>
				        <input type="text" name="menu_url" value="<?=$menuURL?>" class="input-xlarge" placeholder="Enter only if you select custom item type" />
                        <label>Template Type</label>
						<select name="menu_temp_type" id="menu_temp_type">
                            <option value="default"<?=$menuTempType == 'default' ? ' selected' : '' ?>>Default Template</option>
                            <option value="gallery"<?=$menuTempType == 'gallery' ? ' selected' : '' ?>>Gallery Template</option>
                            <option value="itinerary"<?=$menuTempType == 'itinerary' ? ' selected' : '' ?>>Itinerary Template</option>
                            <option value="news"<?=$menuTempType == 'news' ? ' selected' : '' ?>>News Template</option>
                            <option value="testimonials"<?=$menuTempType == 'testimonials' ? ' selected' : '' ?>>Testimonial Template</option>
                            <option value="sitemap"<?=$menuTempType == 'sitemap' ? ' selected' : '' ?>>Sitemap Template</option>
                            <option value="planatrip"<?=$menuTempType == 'planatrip' ? ' selected' : '' ?>>Plan a Trip Template</option>

                        </select>
                        <label>Menu Location</label>
                        <label class="checkbox inline">
							<input type="checkbox" id="inlineCheckbox1" name="menu_location[]" value="Main" <?php if (@in_array("Main", $menuLoc)) echo "checked"; ?>> Main Menu
					    </label>
					    <label class="checkbox inline">
						    <input type="checkbox" id="inlineCheckbox3" name="menu_location[]" value="Header" <?php if (@in_array("Header", $menuLoc)) echo "checked"; ?>> Header Menu
					    </label>
					    <label class="checkbox inline">
						    <input type="checkbox" id="inlineCheckbox2" name="menu_location[]" value="Explore" <?php if (@in_array("Explore", $menuLoc)) echo "checked"; ?>> Footer[Explore] Menu
					    </label>
					    <label class="checkbox inline">
						    <input type="checkbox" id="inlineCheckbox4" name="menu_location[]" value="Beyond" <?php if (@in_array("Beyond", $menuLoc)) echo "checked"; ?>> Footer[Beyond Nepal] Menu
					    </label>
						<label class="checkbox inline">
						    <input type="checkbox" id="inlineCheckbox5" name="menu_location[]" value="Info" <?php if (@in_array("Info", $menuLoc)) echo "checked"; ?>> Footer[Nepal Travel Info] Menu
					    </label>
						<label class="checkbox inline">
						    <input type="checkbox" id="inlineCheckbox6" name="menu_location[]" value="Tail" <?php if (@in_array("Tail", $menuLoc)) echo "checked"; ?>> Tail Menu
					    </label>
                        <span class="help-block"><small>Select menu location; where do you want to display?</small></span>
                        <label>Publish</label>
				        <select name="menu_status" id="menu_status" class="input-small">
                        	<option value="1"<?=$menuStatus == '1' ? ' selected' : '' ?>>Yes</option>
                            <option value="0"<?=$menuStatus == '0' ? ' selected' : '' ?>>No</option>
                        </select>
                        <div>
                       		<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
                        </div>
                        <input type="hidden" name="menu_id" value="<?=$menuId?>" />
                        <input type="hidden" name="form" value="<?=$this->new_form?>" />
                        <input type="hidden" name="menu_order" value="<?=$menuOrder?>" />
				    </form>
					</div>
               	</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->