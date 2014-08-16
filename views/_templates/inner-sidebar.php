<?php
	if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
$news = $newsMdl->getNewsSidebar();
$testi = $testMdl->getTestimonialsFooter();
$randomTrips = $itiMdl->getRandomTrips($this->result->category_id,$this->result->trip_id);
?>
<div class="span3">
    <div class="rightContDiv">
        <div class="rightContBox fltLeft">
        <h1>Trip Facts</h1>
        <ul>
        <li class="tripCode">Trip Code - <?=$this->result->info_code?><br />
        <?php if(!empty($this->result->info_grade)):	
    		echo'Trip Grade - ';
    		for($i = 0; $i<intval($this->result->info_grade);$i++){
    		echo '<img src = "'.SITE_URL.'/assets/images/trip-ico.jpg" width="16" height="21" alt="Trip Grade">';
    		}
    		endif;
	    ?>
        <?php $dest = $itiMdl->getRootNav($this->result->trip_parent);
        ?>
        <li><strong>Destination</strong>: <?=$dest->nav_title?></li>
		<?php if(!empty($this->result->info_trek_duration)):	
		echo'<li><strong>Duration</strong>: '.explode("/",$this->result->info_trek_duration)[0]." nights ".explode('/',$this->result->info_trek_duration)[1].' days</li>';
		elseif(!empty($this->result->info_tour_duration)):	
		echo'<li><strong>Duration</strong>'.explode("/",$this->result->info_tour_duration)[0]." nights ".explode("/",$this->result->info_tour_duration)[1].' days</li>';
        ?>
		<?php endif;if(!empty($this->result->info_high_alt)):?>
        <li><strong>Max Altitude</strong>: <?=$this->result->info_high_alt?></li>
        <?php endif;if(!empty($this->result->info_starts_from)):?>
        <li><strong>Start Point</strong>: <?=$this->result->info_starts_from?></li>
        <?php endif;if(!empty($this->result->info_end_at)):?>
        <li><strong>End Point</strong>: <?=$this->result->info_end_at?></li>
		<?php endif;if(!empty($this->result->info_transportation)):?>
        <li><strong>Transport</strong>: <?=$this->result->info_transportation?> </li>
        <?php endif;if(!empty($this->result->info_activities)):?>
        <li><strong>Activity</strong>: <?=$this->result->info_activities?></li>
		<?php endif;if(!empty($this->result->info_accommodation)):	?>
        <li><strong>Accomodation</strong>: <?=$this->result->info_accommodation?></li>
        <?php endif;if(!empty($this->result->info_meals)):?>
        <li><strong>Meal</strong>: <?=$this->result->info_meals?></li>
        <?php endif;if(!empty($this->result->info_groupsize)):?>
        <li><strong>Group Size</strong>: <?=$this->result->info_groupsize?></li>
        <?php endif;?>
		<?php if(!empty($this->result->info_dlywlknghr)):?>
        <li><strong>Daily Walking Hour</strong>: <?=$this->result->info_dlywlknghr?></li>
    	<?php endif;?>
        <li><div align="center"><a href="<?=SITE_URL?>/itineraries/book/<?=$this->result->trip_parent?>"><img src="<?=SITE_URL?>/assets/images/book-this.jpg" alt="Book This Trip"></a><a href="<?=SITE_URL?>/itineraries/book/<?=$this->result->trip_parent?>?tailormade=1"><img src="<?=SITE_URL?>/assets/images/tailor-made.jpg" alt="Tailor Made Trip"></a></div></li> 
        </ul>
         </div><!--rightContBox end-->

        <div class="rightContBox fltLeft">
        <h1>Other Trips</h1>
        <ul>
        <?php foreach($randomTrips as $trip):?>
        <li><a href="<?=SITE_URL?>/itineraries/show/<?=$trip->trip_parent?>"><?=$trip->trip_title?> - <?=explode('/',$trip->info_trek_duration)[1]?> Days</a></li>
        <?php endforeach;?>
        </ul>
        </div><!--rightContBox end-->
        <?php $country_list = getCountryList();?>
        <div class="rightContBox fltLeft">
        <h1>Quick Inquiry</h1>
        <form id = "qinquiry" action = "#" method = "POST">
        <ul>
        <li>
        <input name="name" type="text" placeholder="Full Name" required>
        <input name="phone" type="tel" placeholder="Phone">
        <input name="mobile" type="tel" placeholder="Mobile" >
        <input name="email" type="email" placeholder="Email" required>
        <select name="country" required>
          <option>Select Country</option>
          <?php foreach($country_list as $list):?>
            <option value="<?=$list?>"><?=$list?></option> 
          <?php endforeach;?>  
        </select>
        <textarea name="message" cols="" rows="" placeholder ="Type your message here" required></textarea>
        <input name="submit" type="image" src="<?=SITE_URL?>/assets/images/submit-form.jpg" class="submitBut">
        </li> 
        </ul>
        </form>
        </div><!--rightContBox end-->
        
        <div class="faceBookDiv fltLeft">
         <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fadventureclub&amp;width=100&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=266865633357794" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:290px;" allowTransparency="true"></iframe>
        </div><!--faceBookDiv end-->
        
        <div class="rightContBox fltLeft">
        <h1>Check Out Videos</h1>
        <ul><li>
        <strong><?=$this->sidegallery->video_title?></strong><br />
        <?php 
    	$imagev =  $this->sidegallery->video_image;
		if(starts_with("https://www.youtube.com/",$this->sidegallery->video_path)||starts_with("http://www.youtube.com/",$this->sidegallery->video_path)){
		$ytid = getYTid($this->sidegallery->video_path); 
		echo '<iframe src="http://www.youtube.com/embed/'.$ytid.'" allowfullscreen></iframe>';
		}
        else{
        echo '<video width="100%" controls>
              <source src="'.$this->sidegallery->video_path.'" type="video/mp4">
              Your browser does not support the video tag.
            </video>';
        }
    	?>
      <div align="checkVidBut"><a href="<?=SITE_URL?>/itineraries/videos/<?=$this->sidegallery->video_parent?>"><img  src="<?=SITE_URL?>/assets/images/play-video.jpg" alt="View All"></a></div>
        </li></ul>
        
        </div><!--rightContBox end-->
        
        <?php if(!empty($this->sidegallery->gallery_parent)):?>
        <div class="rightContBox fltLeft">
        <h1>Gallery</h1>
        <ul>
	        <li>
	        <strong><?=$this->sidegallery->gallery_caption?></strong><br />
	        <div class="galThumb"><img src="<?=$this->sidegallery->gallery_path?>" alt="Gallery"></div>
	        <div class="checkVidBut"><a href="<?=SITE_URL?>/itineraries/gallery/<?=$this->sidegallery->gallery_parent?>"><img src="<?=SITE_URL?>/assets/images/view-gallery.png" alt="View Gallery" ></a></div>
	        </li> 
        </ul>
        </div><!--rightContBox end-->
    	<?php endif;?>
    </div><!--rightContDiv end-->
                </div><!--span4 end-->


<script type="text/javascript">
    $( "#qinquiry" ).submit(function(event) {
        $.ajax({
            type: "POST",
            url: '<?=SITE_URL?>/form/inquiry',
            dataType:'json',
            cache: 'false',
            data:$("#qinquiry").serialize(),
        beforeSend:function(){
            $("#qinquiry ul").html('<li><img width= "100" src="assets/images/loading.gif" align="absmiddle" /> processing..please wait</li>');
            },
        success: function(data){
            if(data.success===true)
            $("#qinquiry ul").html("<li><div class = 'alert alert-success'>"+data.message+"</div></li>");
            else
            $("#qinquiry ul").html("<li><div class = 'alert alert-danger'>"+data.message+"</div></li>");
            }                                     
        });
        event.preventDefault(); 
    }); 
</script>

    