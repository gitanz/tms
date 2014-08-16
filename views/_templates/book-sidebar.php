<?php
	if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
$news = $newsMdl->getNewsSidebar();
// dd($this->result);
?>
		<div class="span3">
		    <div class="rightContDiv">
        		<div class="rightContBox fltLeft">
	    		<h1>Booking Summary</h1>
	    			<ul class="info">
	    				<img src = "<?=$this->result->trip_image?>" width="100%">
	    				<li><strong>Trip Title: </strong><?=$this->result->trip_title?></li>
	    				<li><strong>Trip Code: </strong><?=$this->result->info_code?></li>
	    				<?php
						if(!empty($this->result->info_supplement)):	
						?>		    					  
	    				<li><strong>Supplement: </strong><?=$this->result->info_supplement?></li>
	    				<?php endif;?>
	    			</ul>
	    		</div>	
		    	<div class="rightContBox fltLeft">
	    				<?php if($this->result->trip_price_type == '0'){}
	    					 // echo "Not defined";
	    					 elseif($this->result->trip_price_type == '1'){
	    					  echo "<h1>Tour Price</h1><ul class = 'info'>";
	    					  	echo "<li><strong>Super-Standard:</strong>".explode("/", $this->result->trip_price)[0]."</li>";
	    					  	echo "<li><strong>Deluxe:</strong>".explode("/", $this->result->trip_price)[1]."</li>";
	    					  	echo "<li><strong>Super-Deluxe:</strong>".explode("/", $this->result->trip_price)[2]."</li>";
	    					  }
	    					  elseif($this->result->trip_price_type == '2'){
	    					  	echo "<h1>Trek Price</h1><ul class = 'info'>";
	    					  	echo "<li'><strong>Super-Standard[Tented Camp Price] </strong> ".explode("/", $this->result->trip_ss_price)[0]."</li>";
	    					  	echo "<li'><strong>Super-Standard[Tea House Price] </strong> ".explode("/", $this->result->trip_ss_price)[0]."</li>";
	    					  	echo "<li'><strong>Deluxe[Tented Camp Price] </strong> ".explode("/", $this->result->trip_d_price)[0]."</li>";
	    					  	echo "<li'><strong>Deluxe[Tea House Price] </strong> ".explode("/", $this->result->trip_d_price)[0]."</li>";
	    					  	echo "<li'><strong>Super-Deluxe[Tented Camp Price] </strong> ".explode("/", $this->result->trip_sd_price)[0]."</li>";
	    					  	echo "<li'><strong>Super-Deluxe[Tea House Price] </strong> ".explode("/", $this->result->trip_sd_price)[0]."</li>";
	    					  }
	    					?>
	    					  </li>
						<?php 
	    				echo '</ul>'
	    			?>
		    	</div>
		    	<div class="rightContBox fltLeft">
		            <h1>News And Updates</h1>
		            <ul class = "info">
		            <?php foreach($news as $newsObj):?>
		            <strong><?=$newsObj->news_title?></strong>		
					<?=mfdate($newsObj->news_date)?><br />
					<?=$this->text_cut($newsObj->news_content,120)?>
		            <div class="clear"></div>
		            <div class="butDiv"><a href="#"><img src="<?=SITE_URL?>/assets/images/read-more.jpg" width="94" height="30" alt="Read More"></a></div>
		            <hr />
		            <?php endforeach;?>
		    	    <div align="center"><a href="#"><img src="<?=SITE_URL?>/assets/images/view-archive.jpg" alt="View Archive"></a></div> 
		    	    </ul>               
		        </div><!--newsHolder end-->
	 </div><!--rightContDiv end-->
</div><!--span4 end-->