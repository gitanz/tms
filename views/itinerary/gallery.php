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
      				if(in_array($result->gallery_id, $repeated))
      					continue;
      				$repeated[] = $result->gallery_id; 
      			?>
					<div class = 'image'  style = 'float:left;padding-left:10px;'>
						<a class="px2 html5lightbox" data-group = 'mygroup' href="<?=$result->gallery_path?>" title="<?=$result->gallery_caption?>">
							<div class='photo-container'>
								<img src = '<?=$result->gallery_path?>' alt = '<?=$result->gallery_caption?>' class='gthumb' height='auto' width='150px'>
							</div>
							<div class="clear"></div>
						</a>
						<a class="px2 html5lightbox" data-group = 'mygroup' href="<?=$result->gallery_path?>" title="<?=$result->gallery_caption?>">
              <div class="caption"><?=$result->gallery_caption?></div>
            </a>
					</div>
      			<?php endforeach;?>
				</div>
			</section>
          </div><!--leftContDiv end-->
                
                </div><!--span9 end-->
<?php require_once("views/_templates/sidebar.php");?>
            
            </div><!--row-fluid" end-->        
        </div><!--inContentHolder end-->
        </div></div>