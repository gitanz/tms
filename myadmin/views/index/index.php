<?php
	/**
	 * index page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 12th Dec 2013
	 */
	 
	 require_once('views/_templates/sidebar.php');
?>
		<div class="content">
        	<div class="header">
            	<h1 class="page-title">Dashboard</h1>
            </div> <!-- .header -->
            <ul class="breadcrumb">
        	    <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
    	        <li class="active">Dashboard</li>
	        </ul>
            
            <div class="container-fluid">
            	
                <div class="row-fluid">
					
                    <div class="row-fluid">
                    	<div class="block">
        					<a href="#page-stats" class="block-heading" data-toggle="collapse">Latest Stats</a>
						    <div id="page-stats" class="block-body collapse in">
					            <div class="stat-widget-container">
					                <div class="stat-widget">
                    					<div class="stat-button">
                                            <p class="title"><?=number_format($this->menuTotal)?></p>
                                            <p class="detail">Menu</p>
                                        </div>
                                    </div>

                                    <div class="stat-widget">
                                        <div class="stat-button">
                                            <p class="title"><?=number_format($this->pagesTotal)?></p>
                                            <p class="detail">Pages</p>
                                        </div>
                                    </div>

                                    <div class="stat-widget">
                                        <div class="stat-button">
                                            <p class="title"><?=number_format($this->visitsTotal)?></p>
                                            <p class="detail">Total Visits</p>
                                        </div>
                                    </div>

                                    <div class="stat-widget">
                                        <div class="stat-button">
                                            <p class="title"><?=number_format($this->uniqueVisitsTotal)?></p>
                                            <p class="detail">Today Visits</p>
                                        </div>
                                    </div>
				            	</div>
				        	</div>
                    	</div> <!-- .block -->
                    </div> <!-- .row-fluid -->
                    
                    <div class="row-fluid">
                        <div class="block span6">
                        	<div class="block-heading">
                                <span class="block-icon pull-right">
                                    <a href="<?=ADMIN_URL?>/menu/create"  rel="tooltip" title="Create New Menu"><i class="icon-plus-sign"></i></a>
                                </span>
                    
                                <a href="#tablemenu" data-toggle="collapse">Recently Added Menu<span class="label label-important"  rel="tooltip" title="Total Menu"><?=number_format($this->menuTotal)?></span></a>
                            </div>                        	
                            <div id="tablemenu" class="block-body collapse in">
                            	<table class="table">
                                	<thead>
                                        <tr>
                                          <th>Title</th>
                                          <th>Type</th>
                                          <th>Added Date</th>
                                        </tr>
                                  	</thead>
                                  	<tbody>
                                  	<?php
								  		if( $this->menus ):
											foreach( $this->menus as $menu  ):
								  	?>
                                    	<tr>
                                            <td><a href="<?=ADMIN_URL?>/menu/update/<?=$menu->nav_id?>"><?=$this->text_cut($menu->nav_title)?></a></td>
                                            <td><?=$menu->nav_type?></td>
                                            <td><?=$menu->added?></td>
                                    	</tr>
                                  	<?php
											endforeach;
								  		else:
								  	?>
                                    	<tr>
                                            <td colspan="3">
                                            <div class="alert alert-error">
                                                Menu is not created yet. Create new menu to display here.
                                            </div>
                                            </td>
                                    	</tr>
                                 	<?php endif; ?>
                                  </tbody>
                                </table>
                                <p><a href="<?=ADMIN_URL?>/menu/lists">More...</a></p>
                            </div>
                        </div>
                        <div class="block span6">
                        	<div class="block-heading">
                                <span class="block-icon pull-right">
                                    <a href="<?=ADMIN_URL?>/pages/create"  rel="tooltip" title="Create New Page"><i class="icon-plus-sign"></i></a>
                                </span>
                    
                                <a href="#tablepage" data-toggle="collapse">Recently Added Pages<span class="label label-important"  rel="tooltip" title="Total Menu"><?=number_format($this->pagesTotal)?></span></a>
                            </div>
                            <div id="tablepage" class="block-body collapse in">
                            	<table class="table">
                                	<thead>
                                        <tr>
                                          	<th>Title</th>
                                        	<th>Added</th>
                                        </tr>
                                  	</thead>
                                  	<tbody>
                                    <?php
								  		if( $this->pages ):
											foreach( $this->pages as $page  ):
								  	?>
                                    	<tr>
                                            <td><a href="<?=ADMIN_URL?>/pages/update/<?=$page->page_id?>"><?=$this->text_cut($page->page_title)?></a></td>                                    
                                            <td><?=$page->added?></td>
                                    	</tr>
                                  	<?php
											endforeach;
								  		else:
								  	?>
                                    	<tr>
                                            <td colspan="2">
                                            <div class="alert alert-error">
                                                Page is not created yet. Create new page to display here.
                                            </div>
                                            </td>
                                    	</tr>
                                 	<?php endif; ?>
                                  </tbody>
                                </table>
                                <p><a href="<?=ADMIN_URL?>/pages/lists">More...</a></p>
                            </div>
                        </div>
                	</div><!-- .row-fluid -->
                	
                    <div class="row-fluid">
                        <div class="block span6">
                            <div class="block-heading">
                                <a href="#widget2visits" data-toggle="collapse">Latest Visits<span class="label label-important"><?=number_format($this->visitsTotal)?></span></a>
                            </div>
                            <div id="widget2visits" class="block-body collapse in">
								<table class="table list">
                                	<tbody>
                                  	<?php
								  		if( $this->visits ):
											foreach( $this->visits as $visit  ):
								  	?>
                                    	<tr>
                                            <td><p><i class="icon-eye-open"></i> <?=$visit->ip_adr?></p></td>
                                            <td><p><?=$visit->country?></p></td>
                                            <td>
                                            	<p><?=$visit->visit_date?> <?=$visit->times?></p>
                                            </td>
                                    	</tr>
                                  	<?php
											endforeach;
								  		else:
								  	?>
                                    	<tr>
                                            <td colspan="3">
                                            <div class="alert alert-error">
                                                Your site is not visited yet.
                                            </div>
                                            </td>
                                    	</tr>
                                 	<?php endif; ?>
                                  	</tbody>
                                </table>
                            </div>
                        </div>
                		<div class="block span6">
                            <div class="block-heading">
                                <span class="block-icon pull-right">
                                    <a href="#" class="demo-cancel-click" rel="tooltip" title="Click to refresh"><i class="icon-refresh"></i></a>
                                </span>
                    
                                <a href="#widget2container" data-toggle="collapse">Job Applications</a>
                            </div>
                            <div id="widget2container" class="block-body collapse in">
                                <table class="table list">
                                  <tbody>
                                      <tr>
                                          <td>
                                              <p><i class="icon-user"></i> Mark Otto</p>
                                          </td>
                                          <td>
                                              <p>Amount: $1,247</p>
                                          </td>
                                          <td>
                                              <p>Date: 7/19/2012</p>
                                              <a href="#">View Transaction</a>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              <p><i class="icon-user"></i> Audrey Ann</p>
                                          </td>
                                          <td>
                                              <p>Amount: $2,793</p>
                                          </td>
                                          <td>
                                              <p>Date: 7/12/2012</p>
                                              <a href="#">View Transaction</a>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              <p><i class="icon-user"></i> Mark Tompson</p>
                                          </td>
                                          <td>
                                              <p>Amount: $2,349</p>
                                          </td>
                                          <td>
                                              <p>Date: 3/10/2012</p>
                                              <a href="#">View Transaction</a>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              <p><i class="icon-user"></i> Ashley Jacobs</p>
                                          </td>
                                          <td>
                                              <p>Amount: $1,192</p>
                                          </td>
                                          <td>
                                              <p>Date: 1/19/2012</p>
                                              <a href="#">View Transaction</a>
                                          </td>
                                      </tr>
                                        
                                  </tbody>
                                </table>
                            </div>
                        </div>
                        
                	</div> <!-- .row-fluid -->
                    
                </div> <!-- .row-fluid -->
                
            </div> <!-- .container-fluid -->
            
        </div> <!-- .content -->