<?php 
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
$testi = $testMdl->getTestimonialsFooter();
?>
<div class="boxHolder">
  <div class="testiDiv fltLeft">
    <div>
    <h1>Testimonials</h1>
    <img src="<?=SITE_URL?>/assets/images/testi-img01.jpg" alt="Testimonials" class="imgLeft"> <strong><?=$testi->testimonial_title?></strong>
    <br />
    <?=$this->text_cut($testi->testimonial_content,100)?>
    <div class="butDiv"><a href="#"><img src="<?=SITE_URL?>/assets/images/view-all.jpg" alt="View All"></a></div>
    </div>
    </div><!--testiDiv end-->
    
   <div class="galleryDiv fltLeft">
    <h1>Gallery</h1>
        <ul>
    	<li><strong>Photos</strong><br />
    	  <a href="#"><img src="<?=SITE_URL?>/assets/images/gallery-th.jpg" alt="Photo Gallery"></a><br />
          <div align="center"><a href="#"><img src="<?=SITE_URL?>/assets/images/view-all.jpg" alt="View All"></a></div>
        </li>
        <li><strong>Videos</strong><br />
    	  <a href="#"><img src="<?=SITE_URL?>/assets/images/videos-th.jpg" alt="Photo Gallery"></a><br />
          <div align="center"><a href="#"><img src="<?=SITE_URL?>/assets/images/view-all.jpg" alt="View All"></a></div>
        </li>
     </ul>
    </div><!--galleryDiv end--> 
    
    <div class="contactDiv fltLeft">
    <h1>Question/Inquiry</h1>
    <input name="Search" type="text" placeholder="Enter Full Name" />
  	<input name="Search" type="text" placeholder="Enter Email Address" />
    <div align="right"> <input name="" type="image" src="<?=SITE_URL?>/assets/images/continue-but.jpg" class="continueBut" /></div>
    </div><!--contactDiv end-->
    
<div class="clear"></div>    
</div><!--boxHolder end-->