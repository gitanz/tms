<?php
	/**
	 * gallery form for Itinerary
	 * @package admin-login
	 * @date July 7, 2014
	 */
	 
	require_once('views/_templates/sidebar.php');
$pageTitles = "Categories";
    if(!isset($this->category)){
        $catTitle = isset($_POST['category_title'])?$_POST['category_title']:"";
        $catAltTitle = isset($_POST['category_alt_title'])?$_POST['category_alt_title']:"";
        $catOverview = isset($_POST['category_overview'])?$_POST['category_overview']:"";
    	$catImg = isset($_POST['category_title'])?$_POST['category_title']:"";
        $catId = "";
        $newform = 1;
    }
    else{
        $catTitle = isset($_POST['category_title'])?$_POST['category_title']:$this->category->category_title;
        $catAltTitle = isset($_POST['category_alt_title'])?$_POST['category_alt_title']:$this->category->category_alt_title;
        $catOverview = isset($_POST['category_overview'])?$_POST['category_overview']:$this->category->category_overview;
        $catImg = isset($_POST['category_title'])?$_POST['category_title']:$this->category->category_image;
        $catId = $this->category->category_id;
        $newform = 0;
    }
	?>

	<div class="content">        
	        <div class="header">            
	            <h1 class="page-title"><?=$pageTitles?></h1>
    	    </div>
            <ul class="breadcrumb">
                <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
                <li><a href="<?=ADMIN_URL?>/itineraries/lists">Itineraries</a> <span class="divider">/</span></li>
                <li class="active"><?=$pageTitles?></li>
            </ul>
            
           	<div class="container-fluid">
            	<div class="row-fluid">
                
                <?php if (isset($this->errors)) : ?>
                	<div class = "alert alert-danger"><?php var_dump($this->errors)?></div>
                <?php endif; ?>
                <?php if (isset($this->invokedel)) : ?>
                    <div class = "alert alert-danger">
                        <span>Are you sure you want to delete</span>
                        <a href = "<?=ADMIN_URL?>/itineraries/deletecat/<?=$this->delid?>?confirm=true" class = "btn btn-danger">Yes</a>
                        <a href = "<?=ADMIN_URL?>/itineraries/categories" class = "btn">No</a>
                    </div>
                <?php endif; ?>


					<div class="well">
        	            <div class="span12">
                        <p class = "block-heading" style = "border:1px solid #A6A6A6;">Add Category</p>
                            <div class="block-body">
                				<form id="pageForm" action="<?=ADMIN_URL?>/itineraries/catsave" method="post" autocomplete="off">
						        <div class="control-group" id="fields">                        	
                        		    <div class="controls-field" id="b1">
	                            		<label>Category Title</label>
								        <input type="text" name="category_title" value="<?=$catTitle?>" class="input-xlarge" placeholder="Enter title here" />
	                                    <label>Category Alternative Title</label>
								        <input type="text" name="category_alt_title" value="<?=$catAltTitle?>" class="input-xlarge" placeholder="Enter alternative title here" />

   	                                    <label>Category Image</label>
									        <div class="input-append">
						    					<input type="text" value="<?=$catImg?>" id="catImg" name="category_image" class="input-xlarge" />
											    <a type="button" class="btn iframe-btn" href="<?=ADMIN_URL?>/libraries/filemanager/dialog.php?type=1&amp;field_id=catImg">Select</a>
											</div>
					                        <?php if (is_file( '../'.View::attachmentPathCorrect($catImg) )) : ?>
					                        <div class="block-body">
								                <a href="<?=View::attachmentFullPathCorrect($catImg)?>" class="iframe-btn">
													<img class="img-polaroid" src="<?=View::attachmentThumbPathCorrect($catImg)?>">
					                            </a>
									            <div class="clearfix"></div>
									        </div>
					                        <?php endif; ?>
	                            		<label>Content</label>
				        				<textarea rows="3" class="input-xxlarge" name="category_overview" id="tinyEditor"><?=$catOverview?></textarea>
	                            	  <input type = "hidden" name = "catid" value = <?=$catId?>>
                                      <input type = "hidden" name = "newform" value = <?=$newform?>>
                                    </div>
        	                	</div>
        		                <hr />
                		        <div>
                       				<button class="btn btn-primary"><i class="icon-save"></i> Save</button>
		                        </div>
							    </form>
				                <div class="clearfix"></div>
            				</div>
			        	</div>
                        
                        <div class = "block row">
                        <p class = "block-heading" style = "border-top:1px solid #A6A6A6">All Categories</p>
                                    <div class = "space"></div>
                                    <input type="search" id="search" value="" style = "margin-left:10px" class="form-control" placeholder="Search Categories">
                                    <a href = "<?=ADMIN_URL?>/itineraries/ordercats" class = "btn btn-primary">Update Order</a>
                                <div class="col-lg-4 col-lg-offset-4">
                                </div>
                        
                                <div class="col-lg-12">
                                    <table class="table" id="table">
                                        <thead>
                                            <tr>
                                                <th>Category Title </th>
                                                <th>Alternative Title</th>
                                                <th>Category Image</th>
                                                <th></th>    
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($this->categories as $category):?>
                                            <tr>
												<?php
                                                echo '<td><a href="'.ADMIN_URL.'/itineraries/editcat/'.$category->category_id.'" title="Edit" rel="tooltip">'.stripslashes($category->category_title).'</a></td>';?>
                                                <td><?php echo ($category->category_alt_title)?></td>
                                                <td><img class = "img-polaroid" width = "200px" height = "200px" src = "<?=$category->category_image?>"></td>
                                               <?php  echo '<td>
                                                <a href="'.ADMIN_URL.'/itineraries/editcat/'.$category->category_id.'" title="Edit" rel="tooltip"><i class="icon-pencil"></i></a>
                                                <a href="'.ADMIN_URL.'/itineraries/deletecat/'.$category->category_id.'" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>';
                                                echo '</tr>';?>

                                            </tr>
                                        <?php endforeach;?>                                                                                        
                                        </tbody>
                                    </table>
                                    <hr>
                                </div>
                            </div>





                        <div class="clearfix"></div>				    
					</div>
               	</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->	