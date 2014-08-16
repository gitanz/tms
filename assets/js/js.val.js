// JavaScript Document for Validation	

	$(function(){
		new setupAjaxForm('reviewForm');
		
		$("#cancel").click(function(){
			$('.formArea').fadeOut('slow');
			return false;
		});
	});
	
	function setupAjaxForm(form_id, form_validations){
		var form = '#' + form_id;
		var form_message = form + '-message';
		
		// en/disable submit button
		var disableSubmit = function(val){
			$(form + ' input[type=submit]').attr('disabled', val);
		};
		
		// setup loading message
		$(form).ajaxSend(function(){
			
		});
		
		// setup jQuery Plugin 'ajaxForm' 	
		var options = {
			target: 	'#msgContainer',
			url:       site_url+'/itineraries/saveReviewForm',
			dataType:  'json',
			beforeSubmit: function(){
				$('#reviewForm').slideUp();
				$(form_message).html('<div class="jpg_info">Submitting your experience...</div>').fadeIn();
				disableSubmit(true);
			},
			success: function(json){
				$(form_message).hide();
				$(form_message).removeClass().addClass(json.success).html(json.message).fadeIn('slow');
				disableSubmit(false);
				if(json.type == 'success'){
					$(form).clearForm();
					$('.formWrapper').fadeOut('slow')
				}
			}
		};
		$(form).ajaxForm(options);
	}