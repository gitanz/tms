<?php
	/**
	 * user profile page to the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 15th Dec 2013
	 */
	 
	 require_once('views/_templates/sidebar.php');
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">User Profile</h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/users/admins">Users</a> <span class="divider">/</span></li>
                <li class="active">User</li>
            </ul>
            
        	<div class="container-fluid">
            	<div class="row-fluid">
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
	                <div class="well">
    					<ul class="nav nav-tabs">
					    	<li<?=(!isset($_POST['password'])) ? ' class="active"' : '' ?>><a href="#profile" data-toggle="tab">Profile</a></li>
	                        <li<?=isset($_POST['password']) ? ' class="active"' : '' ?>><a href="#password" data-toggle="tab">Password</a></li>
    					</ul>
					
                    	<div id="myTabContent" class="tab-content">
      						<div class="tab-pane <?=(!isset($_POST['password'])) ? 'active in"' : 'fade' ?>" id="profile">
                            <form id="tab" method="post" action="<?=ADMIN_URL?>/users/save" autocomplete="off">
                                <label>Full Name</label>
                                <input type="text" value="<?php echo stripslashes($this->profile->user_fullname); ?>" class="input-xxlarge" name="full_name" required="required" />
                                <label>Username</label>
                                <input type="text" value="<?php echo stripslashes($this->profile->user_name); ?>" class="input-xxlarge"  name="user_name" required="required" />
                                <label>Email</label>
                                <input type="email" value="<?php echo stripslashes($this->profile->user_email); ?>" class="input-xxlarge"  name="user_email" required="required" />
                                <div>
                                    <button class="btn btn-primary" type="submit" autocomplete="off">Update</button>
                                </div>
                                <input type="hidden" value="true" name="profile" />
                                <input type="hidden" value="<?=isset($id) ? $id : Session::get('admin_id') ?>" name="id" />
                            </form>
                            </div>                           
                            <div class="tab-pane <?=isset($_POST['password']) ? 'active in"' : 'fade' ?>" id="password">
                            <form id="tab2" method="post" action="<?=ADMIN_URL?>/users/save" autocomplete="off">                            	
                                <label>Current Password</label>
                                <input type="password" value="" class="input-xxlarge" name="old_passwrd" required="required" />
                                <label>New Password</label>
                                <input type="password" value="" class="input-xxlarge" name="new_passwrd" required="required" />
                                <label>Confirm Password</label>
                                <input type="password" value="" class="input-xxlarge" name="new_cpassword" required="required" />
                                <div>
    		                        <button class="btn btn-primary">Update</button>
                                </div>
                                <input type="hidden" value="true" name="password" />
	                            <input type="hidden" value="<?=isset($id) ? $id : Session::get('admin_id') ?>" name="id" />
                            </form>
                            </div>                            
						</div> <!-- .tab-content -->
					</div> <!-- .well -->
				</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->