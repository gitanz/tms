<?php 
	if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
//create instances of all model
include_once("models/news_model.php");
include_once("models/testimonial_model.php");
include_once("models/itineraries_model.php");
$mdlObj = new Model();
$newsMdl = new News_Model();
$testMdl = new Testimonial_Model();
$itiMdl = new Itineraries_Model();

    $social = "";
    $social_icons = [];
    $social_icons = unserialize(SOCIAL_ICONS);
    $social_links = [];
    $social_links = unserialize(SOCIAL_LINKS);
    if(count($social_icons)==count($social_links)):
        for($i=0;$i<count($social_icons);$i++){
           $social .= "<a href = '$social_links[$i]'><img src ='$social_icons[$i]'></a>&nbsp";
        }
    endif;

 $assoc = "";
    $assoc_icons = [];
    $assoc_icons = unserialize(ASSOC_ICONS);
    $assoc_links = [];
    $assoc_links = unserialize(ASSOC_LINKS);
    if(count($assoc_icons)==count($assoc_links)):
        for($i=0;$i<count($assoc_icons);$i++){
           $assoc .= "<a href = '$assoc_links[$i]'><img src ='$assoc_icons[$i]'></a>&nbsp";
        }
    endif;

$headers = $mdlObj->menu_adjacency_other(0, 0 ,"Header"," ");
?>
<div class="wrapper">
    <div class="container">
        <div class="topHolder">
        <div class="topGrdBg">
            <div class="topDiv">
                
                <div class="logo fltLeft"><a href="<?=SITE_URL?>"><img src="<?=SITE_URL?>/assets/images/logo.png" alt="Home"></a>
                </div><!--logo end-->
                
                <div class="topRightDiv fltRight">
                    <div class="topLink">
                    <?=$headers?>
                    </div><!--topLink end-->
                    
                <div class="topSearch">
                    <form action = "<?=SITE_URL?>/index/search" method = "GET">
                    <div class="searchDiv fltLeft">
                    <input name="query" type="text" value="" placeholder = "Enter search keyword" /></div> 
                    <div class="serachButDiv fltRight">
                    <input value = "" name = "" type="submit" class="searchBut"/></div>
                    <div class="clear"></div>
                    </form>
                </div><!--topSearch end-->
                
                <div class="topPhoneDiv">
                    T: <?=SITE_PHONE?><br />
                    <span>E:</span> <a href="#"><?=SITE_EMAIL?></a>
                </div><!--topPhoneDiv end-->                    
                </div><!--topRightDiv end-->      
          
          </div><!--topDiv end-->
          <div class="clear"></div>
        </div><!--topGrdBg end-->        
        </div><!--topHolder end-->
        