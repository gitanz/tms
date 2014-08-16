<?php
	/**
	 * database creation form
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 01st Jan 2014
	 */
	 
	require_once('views/_templates/sidebar.php');
	
	$bk_title = str_replace(' ', '_', strtolower(SITE_NAME));
	$bk_type = isset($_POST['backup_type']) ? $_POST['backup_type'] : 0;
	$bk_email = isset($_POST['backup_email']) ? $_POST['backup_email'] : '';

?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Create Database Backup</h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/systems/backup">Database Backup</a> <span class="divider">/</span></li>
                <li class="active">Create Database Backup</li>
            </ul>
            
           	<div class="container-fluid">
            	<div class="row-fluid">
                <?php if (isset($this->errors)) : ?>
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
				    <form id="pageForm" action="<?=ADMIN_URL?>/system/backup_save" method="post" autocomplete="off">
				        <label>Backup Title *</label>
				        <input type="text" name="backup_title" value="<?=$bk_title?>" class="input-xlarge" placeholder="Enter backup title here" />
				        <label>Save as</label>
				        <select name="backup_type" id="backup_type">
                        	<option value="0" <?php if($bk_type == 0) echo 'selected'; ?>>Default</option>
                            <option value="1" <?php if($bk_type == 1) echo 'selected'; ?>>Mail</option>
                        </select>
                        <label>Email</label>
				        <input type="text" name="backup_email" value="<?=$bk_email?>" class="input-xlarge" placeholder="Enter email address here" />
                        <pan class="help-block">If you select mail save as option then you have to enter email.</span>
                        <hr />
                        <div>
                       		<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
                        </div>
				    </form>
					</div>
               	</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->