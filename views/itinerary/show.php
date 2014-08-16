<?php
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
require_once("views/_templates/topheader.php");
require_once("views/_templates/nav.php");
require_once("views/_templates/banner.php");

$sections = [];
if(!empty($this->result->trip_outline)) $sections["outline-itinerary"] = $this->result->trip_outline;
if(!empty($this->result->trip_day2day)) $sections["detailed-itinerary"] = $this->result->trip_day2day;
if(!empty($this->result->trip_notes)) $sections["notes"] = $this->result->trip_notes;
if(!empty($this->result->trip_map)) $sections["map"] = "<img src = '".$this->result->trip_map."' width='100%'>";

if(!empty($this->result->trip_pr_includes)) $sections["cost-includes"] = $this->result->trip_pr_includes;
if(!empty($this->result->trip_pr_n_includes)) $sections["cost-not-includes"] = $this->result->trip_pr_n_includes;

?>
<div class="mainHolder">
<div class="inContentHolder">        
            <div class="row-fluid">
                <div class="span9">
                    <div class="leftContDiv fltLeft">
                        <?=$this->breadcrumb?>
                         <h1><?=$this->result->trip_title?></h1>
                        <div class="addThis">                        
                         <div class="addthis_native_toolbox fltRight"></div>
                         <div class="clear"></div>
                        </div><!--addThis end-->
                        <?=$this->result->trip_overview?>
                        <hr />
                        <?php 
                            foreach($sections as $key=>$value):
                                if($key==="map") echo "<h2>Map</h2>";
                                echo $value."<hr>";
                            endforeach;
                        ?>
                        <div class="fltLeft"><a href="<?=SITE_URL?>/itineraries/book/<?=$this->result->trip_parent?>"><img src="<?=SITE_URL?>/assets/images/book-this.jpg" alt="Book This Trip"></a></div>
                        <div class="fltLeft"><a href="<?=SITE_URL?>/itineraries/book/<?=$this->result->trip_parent?>?tailormade=1"><img src="<?=SITE_URL?>/assets/images/tailor-made.jpg" alt="Tailor Made Trip"></a></div>                    
                    </div><!--leftContDiv end-->
                
                </div><!--span9 end-->
<?php require_once("views/_templates/inner-sidebar.php");?>
            
            </div><!--row-fluid" end-->        
        </div><!--inContentHolder end-->












      

