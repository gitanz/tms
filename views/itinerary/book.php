<?php
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
require_once("views/_templates/topheader.php");
require_once("views/_templates/nav.php");
$destination = $itiMdl->getRootNav($this->result->trip_parent);
$title = $this->result->trip_title;
if(isset($_GET['tailormade']) && $_GET['tailormade'] == '1' )
	$tailormade = true;
else
	$tailormade = false;
$id = $this->result->trip_id;
$country_list = array("Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Central African Republic","Chad","Chile","China","Colombi","Comoros","Congo (Brazzaville)","Congo","Costa Rica","Cote d'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor (Timor Timur)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Fiji","Finland","France","Gabon","Gambia, The","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea, North","Korea, South","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia",
	"Zimbabwe"
);
?>
<script type="text/javascript" src="<?=SITE_URL?>/assets/js/jquery.validate.min.js"></script>
<script>var site_url = '<?=SITE_URL?>'</script>
<div class="mainHolder">
<div class="inContentHolder">        
            <div class="row-fluid">
                <div class="span9">
                    <div class="leftContDiv fltLeft">
                    <h1>Book Trip - <?=$this->result->trip_title?></h1>
                    <div id = "alerts"></div>
                		<!-- multistep form -->
						<form id="msform" action = "#" method = "POST">
							<!-- progressbar -->
							<ul id="progressbar">
								<li class="active">Travel Information</li>
								<li>Personal Information</li>
								<!-- <li>Payment Details</li> -->
							</ul>
							<!-- fieldsets -->
							<fieldset>
								<h2 class="fs-title">Book Your Trip</h2>
								<h3 class="fs-subtitle">Travel Information</h3>
								<label>Destination : </label><?=$destination->nav_title?><br>
								<label>Holiday : </label><?=$title?><br>
								<input type="text" id = "datepicker1" name="book_depart" placeholder="Start Date" required/>
								<input type="text" id = "datepicker2" name="book_arriv" placeholder="End Date" required/>
								<?php if($tailormade):?>
								<label style = "font-weight:normal">Customize trip</label>
								<textarea name = 'tailor'></textarea>
								<?php endif;?>
								
								<label style = "font-weight:normal">Select number of passengers</label>
								<select id="passengers" class = "form-control" name = "book_nop" required>
								<option>Select number of passengers</option>
								<option value = "1">1</option>
								<option value = "2">2</option>
								<option value = "3">3</option>
								<option value = "4">4</option>
								<option value = "5">5</option>
								</select><br>
								<!-- <label style = "font-weight:normal">Do you require international flights with your holiday booking</label><br> -->
								<!-- <input style = "width:10px;margin-left:0px" type = "radio" name = "book_req_intl_flights">&nbsp;Yes -->
								<input style = "width:10px;margin-left:0px" type = "hidden" name = "book_req_intl_flights" >
								<input type="button" name="next" class="next action-button" value="Next"/>
							</fieldset>
							<fieldset>
								<h2 class="fs-title">Book Your Trip</h2>
								<h3 class="fs-subtitle">Personal Information</h3>
								<label class="label" for="fname">First Name</label>
								<input type="text" class="" name="fname" placeholder="Your First and Middle Name" required />

								<label class="label" for="name">Last Name</label>
								<input type="text" class="" name="lname" placeholder="Your Last Name" required/>

								<label class="label" for="email">Email</label>
								<input type="text" class="" name="email" placeholder="Your email address" required/>

								<label class="label" for="phone">Phone</label>
								<input type="text" name="phone" placeholder="Your contact phone no" />

								<label class="label" for="address1">Address 1:</label>
								<input type="text" class="" name="address1" placeholder="Address..." />

								<label class="label" for="address1">Address 2:</label>
								<input type="text" class="" name="address2" placeholder="Address..."/>

								<label class="label" for="city">City:</label>
								<input type="text" class="" name="city" placeholder="City" required/>
								<select class = "form-control" name ="country" required>
								<option value="">Select your Country</option>
									<?php 
										foreach($country_list as $country)
										echo '<option value="'.$country.'">'.$country.'</option>'
									?>
								</select>
								<label class="label" for="zip">Postal Code:</label>
								<input type="text" class="" name="zip" placeholder="Zip code..." />
								<input type="button" name="previous" class="previous action-button" value="Previous" />
								<input type="submit" name="submit" class="submit action-button" value="Submit" />
								<input type = "hidden" name="id" value = "<?=$id?>">
								<input type = "hidden" name = "destination" value = "<?=$destination?>">
								<input type="hidden" name = "holiday" value="<?=$title?>">
								<input type = "hidden" name = "action" value = "reserve">
								
							</fieldset>
							<!-- <fieldset>
								<h2 class="fs-title">Book Your Trip</h2>
								<h3 class="fs-subtitle">Payment details</h3>
								<label>Price Type</label><br/>
								<select class = "form-control" name="p-type" id="p_type">
									<?php if($this->result->trip_price_type == '0'):?>
									<option value = ""></option>
									<?php elseif($this->result->trip_price_type == '1'):?>
									<option value = "<?=explode('/',$this->result->trip_price)[0]?>">Super Standard</option>
									<option value = "<?=explode('/',$this->result->trip_price)[1]?>">Deluxe</option>
									<option value = "<?=explode('/',$this->result->trip_price)[2]?>">Super Deluxe</option>
									<?php elseif($this->result->trip_price_type == '2'):?>
									<option value = "<?=explode('/',$this->result->trip_ss_price)[0]?>">Super Standard Tented Camp Price</option>
									<option value = "<?=explode('/',$this->result->trip_ss_price)[1]?>">Super Standard Tea House Price</option>
									<option value = "<?=explode('/',$this->result->trip_d_price)[0]?>">Deluxe Tented Camp Price</option>
									<option value = "<?=explode('/',$this->result->trip_d_price)[1]?>">Deluxe Tea House Price</option>
									<option value = "<?=explode('/',$this->result->trip_sd_price)[0]?>">Super Deluxe Tented Camp Price</option>
									<option value = "<?=explode('/',$this->result->trip_sd_price)[1]?>">Super Deluxe Tea House Price</option>
									<?php endif;?>
								</select>
								<label>Online Deposit</label>
								<span class="deposit" id="deposit"></span><br>
								<label>Total</label>
								<span class="total" id="total"></span><br>
								<label>Payment Method</label><br>
								<input style = "width:10px;margin-left:0px" type ="radio" name="payment" id="paypal" disabled="disabled"/> Via Paypal<br>
								<input style = "width:10px;margin-left:0px"  type ="radio" name="payment" id="secure" disabled="disabled"/> Via Secure Online Payment<br>
								<input style = "width:10px;margin-left:0px" type ="radio" name="payment" id="wired" value = "Wired" checked/> Via Wire Payment<br>
								<span class='note'>If there are more than 6 persons please <a href ='#'>email us</a></span>

								<div id='addHtml'></div>
								<input type="button" name="previous" class="previous action-button" value="Previous" />
								
							</fieldset> -->
						</form>
                  
                 
		                    </div><!--leftContDiv end-->
                </div><!--span9 end-->
<?php require_once("views/_templates/book-sidebar.php");?>
            </div><!--row-fluid" end-->        
        </div><!--inContentHolder end-->
</div>

      

