<?php
	/**
	 * itinerary form
	 * @package admin-login
	 * @date 17th June 2014
	 */
	require_once('views/_templates/sidebar.php');
    
    if($this->newForm):
    $tripTitle = (isset($_POST["trip_title"]))                  ?          $_POST["trip_title"]         :   "";
    $tripAlias = (isset($_POST["trip_alias"]))                  ?          $_POST["trip_alias"]         :   "";
    $tripPriceType = (isset($_POST["trip_price_type"]))         ?          $_POST["trip_price_type"]    :   "";
    $tripPrice = (isset($_POST["trip_price"]))                  ?          $_POST["trip_price"]         :   "";
    $dPrice = (isset($_POST["trip_price_dlx"]))                 ?          $_POST["trip_price_dlx"]     :   ""; 
    $sdPrice = (isset($_POST["trip_price_sdlx"]))               ?          $_POST["trip_price_sdlx"]    :   ""; 
    $ssPrice = (isset($_POST["trip_price_ss"]))                 ?          $_POST["trip_price_ss"]      :   ""; 
    $tripSSPriceTented =(isset($_POST["trip_ss_price_tent"]))   ?          $_POST["trip_ss_price_tent"] :   ""; 
    $tripSSPriceTea = (isset($_POST["trip_ss_price_tea"]))      ?          $_POST["trip_ss_price_tea"]  :   ""; 
    $tripDPriceTented = (isset($_POST["trip_d_price_tea"]))     ?          $_POST["trip_d_price_tent"]  :   ""; 
    $tripDPriceTea = (isset($_POST["trip_d_price_tea"]))        ?          $_POST["trip_d_price_tea"]   :   ""; 
    $tripSDPriceTented = (isset($_POST["trip_sd_price_tea"]))   ?          $_POST["trip_sd_price_tent"] :   ""; 
    $tripSDPriceTea = (isset($_POST["trip_sd_price_tea"]))      ?          $_POST["trip_sd_price_tea"]  :   ""; 
    $tripImage = (isset($_POST["trip_image"]))                  ?          $_POST["trip_image"]         :   "";
    $tripFeature = (isset($_POST["trip_feature"]))              ?          $_POST["trip_feature"]       :   "";
    $tripStatus = (isset($_POST["trip_status"]))                ?          $_POST["trip_status"]        :   "";
    $tripDate = (isset($_POST["trip_date"]))                    ?          $_POST["trip_date"]          :   "";
    $tripOverview = (isset($_POST["trip_overview"]))            ?          $_POST["trip_overview"]      :   "";
    $tripOutline = (isset($_POST["trip_outline"]))              ?          $_POST["trip_outline"]       :   "";
    $tripDay2Day = (isset($_POST["trip_day2Day"]))              ?          $_POST["trip_day2Day"]       :   "";
    $tripNotes = (isset($_POST["trip_notes"]))                  ?          $_POST["trip_notes"]         :   "";
    $tripImg = (isset($_POST["trip_img"]))                      ?          $_POST["trip_img"]           :   "";
    $mapImg = (isset($_POST["map_img"]))                        ?          $_POST["map_img"]            :   "";
    $tripFile = (isset($_POST["trip_file"]))                    ?          $_POST["trip_file"]          :   "";
    $tripOrder= (isset($_POST["trip_order"]))                   ?          $_POST["trip_order"]         :   "";
    $tripId = "";
    $newForm = 1;
    else:
    $tripTitle = (isset($_POST["trip_title"]))? $_POST["trip_title"]:$this->details->trip_title;
    $tripAlias = (isset($_POST["trip_alias"]))? $_POST["trip_alias"]:$this->details->trip_alias;
    $tripPriceType = (isset($_POST["trip_price_type"]))? $_POST["trip_price_type"]:$this->details->trip_price_type;
    $tripPrice = (isset($_POST["trip_price"]))? $_POST["trip_price"]:explode("/",$this->details->trip_price);
    $dPrice = (isset($_POST["trip_price_dlx"]))? $_POST["trip_price_dlx"]:$tripPrice[0];
    $sdPrice = (isset($_POST["trip_price_sdlx"]))? $_POST["trip_price_sdlx"]:$tripPrice[1];
    $ssPrice = (isset($_POST["trip_price_ss"]))? $_POST["trip_price_ss"]:$tripPrice[2];
    $tripSSPriceTented =(isset($_POST["trip_ss_price_tent"]))? $_POST["trip_ss_price_tent"]: explode("/",$this->details->trip_ss_price)[0];
    $tripSSPriceTea = (isset($_POST["trip_ss_price_tea"]))? $_POST["trip_ss_price_tea"]: explode("/",$this->details->trip_ss_price)[1];
    $tripDPriceTented = (isset($_POST["trip_d_price_tea"]))? $_POST["trip_d_price_tent"]:explode("/",$this->details->trip_d_price)[0];
    $tripDPriceTea = (isset($_POST["trip_d_price_tea"]))? $_POST["trip_d_price_tea"]:explode("/",$this->details->trip_d_price)[1];
    $tripSDPriceTented = (isset($_POST["trip_sd_price_tea"]))? $_POST["trip_sd_price_tent"]:explode("/",$this->details->trip_sd_price)[0];
    $tripSDPriceTea = (isset($_POST["trip_sd_price_tea"]))? $_POST["trip_sd_price_tea"]:explode("/",$this->details->trip_sd_price)[1];
    $tripImage = (isset($_POST["trip_image"]))? $_POST["trip_image"]:$this->details->trip_image;
    $tripFeature = (isset($_POST["trip_feature"]))? $_POST["trip_feature"]:$this->details->trip_feature;
    $tripStatus = (isset($_POST["trip_status"]))? $_POST["trip_status"]:$this->details->trip_status;
    $tripDate = (isset($_POST["trip_date"]))? $_POST["trip_date"]:$this->details->trip_added;
    $tripOverview = (isset($_POST["trip_overview"]))? $_POST["trip_overview"]:$this->details->trip_overview;
    $tripOutline = (isset($_POST["trip_outline"]))? $_POST["trip_outline"]:$this->details->trip_outline;
    $tripDay2Day = (isset($_POST["trip_day2Day"]))? $_POST["trip_day2Day"]:$this->details->trip_day2day;
    $tripNotes = (isset($_POST["trip_notes"]))? $_POST["trip_notes"]:$this->details->trip_notes;
    $tripImg = (isset($_POST["trip_img"]))? $_POST["trip_img"]:$this->details->trip_image;
    $mapImg = (isset($_POST["map_img"]))? $_POST["map_img"]:$this->details->trip_map;
    $tripFile = (isset($_POST["trip_file"]))? $_POST["trip_file"]:$this->details->trip_file;
    $tripOrder= (isset($_POST["trip_order"]))? $_POST["trip_order"]:$this->details->trip_order;
    $tripId = $this->details->trip_id;
    $newForm = 0;
    endif;
    ?>
	<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Add Itinerary</h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/itineraries/lists">Itinerary</a> <span class="divider">/</span></li>
                <li class="active">Add Itinerary</li>
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
				    <form id="itineraryForm" action="<?=ADMIN_URL?>/itineraries/save" method="post" autocomplete="off">
				        <label>Trip Title *</label>
				        <input type="text" name="trip_title" value="<?=$tripTitle?>" class="input-xlarge" placeholder="Enter Itinerary title here" />
				        <label>Alias</label>
				        <input type="text" name="trip_alias" value="<?=$tripAlias?>" class="input-xlarge" placeholder="Auto generated from title"  id="disabledInput" />
				        <label>Parent Item</label>
				        <select name="trip_parent" id="trip_parent">
                        	<option value="0">Menu Item Root</option>
                            <?=$this->adjacency?>
                        </select>

                        <label>Parent Category</label>
                        <select name="category_id" id="category_id">
                            <option value="0">Miscellaenous</option>
                            <?=$this->catAdjacency?>
                        </select>

                        <label>Feature it</label>
                        <select name = "trip_feature">
                            <option value="0"<?php if($tripFeature == '0') echo "selected"?>>No</option>
                            <option value="1"<?php if($tripFeature == '1') echo "selected"?>>Yes</option>
                        </select>
                        <label>Price Type</label>
						<select name="trip_price_type" id="tripPrice">
                        	<option >Select Price type</option>
                            <option value="0" <?php if($tripPriceType == "0") echo "selected"?>>No Price</option>
                            <option value="1" <?php if($tripPriceType == "1") echo "selected"?>>Tour Price</option>
                            <option value="2" <?php if($tripPriceType == "2") echo "selected"?>>Trekking Price</option>
                        </select>
                        <div id = "tourPrice" <?php if($tripPriceType != "1") echo "style = 'display:none'";?>>
                            <label>Deluxe Price</label>
                            <input type = "text" value = "<?=$dPrice?>" name = "trip_price_dlx">
                            <label>Super Deluxe Price</label>
                            <input type = "text" value = "<?=$sdPrice?>" name = "trip_price_sdlx">
                            <label>Super Standard Price</label>
                            <input type = "text" value = "<?=$ssPrice?>" name = "trip_price_ss">


                        </div>
                        <div id = "trekkingPrice" <?php if($tripPriceType != "2") echo "style = 'display:none'";?>>
                            <label>Super Deluxe Tented Camp Price</label>
                            <input type = "text" value="<?=$tripSDPriceTented?>" name = "trip_sd_price_tent">
                            <label>Super Deluxe Tea House Price</label>
                            <input type = "text" value = "<?=$tripSDPriceTea?>" name = "trip_sd_price_tea">
                            <label>Deluxe Tented Camp Price</label>
                            <input type = "text" value = "<?=$tripDPriceTented?>" name = "trip_d_price_tent">
                            <label>Deluxe Tea House Price</label>
                            <input type = "text"  value = "<?=$tripDPriceTea?>" name = "trip_d_price_tea">
                            <label>Super Standard Tented Camp Price</label>
                            <input type = "text"  value = "<?=$tripSSPriceTented?>"  name = "trip_ss_price_tent">
                            <label>Super Standard Tea House Price</label>
                            <input type = "text"  value = "<?=$tripSSPriceTea?>" name = "trip_ss_price_tea">
                        </div>
                        <div class = "clear"></div>
                        <label>Trip Image</label>
                            <div class="input-append">
                                <input type="text" value="<?=$tripImg?>" id="tripImg" name="trip_image" class="input-xlarge" />
                                <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=tripImg">Select</a>
                            </div>
                            <?php if (is_file( '../'.View::attachmentPathCorrect($tripImg) )) : ?>
                            <div class="block-body">
                                <a href="<?=View::attachmentFullPathCorrect($tripImg)?>" class="iframe-btn">
                                    <img class="img-polaroid" src="<?=View::attachmentThumbPathCorrect($tripImg)?>">
                                </a>
                                <div class="clearfix"></div>
                            </div>
                            <?php endif; ?>
                        <label>Trip Map</label>
                            <div class="input-append">
                                <input type="text" value="<?=$mapImg?>" id="mapImg" name="trip_map" class="input-xlarge" />
                                <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=mapImg">Select</a>
                            </div>
                            <?php if (is_file( '../'.View::attachmentPathCorrect($mapImg) )) : ?>
                            <div class="block-body">
                                <a href="<?=View::attachmentFullPathCorrect($mapImg)?>" class="iframe-btn">
                                    <img class="img-polaroid" src="<?=View::attachmentThumbPathCorrect($mapImg)?>">
                                </a>
                                <div class="clearfix"></div>
                            </div>
                            <?php endif; ?>
                        <label>Upload File</label>
                            <div class="input-append">
                                <input type="text" value="<?=$tripFile?>" id="tripFile" name="trip_file" class="input-xlarge" />
                                <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=2&amp;field_id=tripFile">Select</a>
                            </div>
                        <label>Publish</label>
    				        <select name="trip_status" id="trip_status" class="input-small">
                            	<option value="1"<?php if($tripStatus == "1") echo "selected"?>>Yes</option>
                                <option value="0"<?php if($tripStatus == "0") echo "selected"?>>No</option>
                            </select>
                        <label>Trip added date</label>
                        <input type="text" name="trip_date" value="<?=$tripDate?>" class="input-xlarge" id="datetime" />
                        <label>Trip Overview</label>
	                        <textarea rows="3" class="input-xxlarge" name="trip_overview" id="tinyEditor"><?=stripslashes($tripOverview)?></textarea>
                        <label>Trip Outline</label>
                            <textarea rows="3" class="input-xxlarge" name="trip_outline" id="tinyEditor1"><?=stripslashes($tripOutline)?></textarea>
                        <label>Trip Day to Day</label>
                            <textarea rows="3" class="input-xxlarge" name="trip_day2day" id="tinyEditor2"><?=stripslashes($tripDay2Day)?></textarea>
                        <label>Trip Notes</label>
                            <textarea rows="3" class="input-xxlarge" name="trip_notes" id="tinyEditor3"><?=stripslashes($tripNotes)?></textarea>

                        <div>
                       		<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
                        </div>
                        <input type="hidden" name="trip_id" value="<?=$tripId?>" />
                        <input type="hidden" name="form" value="<?=$newForm?>" />
                        <input type="hidden" name="trip_order" value="<?=$tripOrder?>" />
                    </form>
                    </div>
                </div> <!-- .row-fluid -->
                <?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->
                      
