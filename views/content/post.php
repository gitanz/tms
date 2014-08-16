<?php
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
/**
 * Site page detail
 * @package himalayanpursuits
 */
require_once("views/_templates/topheader.php");
require_once("views/_templates/nav.php");
$nav = $this->pages[0];

?>
<div class="mainHolder">
<div class="inContentHolder">        
            <div class="row-fluid">
                <div class="span9">
                    <div class="leftContDiv fltLeft">
                  <div class="breadbrumb">
                    <a href="<?=SITE_URL?>">Home</a> &#0187; 
                    <a href="javascript:void(0)"><?=$nav->nav_title?></a>
                  </div>
                    <h1><?=$nav->nav_title?></h1>
                        <?php if($this->listing===true):
                            foreach($this->pages as $result):?>
                            <div class="media">
                            <?php if(!empty($result->page_image)):?>
                              <a class="" href="#">
                                <img class="media-object" src="<?=$result->page_image?>" alt="<?=$result->page_title?>">
                              </a>
                            <?php endif;?>
                              <div class="media-body">
                                <h4 class="media-heading"><?=$result->page_title?></h4>
                                <?=$this->text_cut($result->page_content,500)?>
                                <a href = "<?=SITE_URL?>/index/post/<?=$nav->nav_alias?>/<?=$result->page_id?>">Read More</a>
                              </div>
                            </div></div>
                        <?php endforeach;?>
                        <?php else:
                              $result = $this->pages[0];
                            ?>
                            <div class="media">
                               <?php if(!empty($result->page_image)):?>
                              <a class="" href="#">
                                <img class="media-object" src="<?=$result->page_image?>" alt="<?=$result->page_title?>">
                              </a>
                              <?php endif;?>
                              <div class="media-body">
                                <h4 class="media-heading"><?=$result->page_title?></h4>
                              <?=$result->page_content?>
                              </div>
                            </div>
                        <?php endif;?>
          </div><!--leftContDiv end-->
                </div><!--span9 end-->
                <?php require_once("views/_templates/sidebar.php");?>
            </div><!--row-fluid" end-->        
        </div><!--inContentHolder end-->
        </div></div>