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
	            <h1 class="page-title">Update Menu Order</h1>
    	    </div>
            <ul class="breadcrumb">
	            <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/banners/lists">Banners</a> <span class="divider">/</span></li>
        	    <li class="active">Update Banner Order</li>
	        </ul>
	        <div class="container-fluid">
    	        <div class="row-fluid">
                	<div class="btn-toolbar">
                      	<div class="btn-group">
                            <a class="btn">Filter Banner by Menu</button>
	                            <a class="btn dropdown-toggle" data-toggle="dropdown">
    	                        <span class="caret"></span>
                            </a>
                            
                            <ul class="dropdown-menu" id="dropdown-limited">
                                <li><a href="<?=ADMIN_URL?>/banners/order">Site Banner</a></li>
                                <?=$this->adjacency?>
                            </ul>
                        </div>
                    </div>
                	<div class="notification"></div>
					<div class="well">
                    <?=$this->banners?>	               		
					</div> <!-- .well -->
				</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->      