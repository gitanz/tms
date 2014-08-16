<?php
	/**
	 * site counter page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 17th Dec 2013
	 */
	 
	require_once('views/_templates/sidebar.php');
?>
		<div class="content">        
	        <div class="header">            
           		<div class="stats">
                    <p class="stat"><span class="number"><?=number_format($this->visitToday->counts)?></span> Visits today</p>
                    <p class="stat"><span class="number"><?=number_format($this->visitTotal)?></span> Total visits</p>
                </div>
	            <h1 class="page-title">Counter</h1>
    	    </div>        
            <ul class="breadcrumb">
	            <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
        	    <li class="active">Counter</li>
	        </ul>
	        <div class="container-fluid">
    	        <div class="row-fluid">
					<div class="faq-content">
					    <div class="row-fluid">
			    		    <div class="span9">
                            	<div class="block">
                                    <p class="block-heading">Site Visitors Stat</p>
                                    <div class="block-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                      <th>IP</th>
                                                      <th>Country</th>
                                                      <th>Visited on</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            if ( $this->siteVisits ) :
                                                $row = 1;
                                                foreach($this->siteVisits as $visit) :
                                            ?>
                                                <tr>
                                                    <td><?=$row?></td>
                                                    <td><?=$visit->ip_adr?></td>
                                                    <td><?=$visit->country?></td>
                                                    <td><?=$visit->visit_date?> <?=$visit->times?></td>
                                                </tr>
                                            <?php
                                                $row++;
                                                endforeach;
                                            else:
                                            ?>
                                                <tr>
                                                    <td colspan="5" align="center">
                                                        <div class="alert alert-error">
                                                            No visitors have visited yet.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>                                    
                                          </tbody>
                                        </table>                                        
                                    </div>
                                    <?php if($this->links) echo $this->links; ?>
                                </div>
                                
                                <div class="block">
                                    <p class="block-heading">Page Visitors Stat</p>
                                    <div class="block-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                      <th>IP</th>
                                                      <th>Page</th>
                                                      <th>Country</th>
                                                      <th>Visited on</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            if ( $this->pageVisits ) :
                                                $row = 1;
                                                foreach($this->pageVisits as $visit) :
													$onpage = $visit->on_page;
													$onpage = View::getPageAlias($onpage);
                                            ?>
                                                <tr>
                                                    <td><?=$row?></td>
                                                    <td><?=$visit->ip_adr?></td>
                                                    <td><a href="<?=SITE_URL?>/index/page/<?=$onpage?>" rel="tooltip" title="Visit Page" target="_blank"><?=$onpage?></a></td>
                                                    <td><?=$visit->country?></td>
                                                    <td><?=$visit->visit_date?> <?=$visit->times?></td>
                                                </tr>
                                            <?php
                                                $row++;
                                                endforeach;
                                            else:
                                            ?>
                                                <tr>
                                                    <td colspan="5" align="center">
                                                        <div class="alert alert-error">
                                                            No visitors have visited site page yet.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>                                    
                                          </tbody>
                                        </table>
                                    </div>
                                    <?php if($this->linkss) echo $this->linkss; ?>
                                </div>
                                
                            </div> <!-- .span9 -->
                            <div class="span3">
					            <div class="toc">
					                <h3>Popular Pages</h3>
                                    <?php if($this->getPopularPages): ?>
                                    <ol>
                                    <?php 
										foreach( $this->getPopularPages as $page ):
											$onpage = View::getPageAlias($page->on_page); 
									?>
                                        <li><a href="<?=SITE_URL?>/index/page/<?=$onpage?>" rel="tooltip" title="Visit Page" target="_blank"><?=$onpage?></a> (<?=$page->cnt?>)</li>
                                    <?php endforeach; ?>
                                    </ol>
                                    <?php endif; ?>
    				        	</div>
                                <div class="toc">
					                <h3>Visits By Country</h3>
                                    <?php if( $this->getPopularCountries ): ?>
                                    <ol>
                                    <?php foreach( $this->getPopularCountries as $country ): ?>
                                        <li><span><?=$country->country?> (<?=$country->visits_country?>)</span></li>
                                    <?php endforeach; ?>
                                    </ol>
                                    <?php endif; ?>
    				        	</div>
			                </div> <!-- .span3 -->            			    
                        </div> <!-- .row-fluid -->
                    </div> <!-- .faq-content -->					
				</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->