<?php 
	require_once('views/_templates/sidebar.php');
?>
<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Plans</h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/menu/lists">Itinerary</a> <span class="divider">/</span></li>
                <li class="active">Plans</li>
            </ul>
            
           	<div class="container-fluid">
            	<div class="row-fluid">
                <?php  if (isset($this->errors)) :  ?>
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
					<span>Destination: </span><?=$this->plan->plan_destination?><br>
					<span>Holiday: </span><?php $holidays = unserialize(explode("---hol---",$this->plan->plan_holiday_duration)[0]);
                                                          $durations = unserialize(explode("---hol---",$this->plan->plan_holiday_duration)[1]);  
                                                          $maparr = array_map(null,$holidays,$durations);
                                                          foreach($maparr as $arr){
                                                            echo $arr[0]." - ".$arr[1]."<br>";
                                                          }  
                                                    ?><br>
					<span>Services: </span><?=$this->plan->plan_services?><br>
                    <span>Name: </span><?=$this->plan->plan_name?><br>
                    <span>Email: </span><?=$this->plan->plan_email?><br>
                    <span>Phone: </span><?=$this->plan->plan_telephone?><br>
                    <span>Address: </span><?=$this->plan->plan_address1." , ".$this->plan->plan_address2." , ".$this->plan->plan_city." , ".$this->plan->plan_country?><br>
                    <span>Zip: </span><?=$this->plan->plan_zip?><br>
                    <span>Plan Submitted: </span><?=mfdate($this->plan->plan_added)?><br>

<br>
                    </div>
                </div> <!-- .row-fluid -->
                <?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->
                      