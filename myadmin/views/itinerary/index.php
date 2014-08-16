<?php
	/**
	 * itinerary list
	 * @package admin-login
	 * @date 20th Jun 2014
	 */
	 
	require_once('views/_templates/sidebar.php');	
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Itineraries</h1>
    	    </div>        
            <ul class="breadcrumb">
	            <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
        	    <li class="active">Itineraries</li>
	        </ul>
	        <div class="container-fluid">
    	        <div class="row-fluid">
                	<form action="<?=ADMIN_URL?>/itineraries/deleteall" method="post">
                	<div class="btn-toolbar">
                    	<button class="btn btn-danger" type="submit"><i class="icon-remove"></i> Delete</button>
                        <a class="btn btn-primary" href="<?=ADMIN_URL?>/itineraries/create"><i class="icon-plus"></i> New Itinerary </a>
                      	
                    </div>
                    <?php if($this->confirmDelete == true): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete?</p> 
                        <a class="btn btn-danger" href="<?=ADMIN_URL?>/itineraries/delete/<?=$this->delid?>/<?=$this->nid?>/<?=$this->confirmDelete?>">Yes</a> <a class="btn" href="<?=ADMIN_URL?>/menu/lists" type="submit">No</a>
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
					    

                        <div class="row-fluid">
                            <div class = "well">
                                    <input type="search" id="search" value="" class="form-control" placeholder="Search Itinerary">
                                <div class="col-lg-4 col-lg-offset-4">
                                </div>
                        
                                <div class="col-lg-12">
                                    <table class="table" id="table">
                                        <thead>
                                            <tr>
                                                <th><label class="checkbox"><input type="checkbox" id="selectall" <?php if(isset($_POST['itid'])) echo 'checked'; ?> /> ID</label></th>
                                                <th>Itinerary Title </th>
                                                <th>Featured</th>
                                                <th>Added</th>
                                                <th></th>    
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($this->itineraries as $trip):?>
                                            <tr>
                                                <?php if( isset($_POST['itid']) ):                   
                                                    $inPag = $_POST['itid'];
                                                    $checked = array_key_exists($trip->trip_id, $inPag) ? ' checked' : '';
                                                else:
                                                    $checked = '';
                                                endif;
                                                echo '<td><label class="checkbox"><input type="checkbox" class="checkbxtd" name="itid['.$trip->trip_id.']"'.$checked.' />'.$trip->trip_id.'</label></td>';
                                                echo '<td><a href="'.ADMIN_URL.'/itineraries/update/'.$trip->trip_id.'" title="Edit" rel="tooltip">'.stripslashes($trip->trip_title).'</a></td>';?>
                                                <td><?php echo ($trip->trip_feature == 1)? "Yes" : "No"?></td>
                                                <td><?=$trip->added?></td>
                                               <?php  echo '<td>
                                                <a href="'.ADMIN_URL.'/itineraries/update/'.$trip->trip_id.'" title="Edit" rel="tooltip"><i class="icon-pencil"></i></a>
                                                <a href="'.ADMIN_URL.'/itineraries/info/'.$trip->trip_id.'" title="Trip Info" rel="tooltip"><i class="icon-bookmark"></i></a>
                                                <a href="'.ADMIN_URL.'/itineraries/cost/'.$trip->trip_id.'" title="Trip Cost" rel="tooltip"><strong>$$</strong></a>
                                                <a href="'.ADMIN_URL.'/itineraries/gallery/'.$trip->trip_id.'" title="Trip Gallery" rel="tooltip"><i class="icon-picture"></i></a>
                                                <a href="'.ADMIN_URL.'/itineraries/video/'.$trip->trip_id.'" title="Trip Video" rel="tooltip"><i class="icon-film"></i></a>
                                                <a href="'.ADMIN_URL.'/itineraries/review/'.$trip->trip_id.'" title="Trip Review" rel="tooltip"><i class="icon-film"></i></a>
                                                <a href="'.ADMIN_URL.'/itineraries/delete/'.$trip->trip_id.'/'.$trip->trip_parent.'" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>';
                                                
                                                echo '</tr>';?>

                                            </tr>
                                        <?php endforeach;?>                                                                                        
                                        </tbody>
                                    </table>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    <?php if($this->links) echo $this->links; ?>
                    </form>
				</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->