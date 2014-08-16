<?php
	/**
	 * gallery list page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 03rd Jan 2014
	 */
	 
	require_once('views/_templates/sidebar.php');	
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Gallery</h1>
    	    </div>        
            <ul class="breadcrumb">
	            <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
        	    <li class="active">Gallery</li>
	        </ul>
	        <div class="container-fluid">
    	        <div class="row-fluid">
                	<form action="<?=ADMIN_URL?>/gallery/deleteall" method="post">
                	<div class="btn-toolbar">
                    	<button class="btn btn-danger" type="submit"><i class="icon-remove"></i> Delete</button>
                        <a class="btn btn-primary" href="<?=ADMIN_URL?>/gallery/create"><i class="icon-plus"></i> New Gallery</a>
                      	<div class="btn-group">
                            <!--<a class="btn">Filter Banner by Menu</button>
	                            <a class="btn dropdown-toggle" data-toggle="dropdown">
    	                        <span class="caret"></span>
                            </a>
                            
                            <ul class="dropdown-menu" id="dropdown-limited">
                                <li><a href="<?=ADMIN_URL?>/gallery/lists">View All</a></li>
                                <?=$this->adjacency?>
                            </ul>-->
                        </div>
                    </div>
                    <?php if($this->confirmDelete == true): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete?</p> 
                        <a class="btn btn-danger" href="<?=ADMIN_URL?>/gallery/delete/<?=$this->gly_id?>/<?=$this->confirmDelete?>">Yes</a> <a class="btn" href="<?=ADMIN_URL?>/gallery/lists" type="submit">No</a>
                	</div>
					<?php endif; ?>
                    <?php if(isset($this->deleteAll)): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete all?</p> 
                        <button class="btn btn-danger" type="submit" name="yesall" value="true">Yes</button> <a class="btn" href="<?=ADMIN_URL?>/gallery/lists" type="submit">No</a>
                	</div>
					<?php endif; ?>
                    <?php if (isset($_COOKIE['GalleryCookie'])) : ?>
                	<div class="alert alert-success">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
                        Gallery is <?=$_COOKIE['GalleryCookie']?> successfully.
                	</div>
	                <?php setcookie ("GalleryCookie", "", time() - 3600); endif; ?>
					<div class="well">
	               		<table class="table table-striped">
    	                   	<thead>
        	                	<tr>
            	              		<th><label class="checkbox"><input type="checkbox" id="selectall" <?php if(isset($_POST['glyid'])) echo 'checked'; ?> /> ID</label></th>
		                            <th>Title</th>
                                    <th>Total Images</th>
                		            <th>Added Date</th>
                        		    <th></th>
                               	</tr>
                            </thead>
                            <tbody>
                            <?php 
								if ($this->galleries) :
									foreach($this->galleries as $value) :										
										
										if( isset($_POST['glyid']) ):  					
											$inPag = $_POST['glyid'];
											$checked = array_key_exists($value->gly_id, $inPag) ? ' checked' : '';
										else:
											$checked = '';
										endif;
										echo '<tr>';
										echo '<td><label class="checkbox"><input type="checkbox" class="checkbxtd" name="glyid['.$value->gly_id.']"'.$checked.' />'.$value->gly_id.'</label></td>';
										echo '<td><a href="'.ADMIN_URL.'/gallery/update/'.$value->gly_id.'" title="'.$value->gly_title.'" rel="tooltip">'.$this->text_cut($value->gly_title).'</a></td>';
										echo '<td>'.$value->TotalCout.'</td>';
										echo '<td>'.$value->added.'</td>';
										echo '<td>
										<a href="'.ADMIN_URL.'/gallery/update/'.$value->gly_id.'" title="Edit" rel="tooltip"><i class="icon-pencil"></i></a>
                                    	<a href="'.ADMIN_URL.'/gallery/delete/'.$value->gly_id.'" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>';
										echo '</tr>';
									endforeach;
								else:
							?>
                            	<tr>
                                	<td colspan="4" align="center">
                                    <div class="alert alert-error">
									    Gallery is not created yet. Create new galery to display here.
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