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
	            <h1 class="page-title">Testimonials</h1>
    	    </div>        
            <ul class="breadcrumb">
	            <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
        	    <li class="active">Testimonials</li>
	        </ul>
	        <div class="container-fluid">
    	        <div class="row-fluid">
                	<form action="<?=ADMIN_URL?>/testimonials/deleteall" method="post">
                	<div class="btn-toolbar">
                    	<!-- <button class="btn btn-danger" type="submit"><i class="icon-remove"></i> Delete</button> -->
                        <a class="btn btn-primary" href="<?=ADMIN_URL?>/testimonials/create"><i class="icon-plus"></i> New Testimonial</a>
                    </div>
                                                      
                    <?php if($this->confirmDelete == true): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete?</p> 
                        <a class="btn btn-danger" href="<?=ADMIN_URL?>/testimonials/confirmDelete/<?=$this->testiid?>">Yes</a> <a class="btn" href="<?=ADMIN_URL?>/testimonials/lists" type="submit">No</a>
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
                        <button class="btn btn-danger" type="submit" name="yesall" value="true">Yes</button> <a class="btn" href="<?=ADMIN_URL?>/testimonials/lists" type="submit">No</a>
                	</div>
					<?php endif; ?>
                    <?php if (isset($_COOKIE['TestimonialCookie'])) : ?>
                	<div class="alert alert-success">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
                        Testimonial is <?=$_COOKIE['TestimonialCookie']?> successfully.
                	</div>
	                <?php setcookie ("TestimonialCookie", "", time() - 3600); endif; ?>
	                <?php if (isset($_COOKIE['TestimonialCookieFail'])) : ?>
                	<div class="alert alert-error">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
                        Testimonial not <?=$_COOKIE['TestimonialCookieFail']?> successfully.
                	</div>
	                <?php setcookie ("TestimonialCookieFail", "", time() - 3600); endif; ?>
	                
					<div class="well">
	               		<table class="table table-striped">
    	                   	<thead>
        	                	<tr>
            	              		<th><label class="checkbox"><input type="checkbox" id="selectall" <?php if(isset($_POST['testiid'])) echo 'checked'; ?> /> ID</label></th>
		                            <th>Title</th>
                                    <th>Added Date</th>
                               	</tr>
                            </thead>
                            <tbody>
                            <?php 
								if ($this->testimonials) :
									foreach($this->testimonials as $value) :										
										if( isset($_POST['testiid']) ):  					
											$inPag = $_POST['testiid'];
											$checked = array_key_exists($value->testimonial_id, $inPag) ? ' checked' : '';
										else:
											$checked = '';
										endif;

										echo '<tr>';
										echo '<td><label class="checkbox"><input type="checkbox" class="checkbxtd" name="testiid['.$value->testimonial_id.']"'.$checked.' />'.$value->testimonial_id.'</label></td>';
										echo '<td><a href="'.ADMIN_URL.'/testimonials/update/'.$value->testimonial_id.'" title="'.$value->testimonial_title.'" rel="tooltip">'.$this->text_cut($value->testimonial_title).'</a></td>';
										echo '<td>'.$value->added.'</td>';
										echo '<td>';
										if($value->testimonial_unseen == '1') echo '<span style = "color:red;text-decoration: italic;"><em>New</em></span>';
										echo '
										<a href="'.ADMIN_URL.'/testimonials/update/'.$value->testimonial_id.'" title="Edit" rel="tooltip"><i class="icon-pencil"></i></a>
                                    	<a href="'.ADMIN_URL.'/testimonials/delete/'.$value->testimonial_id.'" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>';
										echo '</tr>';
									endforeach;
								else:
							?>
                            	<tr>
                                	<td colspan="4" align="center">
                                    <div class="alert alert-error">
									    Testimonial not added yet. Add testimonials to display here.
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