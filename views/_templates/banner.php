<?php
	if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
$banners = $mdlObj->banners();
	$bannerList = '';
	foreach ( $banners as $bnr ):
        
		if (is_file( View::attachmentPathCorrect($bnr->bnr_imgpath) )) :
			$imgpath = View::attachmentFullPathCorrect($bnr->bnr_imgpath);
			$bannerList .= '<img height = "360px" src= "'.$imgpath.'" title = "'.$bnr->bnr_title.'" >';
		endif;
	endforeach;

?>
<div class="bannerHolder">
    
    <div class="slider-wrapper theme-light">
    
            <div id="slider" class="nivoSlider">
            <?=$bannerList?>
            </div><!-- end div id:slider class:nivoSlider -->
      </div><!-- end div class:slider-wrapper theme-light -->
    
    </div><!--bannerHolder end-->