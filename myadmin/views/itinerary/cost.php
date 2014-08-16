<?php
	/**
	 * itinerary-info form
	 * @package admin-login
	 * @date 17th June 2014
	 */
	require_once('views/_templates/sidebar.php');
	$newForm = $this->newForm?'1':'0';
	$tripId = $this->cost_parent;
	// if($newForm = '0')://update
		$tripPr_includes = (isset($_POST['trip_pr_includes']))?$_POST['trip_pr_includes']:$this->includes->trip_pr_includes;
		$tripPr_n_includes = (isset($_POST['trip_pr_n_includes']))?$_POST['trip_pr_n_includes']:$this->includes->trip_pr_n_includes;
		$tripInformation = (isset($_POST['trip_information']))?$_POST['trip_information']:$this->includes->trip_information;
		
	// elseif($newForm = '1')://add
		// $tripPr_includes = (isset($_POST['trip_pr_includes']))?$_POST['trip_pr_includes']:"";
		// $tripPr_n_includes = (isset($_POST['trip_pr_n_includes']))?$_POST['trip_pr_n_includes']:"";
		// $tripInformation = (isset($_POST['trip_information']))?$_POST['trip_information']:"";
	// endif;
	$showtable = isset($this->details)? true : false;
?>
	<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Update Dates and Cost</h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/itineraries/lists">Itinerary</a> <span class="divider">/</span></li>
                <li class="active">Update Date and Cost</li>
            </ul>
            
           	<div class="container-fluid">
            	<div class="row-fluid">
                <?php  if (isset($this->errors)) : ?>
                	<div class="alert alert-error">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
						<?php foreach ($this->errors as $error) : 
                                echo $error;
                            endforeach; 
                        ?>
                	</div>
                <?php endif; ?>
					<div class="well">
				    <form id="itineraryForm" action="<?=ADMIN_URL?>/itineraries/saveCost" method="post" autocomplete="off">
				    <div class = "span6" id = "addin">
					    <div id = "addable" class = "well">
					    <div class = "pull-right" style = "margin-top:-15px"><span id = "addmoresection" tooltip = "Add more section" style = "padding:5px 10px ;background:green;color:white;cursor:pointer">+</span></div>
					    <div class = "clear"></div>
					    	<div id = "form">
						        <label>Trip Code</label>
		                        <div class="input-append space">
		                            <div class="add-on">HIM-</div>
								  <input type = "text" name = "cost_code[]" placeholder = "Enter code here" value = "" >
		                        </div>

						        <label>Departure Date</label>
						        <div class = "form-inline space">
							        <label>Starts&nbsp;</label><input name = "cost_starts[]" style = "width:50px" type = "text" id = "datetime" value = "" >
							        <label>Ends&nbsp;</label><input name = "cost_ends[]" style = "width:50px" type = "text" id = "datetime1" value = "" >
						        </div>
						        <label style = "text-decoration:underline">Price Category </label>
						        <label>Super Standard</label>
						        <div class = "form-inline">
							        <div class="input-append spinner" data-trigger="spinner">
			                                    <div class="add-on">$</div>
			                                    <input type="text" name = "cost_ss[]" value="" data-rule="currency" >
			                                    <div class="add-on"><a href="javascript:;" class="spin-up" data-spin="up"><i class="icon-sort-up"></i></a> <a href="javascript:;" class="spin-down" data-spin="down"><i class="icon-sort-down"></i></a> </div>
			                        </div>
						        <select name = "cost_ss_avai[]" class="span3" >
						        	<option value="available">Available</option>
						        	<option value = "guaranted">Guaranted</option>
						        	<option value="limited">Limited</option>
						        	<option value="closed">Closed</option>
						        </select>
						        </div>
		  				        <label>Deluxe</label>
		  				        <div class = "form-inline">
						        <div class="input-append spinner" data-trigger="spinner">
		                                    <div class="add-on">$</div>
		                                    <input type="text" name = "cost_d[]" value="" data-rule="currency" >
		                                    <div class="add-on"><a href="javascript:;" class="spin-up" data-spin="up"><i class="icon-sort-up"></i></a> <a href="javascript:;" class="spin-down" data-spin="down"><i class="icon-sort-down"></i></a> </div>
		                        </div>
						        <select name = "cost_d_avai[]" class="span3" >
						        	<option value="available">Available</option>
						        	<option value = "guaranted">Guaranted</option>
						        	<option value="limited">Limited</option>
						        	<option value="closed">Closed</option>
						        </select>
						        </div>
								<label>Super Deluxe</label>
								<div class = "form-inline">
						        <div class="input-append spinner" data-trigger="spinner">
		                                    <div class="add-on">$</div>
		                                    <input type="text" name = "cost_sd[]" value="" data-rule="currency" >
		                                    <div class="add-on"><a href="javascript:;" class="spin-up" data-spin="up"><i class="icon-sort-up"></i></a> <a href="javascript:;" class="spin-down" data-spin="down"><i class="icon-sort-down"></i></a> </div>
								</div>
						        <select name = "cost_sd_avai[]" class="span3" >
						        	<option value="available">Available</option>
						        	<option value = "guaranted">Guaranted</option>
						        	<option value="limited">Limited</option>
						        	<option value="closed">Closed</option>
						        </select>
						        </div>
						    </div>
					    </div>

				    </div>
				    <div class = "span6 well">
				    	<label>Price Includes</label>
				    	<textarea style = "width:100%" name = "trip_pr_includes" id="tinyEditor"><?=$tripPr_includes?></textarea>
						<label>Price doesn't include</label>
				    	<textarea  style = "width:100%"  name = "trip_pr_n_includes" id="tinyEditor1"><?=$tripPr_n_includes?></textarea>
						<label>Information</label>
				    	<textarea  style = "width:100%" name = "trip_information" id="tinyEditor2"><?=$tripInformation?></textarea>
				    </div>    
				    <div class = "clear"></div>
                        <div>
                        <?php if($showtable):?>
                        	<table class="table table-stripped" id="table">
                                        <thead>
                                            <tr>
                                                <th><label class="checkbox"> ID</label></th>
                                                <th>Trip Code </th>
                                                <th>Starts</th>
                                                <th>Ends</th>
                                                <th>Super Standard</th>
                                                <th>Deluxe</th>
                                                <th>Super Deluxe</th>    
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                        	<?php foreach($this->details as $details):?>
                                            <tr><?php 
                                                echo '<td>'.$details->cost_id.'</td>';
                                                echo '<td><a href="'.ADMIN_URL.'/itineraries/costupdate/'.$details->cost_id.'" title="Edit" rel="tooltip">'.stripslashes($details->cost_code).'</a></td>';?>
                                                <td><?php echo mfdate($details->cost_starts) ?></td>
                                                <td><?php echo mfdate($details->cost_ends) ?></td>
                                                <td><?php echo $details->cost_ss." ".$details->cost_ss_availability ?></td>
                                                <td><?php echo $details->cost_d." ".$details->cost_d_availability ?></td>
                                                <td><?php echo $details->cost_sd." ".$details->cost_sd_availability ?></td>
                                               <?php  echo '<td>
                                                <a href="#'.$details->cost_id.'" class = "inline" title="Edit" ><i class="icon-pencil"></i></a>

                                                <a href="'.ADMIN_URL.'/itineraries/costdelete/'.$details->cost_id.'" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>';
                                                echo '</tr>';?>

                                            </tr>
                        	<?php endforeach;?>
                                        </tbody>
                                    </table>
                        <?php endif;?>
                       		<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
                        </div>
                        <input type="hidden" name="trip_id" value="<?=$tripId?>" />
                        <input type="hidden" name="form" value="<?=$newForm?>" />
                    </form>
                    </div>
                </div> <!-- .row-fluid -->
                <?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->
        
<?php if($showtable): foreach($this->details as $details):
echo '<div style="display:none" id = "'.$details->cost_id.'">
															<form name = "update" method = "POST" action = "'.ADMIN_URL.'/itineraries/saveCost">
																<label>Trip Code</label>
																<input type = "text" name = "cost_code" class = "form-control" value = "'.$details->cost_code.'">
																<label>Departure Date</label>
																<div class = "form-inline">
																<label>Starts</label><input type = "text" name = "cost_starts" class = "datetime" value = "'.$details->cost_starts.'">
																<label>Ends</label><input type = "text" class = "datetime" name = "cost_ends" value = "'.$details->cost_ends.'">
																</div>
																<label>Price Category</label>															
																<div class = "form-inline">
																<label>Super Standard:</label><label class = "smallItalics">Price<label><input name = "cost_ss" type = "text" value = "'.$details->cost_ss.'">
																	<select name = "cost_ss_availability">
																		<option value = "available"';
																	echo ($details->cost_ss_availability == 'available')?"selected":""; 		
																	echo '>Available</option>';
																	echo '<option value = "guaranted"';
																	echo ($details->cost_ss_availability == 'guaranted')?"selected":""; 		
																	echo '>Guaranted</option>';
																	echo '<option value = "limited"';
																	echo ($details->cost_ss_availability == 'limited')?"selected":""; 		
																	echo '>Limited</option>';
																	echo '<option value = "closed"';
																	echo ($details->cost_ss_availability == 'closed')?"selected":"";
																	echo '>Closed</option>';
																	echo '</select>
																</div><div class = "form-inline">
																<label>Deluxe:</label><label class = "smallItalics">Price<label><input type = "text" name = "cost_d" value = "'.$details->cost_d.'">
																	<select name = "cost_d_availability">
																		<option value = "available"';
																		echo ($details->cost_d_availability == 'available')?"selected":""; 	
																		echo '>Available</option>
																		<option value = "guaranted"';
																		echo ($details->cost_d_availability == 'guaranted')?"selected":""; 	
																		echo '>Guaranted</option>
																		<option value = "limited"';
																		echo ($details->cost_d_availability == 'limited')?"selected":""; 	
																		echo '>Limited</option>
																		<option value = "closed"';
																		echo ($details->cost_d_availability == 'closed')?"selected":""; 	
																		echo '>Closed</option>
																	</select>
																</div><div class = "form-inline">	
																<label>Super Deluxe:</label><label class = "smallItalics">Price<label><input name = "cost_sd" type = "text" value = "'.$details->cost_sd.'">
																	<select name = "cost_sd_availability">
																		<option value = "available"';
																		echo ($details->cost_sd_availability == 'available')?"selected":""; 	
																		echo '>Available</option>
																		<option value = "guaranted"';
																		echo ($details->cost_sd_availability == 'guaranted')?"selected":""; 	
																		echo '>Guaranted</option>
																		<option value = "limited"';
																		echo ($details->cost_sd_availability == 'limited')?"selected":""; 	
																		echo '>Limited</option>
																		<option value = "closed"';
																		echo ($details->cost_sd_availability == 'closed')?"selected":""; 	
																		echo '>Closed</option>
																	</select>
																</div>
															<input type = "hidden"  name = "form" value = "0">	
															<input type = "hidden" name = "cost_id" value = "'.$details->cost_id.'">
															<input type = "submit" class = "btn btn-primary" id="fb-submit" value = "Save">																		
															</form>
													</div>';

endforeach;endif;?>

