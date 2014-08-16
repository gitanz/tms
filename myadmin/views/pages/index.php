<?php
	/**
	 * page list page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 25th Dec 2013
	 */
	 
	require_once('views/_templates/sidebar.php');	
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Pages</h1>
    	    </div>        
            <ul class="breadcrumb">
	            <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
        	    <li class="active">Pages</li>
	        </ul>
	        <div class="container-fluid">
    	        <div class="row-fluid">
                	<form action="<?=ADMIN_URL?>/pages/deleteall" method="post">
                	<div class="btn-toolbar">
                    	<button class="btn btn-danger" type="submit"><i class="icon-remove"></i> Delete</button>
                        <a class="btn btn-primary" href="<?=ADMIN_URL?>/pages/create"><i class="icon-plus"></i> New Page</a>
                      	<div class="btn-group">
                            <a class="btn">Filter Page by Menu</button>
	                            <a class="btn dropdown-toggle" data-toggle="dropdown">
    	                        <span class="caret"></span>
                            </a>
                            
                            <ul class="dropdown-menu" id="dropdown-limited">
                                <li><a href="<?=ADMIN_URL?>/pages/lists">View All</a></li>
                                <?=$this->adjacency?>
                            </ul>
                        </div>
                    </div>
                    <?php if($this->confirmDelete == true): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete?</p> 
                        <a class="btn btn-danger" href="<?=ADMIN_URL?>/pages/delete/<?=$this->pagid?>/<?=$this->confirmDelete?>">Yes</a> <a class="btn" href="<?=ADMIN_URL?>/menu/lists" type="submit">No</a>
                	</div>
					<?php endif; ?>
                    <?php if(isset($this->deleteAll)): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete all?</p> 
                        <button class="btn btn-danger" type="submit" name="yesall" value="true">Yes</button> <a class="btn" href="<?=ADMIN_URL?>/menu/lists" type="submit">No</a>
                	</div>
					<?php endif; ?>
                    <?php if (isset($_COOKIE['PageCookie'])) : ?>
                	<div class="alert alert-success">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
                        Page is <?=$_COOKIE['PageCookie']?> successfully.
                	</div>
	                <?php setcookie ("PageCookie", "", time() - 3600); endif; ?>
					<div class="well">
	               		<table class="table table-striped">
    	                   	<thead>
        	                	<tr>
            	              		<th><label class="checkbox"><input type="checkbox" id="selectall" <?php if(isset($_POST['pagid'])) echo 'checked'; ?> /> ID</label></th>
		                            <th>Title</th>
                                    <th>Homepage</th>
                		            <th>Added Date</th>
                        		    <th></th>
                               	</tr>
                            </thead>
                            <tbody>
                            <?php 
								if ($this->pages) :
									foreach($this->pages as $value) :										
										
										if( isset($_POST['pagid']) ):  					
											$inPag = $_POST['pagid'];
											$checked = array_key_exists($value->page_id, $inPag) ? ' checked' : '';
										else:
											$checked = '';
										endif;
										$home = $value->page_home == 1 ? 'Yes' : 'No';
										echo '<tr>';
										echo '<td><label class="checkbox"><input type="checkbox" class="checkbxtd" name="pagid['.$value->page_id.']"'.$checked.' />'.$value->page_id.'</label></td>';
										echo '<td><a href="'.ADMIN_URL.'/pages/update/'.$value->page_id.'" title="'.$value->page_title.'" rel="tooltip">'.$this->text_cut($value->page_title).'</a></td>';
										echo '<td>'.$home.'</td>';
										echo '<td>'.$value->added.'</td>';
										echo '<td><a href="'.SITE_URL.'/index/page/'.$value->page_alias.'" title="Preview" rel="tooltip" target="_blank"><i class="icon-globe"></i></a>
										<a href="'.ADMIN_URL.'/pages/update/'.$value->page_id.'" title="Edit" rel="tooltip"><i class="icon-pencil"></i></a>
                                    	<a href="'.ADMIN_URL.'/pages/delete/'.$value->page_id.'" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>';
										echo '</tr>';
									endforeach;
								else:
							?>
                            	<tr>
                                	<td colspan="4" align="center">
                                    <div class="alert alert-error">
									    Page is not created yet. Create new page to display here.
								    </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                       	</table>
					</div> <!-- .well -->
                    <?php if($this->links) echo $this->links; ?>
                    </form>
				</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->