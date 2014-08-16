<?php
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');


?>
<h2 class = 'space'>Leave a message</h2>
<script> var RecaptchaOptions = {theme : 'clean'};</script>
<?php if (isset($_COOKIE['MessageCookieContact'])) : ?>
               	<div class="alert alert-success">
                	<button data-dismiss="alert" class="close" type="button">×</button>
                    <?php $messages = unserialize($_COOKIE['MessageCookieContact']);
                    foreach($messages as $message):
                    	echo $message."<br/>";
                    endforeach;
                    ?>
            	</div>
<?php endif;?>	
<?php if (isset($_COOKIE['ErrorCookieContact'])) : ?>
				<div class="alert alert-danger">
					<button data-dismiss="alert" class="close" type="button">×</button>
				    <?php $errors = unserialize($_COOKIE['ErrorCookieContact']);
				    	foreach ($errors as $error ) {
				    		echo $error."<br/>";
				    	}
				    ?>
				</div>
<?php endif;?>		     
     
<form method = 'post' action='form/send' autocomplete = 'off' enctype = 'multipart/form-data'>
<div class='input-group space'><span class='input-group-addon'>First Name</span><input type='text' class = 'form-control' name = 'fname' value = "<?php echo isset($_POST["name"])?$_POST["name"]:"" ?>" placeholder = 'First Name' required></div>
<div class='input-group space'><span class='input-group-addon'>Last Name</span><input type='text' class = 'form-control' name = 'lname' placeholder = 'Last Name' required></div>
<div class='input-group space'><span class='input-group-addon'>Email</span><input type='email' class = 'form-control' name = 'email' value = "<?php echo isset($_POST["email"])?$_POST["email"]:"" ?>" placeholder = 'Email Address' required></div>
<div class='input-group space'><span class='input-group-addon'>Message</span><textarea class="form-control" rows="3" name = "message" required></textarea>
</div>
<?= View::get_captcha()?>

<input type = 'submit' style = "background-color:#5198D8; color:white;margin-top:10px;border:none" class = 'btn btn-default' value = 'Submit' style="background-color:#7F1E1E;border:#7F1E1E;color:#FFF;">
</form>


