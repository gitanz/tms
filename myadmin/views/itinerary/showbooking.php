<?php 
	require_once('views/_templates/sidebar.php');
?>
<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Bookings</h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/menu/lists">Itinerary</a> <span class="divider">/</span></li>
                <li class="active">Booking</li>
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
					<span>Destination: </span><?=$this->booking->booking_trip_destination?><br>
					<span>Holiday: </span><?=$this->booking->booking_trip_holiday?><br>
					<span>Departure: </span><?=mfdate($this->booking->booking_departure)?><br>
					<span>Arrival: </span><?=mfdate($this->booking->booking_arrival)?><br>
					<span>No of Passengers: </span><?=$this->booking->booking_nop?><br>
					<span>International Flights: </span><?=$this->booking->booking_intl_flights?><br>
                    <span>Name: </span><?=$this->booking->booking_first_name." ".$this->booking->booking_last_name?><br>
                    <span>Email: </span><?=$this->booking->booking_email?><br>
                    <span>Phone: </span><?=$this->booking->booking_phone?><br>
                    <span>Address: </span><?=$this->booking->booking_address1." , ".$this->booking->booking_address2." , ".$this->booking->booking_city." , ".$this->booking->booking_country?><br>
                    <span>Zip: </span><?=$this->booking->booking_zip?><br>
                    <span>Selected Price per unit person: </span><?=$this->booking->booking_price_type?><br>
                    <span>Total Price: </span><?=$this->booking->booking_total?><br>
                    <span>Payment Method: </span><?=$this->booking->booking_payment_method?><br>

<br>
                    </div>
                </div> <!-- .row-fluid -->
                <?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->
                      