<?php
	if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
$news = $newsMdl->getNewsSidebar();
$testi = $testMdl->getTestimonialsFooter();
$welcome = $mdlObj->welcomeText();
// dd($welcome);
?>

<div class="contentR01Div">
        <div class="contentR01">
        
            <div class="welcome fltLeft">
            <h1>WELCOME TO<br />
            Adventure Club Inc.</h1>
            <?=$this->text_cut($welcome->page_content,500)?>
            <div class="butDiv fltRight"><a href="<?=SITE_URL?>/index/page/<?=$welcome->page_alias?>"><img src="<?=SITE_URL?>/assets/images/read-more.jpg" width="112" height="30" alt="Read More"></a></div>
            
          </div><!--welcome end-->
          
          <div class="news fltLeft">
          <h1>News And Updates</h1>
		            <?php foreach($news as $newsObj):?>
		            <span><?=$newsObj->news_title?></span><br />		
					<strong><?=mfdate($newsObj->news_date)?></strong>
					<?=$this->text_cut($newsObj->news_content,80)?>
		            <a href="<?=SITE_URL?>/news/index/<?=$newsObj->news_id?>">Read More</a>&#0187;<br /><br />
		            <?php endforeach;?>
		    	    <div class="butDiv fltRight"><a href="<?=SITE_URL?>/news"><img src="<?=SITE_URL?>/assets/images/read-more.jpg" alt="Read More"></a></div>      
          </div><!--news end-->
          
          <div class="testi fltLeft">
            <h1>What Our Clients Says</h1>
            <img src="<?=$testi->testimonial_image?>" width="117" height="116" alt="Testimonials" class="imgLeft"><strong><?=$testi->testimonial_title?></strong><br />
            <strong><?=$testi->testimonial_address?></strong><br />
 			<?=$this->text_cut($testi->testimonial_content,400)?>
             <div class="butDiv fltRight"><a href="<?=SITE_URL?>/testimonial"><img src="<?=SITE_URL?>/assets/images/view-testi-but.jpg" width="180" height="30" alt="View All Testimonials"></a></div>
            
          </div><!--tetsi end-->
        
        <div class="clear"></div>
        </div><!--contentR01 end-->
        <div class="clear"></div>
        </div><!--contentR01Div end-->

