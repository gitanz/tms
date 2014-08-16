<?php
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
/**
 * Site page detail
 * @package himalayanpursuits
 */
require_once("views/_templates/topheader.php");
require_once("views/_templates/nav.php");
$cat = $this->result[0];    
?>
<div class="mainHolder">
<div class="inContentHolder">        
            <div class="row-fluid">
                <div class="span9">
                    <div class="leftContDiv fltLeft">
                    <h1><?=$cat->category_title?></h1>
                    <?=$cat->category_overview?>
                    <hr/>
                    <h2>Related Trips</h2>
                    <?php foreach($this->result as $result):?>
                    <div class="media">
                      <a class="pull-left" href="#">
                        <img class="thumbnail imgLeft media-object" width = "200px" src="<?=$result->trip_image?>" alt="<?=$result->trip_title?>">
                      </a>
                      <div class="media-body">
                        <h2 class="media-heading"><?=$result->trip_title?></h2>
                        <?=$this->text_cut($result->trip_overview,200)?>
                        <a href = "<?=SITE_URL?>/itineraries/show/<?=$result->trip_parent?>">View Trip</a>
                      </div>
                    </div>
                    <hr>
                    <?php endforeach;?>
              </div><!--leftContDiv end-->
                
                </div><!--span9 end-->
<?php require_once("views/_templates/sidebar.php");?>
            
            </div><!--row-fluid" end-->        
        </div><!--inContentHolder end-->
        </div></div>
