<?php
	/**
	 * itinerary booking list
	 * @package admin-login
	 * @date 20th Jun 2014
	 */
	 
require_once('views/_templates/sidebar.php');	
?>
<script src="<?=SITE_URL?>/myadmin/public/javascripts/jquery.searchable.min.js"></script>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Plans</h1>
    	    </div>        
            <ul class="breadcrumb">
	            <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
        	    <li class="active">Plans</li>
	        </ul>
	        <div class="container-fluid">
    	        <div class="row-fluid">
                	<form action="<?=ADMIN_URL?>/plans/deleteall" method="post">
                	<div class="btn-toolbar">
                    	<button class="btn btn-danger" type="submit"><i class="icon-remove"></i> Delete</button>
                      	
                    </div>
                    <?php if($this->confirmDelete == true): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete?</p> 
                        <a class="btn btn-danger" href="<?=ADMIN_URL?>/itineraries/deleteplan/<?=$this->delid?>/<?=$this->confirmDelete?>">Yes</a> <a class="btn" href="<?=ADMIN_URL?>/itineraries/plans" type="submit">No</a>
                	</div>
					<?php endif; ?>
                    <?php if(isset($this->deleteAll)): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete all?</p> 
                        <button class="btn btn-danger" type="submit" name="yesall" value="true">Yes</button> <a class="btn" href="<?=ADMIN_URL?>/itineraries/plans" type="submit">No</a>
                	</div>
					<?php endif; ?>
                    <?php if (isset($_COOKIE['PageCookie'])) : ?>
                	<div class="alert alert-success">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
                        Plan is <?=$_COOKIE['PageCookie']?> successfully.
                	</div>
	                <?php setcookie ("PageCookie", "", time() - 3600); endif; ?>
					    

                        <div class="row-fluid">
                            <div class = "well">
                                    <input type="search" id="search" value="" class="form-control" placeholder="Search Booking">
                                <div class="col-lg-4 col-lg-offset-4">
                                </div>
                        
                                <div class="col-lg-12">
                                    <table class="table" id="table">
                                        <thead>
                                            <tr>
                                                <th><label class="checkbox"><input type="checkbox" id="selectall" <?php if(isset($_POST['planid'])) echo 'checked'; ?> /> ID</label></th>
                                                <th>Name</th>
                                                <th>Destination</th>
                                                <th>Holiday</th>
                                                <th>Email</th>
                                                <th>Added</th>
                                                <th></th>    
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php  foreach($this->plans as $plan):?>
                                            <tr>
                                                <?php if( isset($_POST['planid']) ):                   
                                                    $inPag = $_POST['planid'];
                                                    $checked = array_key_exists($plan->plan_id, $inPag) ? ' checked' : '';
                                                else:
                                                    $checked = '';
                                                endif;
                                                echo '<td><label class="checkbox"><input type="checkbox" class="checkbxtd" name="planid['.$plan->plan_id.']"'.$checked.' />'.$plan->plan_id.'</label></td>';
                                                echo '<td><a href="'.ADMIN_URL.'/itineraries/plans/'.$plan->plan_id.'" title="Edit" rel="tooltip">'.stripslashes($plan->plan_name).'</a></td>';?>
                                                <td><?=$plan->plan_destination?></td>
                                                <td>
                                                    <?php $holidays = unserialize(explode("---hol---",$plan->plan_holiday_duration)[0]);
                                                          $durations = unserialize(explode("---hol---",$plan->plan_holiday_duration)[1]);  
                                                          $maparr = array_map(null,$holidays,$durations);
                                                          foreach($maparr as $arr){
                                                            echo $arr[0]." - ".$arr[1]."<br>";
                                                          }  
                                                    ?>
                                                </td>
                                                <td><?=$plan->plan_email?></td>
                                                <td><?=mfdate($plan->plan_added)?></td>
                                               <?php  echo '<td>
                                                <a href="'.ADMIN_URL.'/itineraries/plans/'.$plan->plan_id.'" title="View Reservation" rel="tooltip"><i class="icon-bookmark"></i></a>
                                                <a href="'.ADMIN_URL.'/itineraries/deleteplan/'.$plan->plan_id.'" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>';
                                                echo '</tr>';?>

                                            </tr>
                                        <?php endforeach;?>                                                                                        
                                        </tbody>
                                    </table>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </form>
				</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->