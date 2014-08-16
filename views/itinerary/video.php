<?php
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
require_once("views/_templates/topheader.php");
require_once("views/_templates/nav.php");
$this->sidegallery = $this->results[0];
// require_once("views/_templates/inner-sidebar.php");
// dd($this->results);
?>
<link rel="stylesheet" href="<?=SITE_URL?>/assets/css/screen.css">
<div class="mainHolder">
<div class="inContentHolder">        
            <div class="row-fluid">
                <div class="span9">
                    <div class="leftContDiv fltLeft">
    	<?=$this->breadcrumb?>
        	<h1><?=$this->title?></h1>
      		<section id="examples" class="section examples-section">
					<div class="image-setxxx">
      			<?php
      				$repeated = [];
      				foreach($this->results as $result):
      				if(in_array($result->video_id, $repeated))
      					continue;
      				$repeated[] = $result->video_id;
              $image =  $result->video_image;
              if(starts_with("https://www.youtube.com/",$result->video_path)||starts_with("http://www.youtube.com/",$result->video_path)){
                $ytid = getYTid($result->video_path); 
                $image = "http://img.youtube.com/vi/".$ytid."/mqdefault.jpg"; 
              }
      			?>
					<div class = 'image' style = 'float:left;padding-left:10px;'>
						<a class="px2 html5lightbox" data-width="480" data-height="320" href="<?=$result->video_path?>" title="<?=$result->video_title?>">
							<div class='photo-container'>
								<img src = '<?=$image?>' alt = '<?=$result->video_title?>' class='gthumb' height='auto' width='150px'>
							</div>
							<div class="clear"></div>
						</a>
						<a style="text-decoration:none" href="<?=$result->video_path?>" title="<?=$result->video_title?>" class="px1 html5lightbox"><div class="caption"><?=$result->video_title?></div></a>
					</div>
      			<?php endforeach;?>
				</div>
			</section>
                   </div><!--leftContDiv end-->
                
                </div><!--span9 end-->
<?php require_once("views/_templates/inner-sidebar.php");?>
            
            </div><!--row-fluid" end-->        
        </div><!--inContentHolder end-->
