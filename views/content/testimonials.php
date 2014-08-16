<?php
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
/**
 * Site page detail
 * @package himalayanpursuits
 */
require_once("views/_templates/topheader.php");
require_once("views/_templates/nav.php");

?>
<div class="mainHolder">
<div class="inContentHolder">        
            <div class="row-fluid">
                <div class="span9">
                    <div class="leftContDiv fltLeft">
                  <div class="breadbrumb">
                    <a href="<?=SITE_URL?>">Home</a> &#0187; 
                    <a href="<?=SITE_URL?>/testimonial">Testimonials</a>
                    <?php if(!$this->listing):?> &#0187; <a href="javascript:void(0)"><?=$this->result->testimonial_id?></a><?php endif;?>
                  </div>
                    <h1>Testimonials</h1>
                        <?php if($this->listing):
                            foreach($this->results as $result):?>
                            <div class="media">
                              <a class="pull-left" href="#">
                                <img class="media-object" src="<?=$result->testimonial_image?>" alt="<?=$result->testimonial_title?>">
                              </a>
                              <div class="media-body">
                                <h4 class="media-heading"><?=$result->testimonial_title?></h4>
                                <span><?=$result->testimonial_address?></span>
                                <?=$this->text_cut($result->testimonial_content,160)?>
                                <a href = "<?=SITE_URL?>/testimonial/index/<?=$result->testimonial_id?>">Read More</a>
                              </div>
                            </div>
                        <?php endforeach;?>
                        <?php else:
                            ?>
                            <div class="media">
                              <a class="pull-left" href="#">
                                <img class="media-object" src="<?=$this->result->testimonial_image?>" alt="<?=$this->result->testimonial_title?>">
                              </a>
                              <div class="media-body">
                                <h4 class="media-heading"><?=$this->result->testimonial_title?></h4>
                                <span><?=$this->result->testimonial_address?></span>
                                <?=$this->result->testimonial_content?>
                              </div>
                            </div>
                        <?php endif;?>
       
   </div><!--leftContDiv end-->
                
                </div><!--span9 end-->
<?php require_once("views/_templates/sidebar.php");?>
            
            </div><!--row-fluid" end-->        
        </div><!--inContentHolder end-->
        </div></div>