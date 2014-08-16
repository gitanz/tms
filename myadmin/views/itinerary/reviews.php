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
               <li><a href="<?=ADMIN_URL?>/itineraries/lists">Itinerary</a> <span class="divider">/</span></li>
                <li class="active">Reviews</li>
            </ul>
            <div class="container-fluid">
                <div class="row-fluid">
                    <?php if(isset($this->deleteid)):?>
                        <div class="alert alert-info">
                        <p>Do you really want to delete?</p> 
                        <a class="btn btn-danger" href="<?=ADMIN_URL?>/itineraries/deleteReview/<?=$this->deleteid?>?confirm=true">Yes</a> <a class="btn" href="<?=ADMIN_URL?>/itineraries/review/<?=$this->review_parent?>" type="submit">No</a>
                    </div>
                    <?php endif;?>
                    <?php if (isset($_COOKIE['ReviewCookie'])) : ?>
                    <div class="alert alert-success">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        Review is <?=$_COOKIE['ReviewCookie']?> successfully.
                    </div>
                    <?php setcookie ("ReviewCookie", "", time() - 3600); endif; ?>
                        <div class="row-fluid">
                            <div class = "well">
                                <div class="col-lg-12">
                                    <table class="table" id="table">
                                        <thead>
                                            <tr>
                                                <th>Name </th>
                                                <th>Email</th>
                                                <th>Added</th>
                                                <th></th>    
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php if(count($this->reviews)==0) echo "<tr><td>There are no reviews added yet!</td><td>&nbsp;</td><td>&nbsp;</td></tr>";

                                         foreach($this->reviews as $review):?>
                                            <tr>
                                                <?php                   
                                                echo '<td><a href="'.ADMIN_URL.'/itineraries/editreview/'.$review->review_id.'" title="Edit" rel="tooltip">'.stripslashes($review->review_name).'</a></td>';?>
                                                <td><?=$review->review_email?></td>
                                                <td><?=mfdate($review->review_added)?></td>
                                               <?php  echo '<td>
                                                <a href="'.ADMIN_URL.'/itineraries/editreview/'.$review->review_id.'" title="Edit" rel="tooltip"><i class="icon-pencil"></i></a>
                                                <a href="'.ADMIN_URL.'/itineraries/deletereview/'.$review->review_id.'/'.$review->review_parent.'" title="Delete" rel="tooltip"><i class="icon-remove"></i></a></td>';
                                                
                                                echo '</tr>';?>

                                            </tr>
                                        <?php endforeach;?>                                                                                        
                                        </tbody>
                                    </table>
                                    <hr>
                                </div>
                            </div>
                        </div>
                </div> <!-- .row-fluid -->
                <?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->