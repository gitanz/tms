<?php
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
/**
 * Site page detail
 * @package himalayanpursuits
 */
require_once("views/_templates/topheader.php");
require_once("views/_templates/nav.php");
$d_list = "";
foreach($this->destinations as $destination){
    $d_list .= "<option value = '$destination->nav_title'>$destination->nav_title</option>";
}
?>
<div class="mainHolder">
<div class="inContentHolder">        
            <div class="row-fluid">
                <div class="span9">
                    <div class="leftContDiv fltLeft">
        <h1>Plan a Trip</h3> 
        <div class="spacer2"></div>
        <div class="msgContainer" id="msgContainer">
        	
        </div>
        <div id="bookingArea">
        <form id="customizeForm" name="customizeForm" autocomplete="off" method="post" action="#">
            <fieldset>
            <legend>Customize Trip</legend>            
            <div class="form-container">                
                <label class="label" for="Destination">Destination :</label>
                <select id="dest" name="destination" class="loop">
                <option value="">Select Country</option>
                <?=$d_list?>
                </select>
                <div class="clear"></div>
                <div id="clonedArea">
                <label class="label" for="Holiday">Holiday :</label>
                <input type="text" name="holiday[]" id="holiday" class="loop" placeholder="Enter trip/ holiday or region name">
                
                <label class="label" for="Duration">Duration :</label>
                <input type="text" name="duration[]" id="duration" class="loop" placeholder="Enter desired duration">
	            </div>
            </div>
            <div class="form-toolbar">
            	<div class="buttons">
                    <button type="button" class="positive" name="add" id="addHoliday">
                    <!--<a href="#" class="positive tooltip" title="Add New Holiday" id="addHoliday">-->
                        <img src="<?=SITE_URL?>/assets/images/add.png" alt=""/> 
                        Holiday
                    <!--</a>    -->
                    </button>

                    <a href="#" class="negative" title="Remove Holiday" id="removeHoliday">
                        <img src="<?=SITE_URL?>/assets/images/close.png" alt=""/>
                        Holiday
                    </a>
                </div>
            </div>
            	<label class="label" for="Required Service">Required Service :</label>
            	<textarea id="services" name="services"></textarea>
                <div class="clear"></div>
               	<label class="label" for="&nbsp;">&nbsp;</label>
                <input type="checkbox" id="isComplete"> <label>Complete Customize Trip</label>
            </fieldset>
            <fieldset>
            	<legend>Personal Information</legend>
                <label class="label" for="Title">Title :</label>
                <select id="title" name="title">
                	<option value="Mr.">Mr.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Dr.">Dr.</option>
                </select>
                <div class="clear"></div>
                <label class="label" for="First Name">First Name <span class="inline-required tooltip" title="This field is required.">*</span> :</label>
                <input type="text" name="fname" id="fname" class="required" placeholder="Enter your first and middle name">
                <label class="label" for="Last Name">Last Name <span class="inline-required tooltip" title="This field is required.">*</span> :</label>
                <input type="text" name="lname" id="lname" class="required" placeholder="Enter your last (family) name">
                <label class="label" for="Email">Email <span class="inline-required tooltip" title="This field is required.">*</span>:</label>
                <input type="text" name="email" id="email" class="required email" placeholder="Enter your contact email address">
                <label class="label" for="Telephone">Telephone :</label>
                <input type="text" name="telephone" id="telephone" placeholder="Enter contact no./ mobile no.">
                <label class="label" for="Address 1">Address 1 :</label>
                <input type="text" name="address1" id="address1" placeholder="Enter address.">
                <label class="label" for="Address 2">Address 2 :</label>
                <input type="text" name="address2" id="address2" placeholder="Enter address.">
                <label class="label" for="City">City :</label>
                <input type="text" name="city" id="city" placeholder="Enter city name.">
                <label class="label" for="Zip Code">Zip Code :</label>
                <input type="text" name="zipcode" id="zipcode" placeholder="Enter zip code.">
                <label class="label" for="Country">Country <span class="inline-required tooltip" title="This field is required.">*</span>:</label>
                <select id="country" name="country" class="required">
                	<option value="">Select Country</option>
                    <?php foreach(getCountryList() as $country): ?>
                    <option value="<?=$country?>"><?=$country?></option>
                    <?php endforeach; ?>
                </select>
            </fieldset>
			<label class="submit-label">&nbsp;</label>
            <input type="hidden" name="action" value="planned">
          	<input name="commit" id="commit" type="submit" value="Complete Booking" class="submit-button" />
       	</form>
        </div>
                  </div><!--leftContDiv end-->
                
                </div><!--span9 end-->
<?php require_once("views/_templates/sidebar.php");?>
            
            </div><!--row-fluid" end-->        
        </div><!--inContentHolder end-->
        </div></div>
   	<script src="<?=SITE_URL?>/assets/js/jquery.cusform_steps.js" type="text/javascript"></script>
   	<script>
		
		var frmObj = {
			run : function(obj) {
				if (obj.val() === '') {
					$('input#holiday').prop('disabled', true);
					$('input#duration').prop('disabled', true);
				} else {
					var id = obj.prop('id');							
					var v = obj.val();
					//alert(v);
					if(id=='dest'){
						$('input#holiday').prop('disabled', false);
						$('input#duration').prop('disabled', false);
					}
					if(id=='duration' && v.length > 1){
						$('input#isComplete').prop('disabled', false);
						$('button#addHoliday').prop('disabled', false);
					}
				}
			}
		};
		
		$(function() {				
			$('#customizeForm').formSteps();
			$('a#form_steps_next').hide();
			$('input#holiday').prop('disabled', true);
			$('input#duration').prop('disabled', true);
			$('input#isComplete').prop('disabled', true);
			$('button#addHoliday').prop('disabled', true);
			$('button#removeHoliday').prop('disabled', true);
			
			$('.loop').on('change', function() {
				frmObj.run($(this));
			});
			
			var c = $("#customizeForm").submit(function(event){
							$.ajax({
								type: "POST",
								dataType: "json",
								data: $('#customizeForm').serialize(),
								beforeSend: function() {
									$('#bookingArea').slideUp();
									$('.msgContainer').html('<img src="templates/images/loading.gif" align="absmiddle" /> processing...');
								},
								url: '<?=SITE_URL?>/itineraries/plannedbooking',
								success: function(data) {
									if (data.success == true){
       									$('.msgContainer').html(data.message);										
   									}
   									else{
       									$('.msgContainer').html(data.message);							
    								}
									//$('#bookingArea').slideDown();									
								}
							})
							//alert("submitted!");
                            event.preventDefault();
					});
			
		});
		
		$('#addHoliday').click(function() {
			//var cloned = $('#clonedArea').clone();
			var cloned = $('.form-container').find('div[id^="clonedArea"]:last').clone();
			cloned.find("#holiday").prop('value', '');
			cloned.find("#duration").prop('value', '');
			$('.form-container').append(cloned);
			$('a#addHoliday').hide();
			$('a#removeHoliday').show();
		});
		
		$('#removeHoliday').on('click', function() {
			var i = $('.form-container').find('div[id^="clonedArea"]').size();			
			if(i == 1)
				$('#removeHoliday').prop('disabled',true);
			else
				$('.form-container').find('div[id^="clonedArea"]:last').remove().fadeOut('slow');
	        return false;
        });
		
		$('#isComplete').on('change', function(){
      		if ( $(this).is(':checked') ) {
        	 	$('a#form_steps_next').show();
		    } else {
	        	$('a#form_steps_next').hide();
    	 	}
	 	});
		
	</script>