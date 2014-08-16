<?php
	/**
	 * login page to the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 11th Dec 2013
	 */
?>
		<div class="row-fluid">        	
    		<div class="dialog">
            <?php if (isset($this->errors)) : ?>
                <div class="alert alert-error">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                <?php 
					foreach ($this->errors as $error) : 
						echo $error.'<br />';
					endforeach; 
				?>
                </div>
           	<?php endif; ?>
        		<div class="block">
            		<p class="block-heading">Sign In</p>
            		<div class="block-body">
                	<form action="<?=ADMIN_URL?>/users/login" autocomplete="off" method="post">
                    	<label>Username</label>
	                    <input type="text" class="span12" name="username">
    	                <label>Password</label>
        	            <input type="password" class="span12" name="password">
                        <button type="submit" class="btn btn-primary pull-right">Sign In</button>
                	    <label class="remember-me"><input type="checkbox" name="rememberme"> Remember me</label>
                    	<div class="clearfix"></div>
                        <input type="hidden" name="continue" value="<?=!empty($_REQUEST['continue']) ? $_REQUEST['continue'] : ''?>">
	                </form>
            		</div>
        		</div>
        		<p class="pull-right" style=""><a href="http://www.axilcreations.com" target="blank" title="CMS by Axil Creations">Powered by AxilTMS</a></p>
        		<!--<p><a href="reset-password.html">Forgot your password?</a></p>-->
    		</div>
		</div>

        <script>
			$(function() {    
    			// the simple countdown that happens after your tried to login with a wrong password 3+ times:
			    if ($('#failed-login-countdown-value').length > 0) {        
			        seconds = $('#failed-login-countdown-value').text();      
        
        			setInterval( function() {            
		            	if (seconds > 0 ) {                
        		        	seconds--;
	                		$('#failed-login-countdown-value').text(seconds);                                
			            } else {
        			        $('#failed-login-countdown-value').parent().slideUp();
	        		    }            
    		    	}, 1000);        
		    	}	
			});
		</script>