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
                        <a href="<?=SITE_URL?>/news">News & Updates</a>
                        <?php if(!$this->listing):?>&#0187;<a href="javascript:void(0)"><?=$this->result->news_id?></a><?php endif;?>
                    </div>

                     <h1>News and Events</h1>
                        <?php if($this->listing):
                            foreach($this->results as $result):?>
                            <div class="media">
                            <?php if(!empty($result->news_image)):?>
                              <a class="pull-left" href="#">
                                <img class="media-object" src="<?=$result->news_image?>" alt="<?=$result->news_title?>">
                              </a>
                            <?php endif;?>  
                              <div class="media-body">
                                <h4 class="media-heading"><?=$result->news_title?></h4>
                                <span><?=mfdate($result->news_date)?></span>
                                <?=$this->text_cut($result->news_content,160)?>
                                <a href = "<?=SITE_URL?>/news/index/<?=$result->news_id?>">Read More</a>
                              </div>
                            </div>
                        <?php endforeach;?>
                        <?php else:
                            ?>
                            <div class="media">
                            <?php if(!empty($result->news_image)):?>
                              <a class="pull-left" href="#">
                                <img class="media-object" src="<?=$this->result->news_image?>" alt="<?=$this->result->news_title?>">
                              </a>
                            <?php endif;?>  
                              <div class="media-body">
                                <h4 class="media-heading"><?=$this->result->news_title?></h4>
                                <span><?=mfdate($this->result->news_date)?></span>
                                <?=$this->result->news_content?>
                              </div>
                            </div>
                        <?php endif;?>

                    
                       
     </div><!--leftContDiv end-->
                </div><!--span9 end-->
<?php require_once("views/_templates/sidebar.php");?>
            
</div><!--row-fluid" end-->        
</div><!--inContentHolder end-->
</div></div>