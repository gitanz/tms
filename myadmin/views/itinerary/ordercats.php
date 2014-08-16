<?php
	/**
	 * menu order reaarange page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 20th Dec 2013
	 */
	require_once('views/_templates/sidebar.php');	
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Update Categories Order</h1>
    	    </div>
            <ul class="breadcrumb">
	            <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
	            <li><a href="<?=ADMIN_URL?>/itineraries/categories">Itinerary Categories</a> <span class="divider">/</span></li>
        	    <li class="active">Update Categories Order</li>
	        </ul>
	        <div class="container-fluid">
    	        <div class="row-fluid">
                	<div class="notification"></div>
					<div class="well">
	            <small>First three will appear on the home page</small>
                    <?=$this->categories?>	               		
					</div> <!-- .well -->
				</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->      