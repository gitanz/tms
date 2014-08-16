<?php
	/**
	 * itinerary-info form
	 * @package admin-login
	 * @date 17th June 2014
	 */
	require_once('views/_templates/sidebar.php');
    if(!$this->newForm):
    $details = $this->details;
    $info_parent = (isset($_POST["info_parent"]))                       ?    $_POST["info_parent"]                        :                      $details->info_parent;
    $infoCode = (isset($_POST["info_code"]))                            ?    $_POST["info_code"]                          :                      $details->info_code;
    $infoSupplement = (isset($_POST["info_supplement"]))                ?    $_POST["info_supplement"]                    :                      $details->info_supplement;
    $infoGrade = (isset($_POST["info_grade"]))                          ?    $_POST["info_grade"]                         :                      $details->info_grade;
    $infoActivities = (isset($_POST["info_activities"]))                ?    $_POST["info_activities"]                    :                      $details->info_activities;
    $infoGroupsize = (isset($_POST["info_groupsize"]))                  ?    $_POST["info_groupsize"]                     :                      $details->info_groupsize;
    $infoDlywlknghr = (isset($_POST["info_dlywlknghr"]))                ?    $_POST["info_dlywlknghr"]                    :                      $details->info_dlywlknghr;

    $infoTour_duration_nights = (isset($_POST["tour_duration_nights"])) ?    $_POST["tour_duration_nights"]               :                      explode("/",$details->info_tour_duration)[0];
    $infoTour_duration_days = (isset($_POST["tour_duration_days"]))     ?    $_POST["tour_duration_days"]                 :                      explode("/",$details->info_tour_duration)[1];

    $infoTrek_duration_nights = (isset($_POST["trek_duration_nights"])) ?    $_POST["trek_duration_nights"]               :                      explode("/",$details->info_trek_duration)[0];
    $infoTrek_duration_days = (isset($_POST["trek_duration_days"]))     ?    $_POST["trek_duration_days"]                 :                      explode("/",$details->info_trek_duration)[1];

    $infoSeasons = (isset($_POST["info_seasons"]))                      ?    $_POST["info_seasons"]                       :                      unserialize($details->info_seasons);
    $infoStyle = (isset($_POST["info_style"]))                          ?    $_POST["info_style"]                         :                      $details->info_style;
    $infoAccommodation = (isset($_POST["info_accommodation"]))          ?    $_POST["info_accommodation"]                 :                      $details->info_accommodation;
    $infoTransportation = (isset($_POST["info_transportation"]))        ?    $_POST["info_transportation"]                :                      $details->info_transportation;
    $infoFlight_charge = (isset($_POST["info_flight_charge"]))          ?    $_POST["info_flight_charge"]                 :                      $details->info_flight_charge;
    $infoMeals = (isset($_POST["info_meals"]))                          ?    $_POST["info_meals"]                         :                      $details->info_meals;
    
    $infoHigh_alt = (isset($_POST["info_high_alt"]))                    ?    $_POST["info_high_alt"]                      :                      explode(" ", $details->info_high_alt)[0];
    $altUnit = (isset($_POST["alt_unit"]))                              ?    $_POST["alt_unit"]                           :                      explode(" ", $details->info_high_alt)[1];

    $infoStarts_from = (isset($_POST["info_starts_from"]))              ?    $_POST["info_starts_from"]                   :                      $details->info_starts_from;
    $infoEnd_at = (isset($_POST["info_end_at"]))                        ?    $_POST["info_end_at"]                        :                      $details->info_end_at;
    $infoAdded = (isset($_POST["info_added"]))                          ?    $_POST["info_added"]                         :                      $details->info_added;
    else:
    $info_parent = (isset($_POST["info_parent"]))                       ?    $_POST["info_parent"]                        :                      "";
    $infoCode = (isset($_POST["info_code"]))                            ?    $_POST["info_code"]                          :                      "";
    $infoSupplement = (isset($_POST["info_supplement"]))                ?    $_POST["info_supplement"]                    :                      "";
    $infoGrade = (isset($_POST["info_grade"]))                          ?    $_POST["info_grade"]                         :                      "";
    $infoActivities = (isset($_POST["info_activities"]))                ?    $_POST["info_activities"]                    :                      "";

    $infoGroupsize = (isset($_POST["info_groupsize"]))                  ?    $_POST["info_groupsize"]                     :                      "1";
    $infoDlywlknghr = (isset($_POST["info_dlywlknghr"]))                ?    $_POST["info_dlywlknghr"]                    :                      "1";

    $infoTour_duration_nights = (isset($_POST["tour_duration_nights"])) ?    $_POST["tour_duration_nights"]               :                      "1";
    $infoTour_duration_days = (isset($_POST["tour_duration_days"]))     ?    $_POST["tour_duration_days"]                 :                      "1";

    $infoTrek_duration_nights = (isset($_POST["trek_duration_nights"])) ?    $_POST["trek_duration_nights"]               :                      "1";
    $infoTrek_duration_days = (isset($_POST["trek_duration_days"]))     ?    $_POST["trek_duration_days"]                 :                      "1";
    
    $infoSeasons = (isset($_POST["info_seasons"]))                      ?    $_POST["info_seasons"]                       :                      [];

    $infoStyle = (isset($_POST["info_style"]))                          ?    $_POST["info_style"]                         :                      "";
    $infoAccommodation = (isset($_POST["info_accommodation"]))          ?    $_POST["info_accommodation"]                 :                      "";
    $infoTransportation = (isset($_POST["info_transportation"]))        ?    $_POST["info_transportation"]                :                      "";
    $infoFlight_charge = (isset($_POST["info_flight_charge"]))          ?    $_POST["info_flight_charge"]                 :                      "1";
    $infoMeals = (isset($_POST["info_meals"]))                          ?    $_POST["info_meals"]                         :                      "";
    
    $infoHigh_alt = (isset($_POST["info_high_alt"]))                    ?    $_POST["info_high_alt"]                      :                      "1";
    $altUnit = (isset($_POST["alt_unit"]))                              ?    $_POST["alt_unit"]                           :                      "meters";

    $infoStarts_from = (isset($_POST["info_starts_from"]))              ?    $_POST["info_starts_from"]                   :                      "";
    $infoEnd_at = (isset($_POST["info_end_at"]))                        ?    $_POST["info_end_at"]                        :                      "";
    $infoAdded = (isset($_POST["info_added"]))                          ?    $_POST["info_added"]                         :                      "";

    $info_parent = $this->info_parent;
    endif;
    $newForm = $this->newForm?"1":"0";
    
    ?>
	<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Update Itinerary Info</h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/itineraries/lists">Itinerary</a> <span class="divider">/</span></li>
                <li class="active">Itinerary-Info</li>
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
				    <form id="itineraryForm" action="<?=ADMIN_URL?>/itineraries/saveInfo" method="post" autocomplete="off">
                        <div class = "span4">
    				        <label>Trip Code *</label>
    				        <input type="text" name="info_code" value="<?=$infoCode?>" class="input-xlarge" placeholder="Enter Trip Code here" />
                            <label>Single Supplement</label>
                            <input type="text" name="info_supplement" value="<?=$infoSupplement?>" class="input-xlarge" placeholder="Mention in US dollar" />
                            <label>Trip Grade</label>
    						<select name="info_grade" id="infoGrade">
                            	<option >Select Grade</option>
                                <option value="1" <?php if($infoGrade == "1") echo "selected"?>>1</option>
                                <option value="2" <?php if($infoGrade == "2") echo "selected"?>>2</option>
                                <option value="3" <?php if($infoGrade == "3") echo "selected"?>>3</option>
                                <option value="4" <?php if($infoGrade == "4") echo "selected"?>>4</option>
                                <option value="5" <?php if($infoGrade == "5") echo "selected"?>>5</option>
                            </select>
                            
                            <label>Activities</label>
                            <input type="text" name = "info_activities" value = "<?=$infoActivities?>" class = "input-xlarge" value="" data-role="tagsinput" placeholder="Add Activities tags" />

                            <label>Group Size</label>
                            <div class="input-append spinner" data-trigger="spinner">
                                <input type="text" name = "info_groupsize" value="<?=$infoGroupsize?>" data-rule="quantity">
                                <div class="add-on"> <a href="javascript:;" class="spin-up" data-spin="up"><i class="icon-sort-up"></i></a> <a href="javascript:;" class="spin-down" data-spin="down"><i class="icon-sort-down"></i></a> </div>
                            </div>
                            <label>Daily Walking Hour</label>
                            <div class="input-append spinner" data-trigger="spinner">
                                <input type="text" name = "info_dlywlknghr" value="<?=$infoDlywlknghr?>" data-rule="quantity">
                                <div class="add-on"> <a href="javascript:;" class="spin-up" data-spin="up"><i class="icon-sort-up"></i></a> <a href="javascript:;" class="spin-down" data-spin="down"><i class="icon-sort-down"></i></a> </div>
                            </div>
                        <label>Tour Duration</label>
                        <div class = "form-inline space">
                            <div class="input-append spinner" data-trigger="spinner">
                                <input type="text" name = "tour_duration_nights" value="<?=$infoTour_duration_nights?>" data-rule="quantity">
                                <div class="add-on"><a href="javascript:;" class="spin-up" data-spin="up"><i class="icon-sort-up"></i></a> <a href="javascript:;" class="spin-down" data-spin="down"><i class="icon-sort-down"></i></a> </div>
                                <div class="add-on">Nights</div>
                            </div>
                            and
                            <div class="input-append spinner" data-trigger="spinner">
                                <input type="text" name = "tour_duration_days" value="<?=$infoTour_duration_days?>" data-rule="quantity">
                                <div class="add-on"><a href="javascript:;" class="spin-up" data-spin="up"><i class="icon-sort-up"></i></a> <a href="javascript:;" class="spin-down" data-spin="down"><i class="icon-sort-down"></i></a> </div>
                                <div class="add-on">Days</div>
                            </div>
                        </div>    

                        <label>Trek Duration</label>
                        <div class = "form-inline space">
                            <div class="input-append spinner" data-trigger="spinner">
                                <input type="text" name = "trek_duration_nights" value="<?= $infoTrek_duration_nights?>" data-rule="quantity">
                                <div class="add-on"><a href="javascript:;" class="spin-up" data-spin="up"><i class="icon-sort-up"></i></a> <a href="javascript:;" class="spin-down" data-spin="down"><i class="icon-sort-down"></i></a> </div>
                                <div class="add-on">Nights</div>
                            </div>
                            and
                            <div class="input-append spinner" data-trigger="spinner">
                                <input type="text" name = "trek_duration_days" value="<?=$infoTrek_duration_days?>" data-rule="quantity">
                                <div class="add-on"><a href="javascript:;" class="spin-up" data-spin="up"><i class="icon-sort-up"></i></a> <a href="javascript:;" class="spin-down" data-spin="down"><i class="icon-sort-down"></i></a> </div>
                                <div class="add-on">Days</div>
                            </div>
                        </div>    
                        </div>
                        <div class = "span4">
                            <div class="form-group space">
                              <label class="col-md-4 control-label" for="radios">Tour Seasons</label>
                              <div class="col-md-4">
                              <div class="radio">
                                <label for="radios-0">
                                
                                  <input name="info_seasons[]" id="radios-0" value="Spring" <?php if(in_array("Spring", $infoSeasons)) echo 'checked';?> type="checkbox">
                                  Spring [mid-March to mid-May]
                                </label>
                                </div>
                              <div class="radio">
                                <label for="radios-1">
                                  <input name="info_seasons[]" id="radios-1" value="Summer" <?php if(in_array("Summer", $infoSeasons)) echo 'checked';?>  type="checkbox">
                                  Summer [mid-May to mid-September]
                                </label>
                              </div>
                              <div class="radio">
                                <label for="radios-2">
                                  <input name="info_seasons[]" id="radios-2" value="Autumn" <?php if(in_array("Autumn", $infoSeasons)) echo 'checked';?> type="checkbox">
                                  Autumn [mid-September to mid-January]
                                </label>
                              </div>
                              <div class="radio">
                                <label for="radios-3">
                                  <input name="info_seasons[]" id="radios-3" value="Winter" <?php if(in_array("Winter", $infoSeasons)) echo 'checked';?>  type="checkbox">
                                   Winter [mid-January to mid-March]
                                </label>
                              </div>
                              </div>
                            </div>
                            <label>Trip Style</label>
                            <div class = "col-md-4" style = "margin-left:15px">
                            <div class = "radio space">
                                <label for="radios-4">
                                  <input name="info_style" id="radios-4" value="1"<?php if($infoStyle == "1") echo 'checked';?> type="radio">
                                  Trekking
                                </label>
                                </div>
                              <div class="radio">
                                <label for="radios-5">
                                  <input name="info_style" id="radios-5" value="2" <?php if($infoStyle == "2") echo 'checked';?> type="radio">
                                  Peak Climbing
                                </label>
                              </div>
                              <div class="radio">
                                <label for="radios-6">
                                  <input name="info_style" id="radios-6" value="2" <?php if($infoStyle == "3") echo 'checked';?>type="radio">
                                  Sightseeing
                                </label>
                              </div>
                              <div class="radio">
                                <label for="radios-7">
                                  <input name="info_style" id="radios-7" value="2"<?php if($infoStyle == "4") echo 'checked';?> type="radio">
                                   Others
                                </label>
                              </div>
                            </div>

                            <label>Accommodation</label>
                            <input type = "text" value = "<?=$infoAccommodation?>" name  = "info_accommodation">
                        </div>
                        <div class = "span4">    
                            <label>Transportation</label>
                            <input type="text" name = "info_transportation" class = "input-xlarge" value="<?=$infoTransportation?>" data-role="tagsinput" placeholder="Add Transportation tags like bus, cars"/>

                            <label>Flight Charge</label>
                            <div class="input-append spinner" data-trigger="spinner">
                                    <div class="add-on">$</div>
                                    <input type="text" name = "info_flight_charge" value="<?=$infoFlight_charge?>" data-rule="currency">
                                    <div class="add-on"><a href="javascript:;" class="spin-up" data-spin="up"><i class="icon-sort-up"></i></a> <a href="javascript:;" class="spin-down" data-spin="down"><i class="icon-sort-down"></i></a> </div>
                            </div>
                            <label>Meals</label>
                            <input type="text" name = "info_meals" class = "input-xlarge" value="<?=$infoMeals?>" data-role="tagsinput" placeholder="Meals tags"/>
                            
                            <label>Highest Altitude</label>
                            <div class = "form-inline">
                            <div class="input-append spinner" data-trigger="spinner">
                                    <input type="text" name = "info_high_alt" value="<?=$infoHigh_alt?>" data-rule="quantity">
                                    <div class="add-on"><a href="javascript:;" class="spin-up" data-spin="up"><i class="icon-sort-up"></i></a> <a href="javascript:;" class="spin-down" data-spin="down"><i class="icon-sort-down"></i></a> </div>
                            </div>
                            <select name = "alt_unit" class = "span3">
                                <option value = "meters" <?php if($altUnit == "meters") echo "selected"; ?>>meters</option>
                                <option value = "feets"<?php if($altUnit == "feets") echo "selected";   ?>>feets</option>
                            </select>
                            </div>

                            <label>Starts from</label>
                            <input type = "text" value="<?=$infoStarts_from?>" name = "info_starts_from">
                            <label>Ends at</label>
                            <input type = "text" value = "<?=$infoEnd_at?>"     name = "info_end_at">
                            <input type="hidden" name="info_parent" value="<?=$info_parent?>" />
                            <input type="hidden" name="form" value="<?=$newForm?>" />
                        </div>
                        <div class = "clear"></div>
                            <div>
                                <button class="btn btn-primary"><i class="icon-save"></i> Save</button>
                            </div>
                    </form>
                    </div>
                </div> <!-- .row-fluid -->
                <?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->
                      
