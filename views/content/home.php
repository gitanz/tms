<?php
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
require_once("views/_templates/topheader.php");
require_once("views/_templates/nav.php");
require_once("views/_templates/banner.php");
$postMenus = $mdlObj->getPostMenu();
$cats = $itiMdl->getCats(3);
$checkoutVids = $mdlObj->getHomeVideos();
// $itis = $itiMdl->getItineraries(89,0,'');

?>
    <div class="mainHolder">
<?php require_once("views/_templates/upbarhome.php");?>
<?php require_once("views/_templates/hometab.php");?>
<div class="relatedHolder">         
            <div class="relatedDiv">
            <h1>Related Services</h1>
                <ul>
                <?php foreach($postMenus as $menu):?>
                    <li><a href="<?=SITE_URL?>/index/post/<?=$menu->nav_alias?>"><img src="<?=$menu->nav_image?>" alt="Domestic Flights"></a><br />
                    <a href="<?=SITE_URL?>/index/post/<?=$menu->nav_alias?>"><?=$menu->nav_title?></a>
                    </li>
                 <?php endforeach;?>   
                </ul>

            </div><!--relatedDiv end-->
        <div class="clear"></div>                
        </div><!--relatedHolder end-->
        
        <div class="actvHolder">
            <ul>
                <?php foreach($cats as $cat):?>
                <li><h1><?=$cat->category_alt_title?></h1>
                  <img src="<?=$cat->category_image?>" alt="<?=$cat->category_title?>" width = "100%"><br />
                  <?=$this->text_cut($cat->category_overview,200)?>
                  <br /><br />
                <a href="<?=SITE_URL?>/itineraries/category/<?=$cat->category_id?>">Explore about <?=$cat->category_title?></a>
                </li>
                <?php endforeach;?>
                </ul>
        
        <div class="clear"></div>
        </div><!--actvHolder end-->
        
     <div class="vidHolder">
        <div class="vidDiv">
        
        <h1>Check out Videos</h1>         
     
            <ul>
            <?php foreach($checkoutVids as $video):$ytid = getYTid($video->video_path)?>

                <li><strong><?=$video->video_title?></strong><br />
                  <iframe src="http://www.youtube.com/embed/<?=$ytid?>" allowfullscreen></iframe>
                  <div class="vidBut"><a href="#"><img src="<?=SITE_URL?>/assets/images/play-video.jpg" alt="Play Video" ></a></div>
                </li>
            <?php endforeach;?>
                </ul>
         <div class="clear"></div>       
        </div><!--vidDiv end-->
     <div class="clear"></div>
     </div><!--vidHolder end-->



      