<?php
	/**
	 * menu list page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 18th Dec 2013
	 */
	 
	require_once('views/_templates/sidebar.php');	
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Menu</h1>
    	    </div>        
            <ul class="breadcrumb">
	            <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
        	    <li class="active">Menu</li>
	        </ul>
	        <div class="container-fluid">
    	        <div class="row-fluid">
                	<form action="<?=ADMIN_URL?>/menu/deleteall" method="post">
                	<div class="btn-toolbar">
                    	<button class="btn btn-danger" type="submit"><i class="icon-remove"></i> Delete</button>
                        <a class="btn btn-primary" href="<?=ADMIN_URL?>/menu/create"><i class="icon-plus"></i> New Menu</a>
                      	<div class="btn-group"></div>
                    </div>
                    <?php if($this->confirmDelete == true): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete?</p> 
                        <a class="btn btn-danger" href="<?=ADMIN_URL?>/menu/delete/<?=$this->navid?>/<?=$this->confirmDelete?>">Yes</a> <a class="btn" href="<?=ADMIN_URL?>/menu/lists" type="submit">No</a>
                	</div>
					<?php endif; ?>
                    <?php if(isset($this->deleteAll)): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete all?</p> 
                        <button class="btn btn-danger" type="submit" name="yesall" value="true">Yes</button> <a class="btn" href="<?=ADMIN_URL?>/menu/lists" type="submit">No</a>
                	</div>
					<?php endif; ?>
                    <?php if (isset($_COOKIE['MenuCookie'])) : ?>
                	<div class="alert alert-success">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
                        Menu is <?=$_COOKIE['MenuCookie']?> successfully.
                	</div>
	                <?php setcookie ("MenuCookie", "", time() - 3600); endif; ?>
					<div class="well">
	               		<table class="table table-striped">
    	                   	<thead>
        	                	<tr>
            	              		<th><label class="checkbox"><input type="checkbox" id="selectall" <?php if(isset($_POST['navid'])) echo 'checked'; ?> /> ID</label></th>
		                            <th>Title</th>
                                    <th>Location</th>
                		            <th>Added Date</th>
                        		    <th></th>
                               	</tr>
                            </thead>
                            <tbody>
                            <?php 
								if (!empty($this->menus)) :
									echo $this->menus;
								else:
							?>
                            	<tr>
                                	<td colspan="5" align="center">
                                    <div class="alert alert-error">
									    Menu is not created yet. Create new menu to display here.
								    </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                       	</table>
					</div> <!-- .well -->
                    </form>
				</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->