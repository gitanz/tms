<?php
	if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
$news = $newsMdl->getNewsSidebar();
$testi = $testMdl->getTestimonialsFooter();
$image = $mdlObj->getImage();
$video = $mdlObj->getVideo();
// $imagev =  $video->video_image;
$ytid = getYTid($video->video_path);

?>
		<div class="span3">
		    <div class="rightContDiv">
				<div class="rightContBox fltLeft">
		    	 <h1>Gallery</h1>
			      <ul>
					<li>
			        <strong><?=$image->gallery_caption?></strong><br />
			        <div class="galThumb"><img src="<?=$image->gallery_path?>" alt="Gallery"></div>
			        <div class="checkVidBut"><a href="<?=SITE_URL?>/index/gallery"><img src="<?=SITE_URL?>/assets/images/view-gallery.png" alt="View Gallery" ></a></div>
			        </li> 
			     </ul>
			     <div class = "clear"></div>
			    </div><!--galleydiv holder-->   

			    <div class="rightContBox fltLeft">
		    	 <h1>Video</h1>
			      <ul>
               	<li>
                <strong>Mountain Biking in Nepal</strong><br />
		          <iframe src="http://www.youtube.com/embed/<?=$ytid?>" allowfullscreen></iframe>
		          <div class="checkVidBut"><a href="<?=SITE_URL?>/index/videos"><img src="<?=SITE_URL?>/assets/images/play-video.jpg" alt="Play Video" ></a></div>
                </li> 
 					</ul>
			     <div class = "clear"></div>
			    </div><!--galleydiv holder-->   

		    	<div class="rightContBox fltLeft">
					    <h1>Testimonials</h1>
		    		<ul class = "info">
					    <img src="<?=$testi->testimonial_image?>" alt="Testimonials" class="imgLeft"> <strong><?=$testi->testimonial_title?></strong>
					    <br />
					    <?=$this->text_cut($testi->testimonial_content,100)?>
					    <div class="butDiv"><a href="<?=SITE_URL?>/testimonial"><img src="<?=SITE_URL?>/assets/images/view-all.jpg" alt="View All"></a></div>
					</ul>    
					    <div class = "clear"></div>
			    </div><!--galleydiv holder-->    

		    </div><!--contentLeft end-->
		</div><!--span3 end-->

