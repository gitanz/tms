<?php
	/**
	 * Publication list page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 25th Dec 2013
	 */
	 
	require_once('views/_templates/sidebar.php');	
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">News and Events</h1>
    	    </div>        
            <ul class="breadcrumb">
	            <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
        	    <li class="active">News and Events</li>
	        </ul>
	        <div class="container-fluid">
    	        <div class="row-fluid">
                	<form action="<?=ADMIN_URL?>/news/deleteall" method="post">
                	<div class="btn-toolbar">
                    	<!-- <button class="btn btn-danger" type="submit"><i class="icon-remove"></i> Delete</button> -->
                        <a class="btn btn-primary" href="<?=ADMIN_URL?>/news/create"><i class="icon-plus"></i> New News/Event</a>
                    </div>
                                                      
                    <?php if($this->confirmDelete == true): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete?</p> 
                        <a class="btn btn-danger" href="<?=ADMIN_URL?>/news/confirmDelete/<?=$this->newsid?>">Yes</a> <a class="btn" href="<?=ADMIN_URL?>/news/lists" type="submit">No</a>
                	</div>
					<?php endif; ?>

					<?php if(($this->deleteError)): ?>
					<div class="alert alert-error">
                        <p>Sorry! Could not process your request.</p> 
                    </div>
					<?php endif; ?>
					

                    <?php if(isset($this->deleteAll)): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete all?</p> 
                        <button class="btn btn-danger" type="submit" name="yesall" value="true">Yes</button> <a class="btn" href="<?=ADMIN_URL?>/news/lists" type="submit">No</a>
                	</div>
					<?php endif; ?>
                    <?php if (isset($_COOKIE['NewsCookie'])) : ?>
                	<div class="alert alert-success">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
                        News is <?=$_COOKIE['NewsCookie']?> successfully.
                	</div>
	                <?php setcookie ("NewsCookie", "", time() - 3600); endif; ?>
	                <?php if (isset($_COOKIE['NewsCookieFail'])) : ?>
                	<div class="alert alert-error">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
                        News not <?=$_COOKIE['NewsCookieFail']?> successfully.
                	</div>
	                <?php setcookie ("NewsCookieFail", "", time() - 3600); endif; ?>
	                
					<div class="well">
	               		<table class="table table-striped">
    	                   	<thead>
        	                	<tr>
            	              		<th><label class="checkbox"><input type="checkbox" id="selectall" <?php if(isset($_POST['newsid'])) echo 'checked'; ?> /> ID</label></th>
		                            <th>Title</th>
                                    <th>Type</th>
                                    <th>Added Date</th>
                               	</tr>
                            </thead>
                            <tbody>
                            <?php 
								if ($this->news) :
									foreach($this->news as $value) :										
										if( isset($_POST['newsid']) ):  					
											$inPag = $_POST['newsid'];
											$checked = array_key_exists($value->news_id, $inPag) ? ' checked' : '';
										else:
											$checked = '';
										endif;
										if($value->news_type == 0)
										$type = 'Case Story';
										elseif($value->news_type == 1)
										$type = 'Newsletter';
										elseif($value->news_type == 2)
										$type = 'Book';
										elseif($value->news_type == 3)
										$type = 'Research Paper';
										elseif($value->news_type == 4)
										$type = 'Other Reports';
										echo '<tr>';
										echo '<td><label class="checkbox"><input type="checkbox" class="checkbxtd" name="newsid['.$value->news_id.']"'.$checked.' />'.$value->news_id.'</label></td>';
										echo '<td><a href="'.ADMIN_URL.'/news/update/'.$value->news_id.'" title="'.$value->news_title.'" rel="tooltip">'.$this->text_cut($value->news_title).'</a></td>';
										echo '<td>'.$type.'</td>';
										echo '<td>'.$value->added.'</td>';
										echo '<td>
										<a href="'.ADMIN_URL.'/news/update/'.$value->news_id.'" title="Edit" rel="tooltip"><i class="icon-pencil"></i></a>
                                    	<a href="'.ADMIN_URL.'/news/delete/'.$value->news_id.'" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>';
										echo '</tr>';
									endforeach;
								else:
							?>
                            	<tr>
                                	<td colspan="4" align="center">
                                    <div class="alert alert-error">
									    News or Events not added yet. Add to display here.
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