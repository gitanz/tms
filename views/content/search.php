<?php
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
/**
 * Site page detail
 * @package himalayanpursuits
 */
require_once("views/_templates/topheader.php");
require_once("views/_templates/nav.php");
// require_once("views/_templates/sidebar.php");
?>
<div class="mainHolder">
<div class="inContentHolder">        
            <div class="row-fluid">
                <div class="span9">
                    <div class="leftContDiv fltLeft">
                        <div class="breadbrumb">
                            <a href="<?=SITE_URL?>">Home</a> &#0187;
                            <a href="javascript:void(0)">Search</a>
                        </div>
                        <h1>Seach Results</h1>
                        <p>Showing seach results for query:<em style = "color:blue"><?=$this->query?></em></p><br/>
                        <?php foreach($this->query_results as $result):?>
                             <a href = "<?=SITE_URL?>/index/page/<?=$result->slug?>"><strong><?=$result->title?></strong></a>
                        <?php
                            echo $this->text_cut(strip_tags($result->content, '<p><a>'),200)."<hr style = 'border-color:#E8E8E8'>";
                          endforeach;
                        ?>
                    </div><!--leftContDiv end-->
                
                </div><!--span9 end-->
<?php require_once("views/_templates/sidebar.php");?>
            
            </div><!--row-fluid" end-->        
        </div><!--inContentHolder end-->
        </div></div>
