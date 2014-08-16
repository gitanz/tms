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
                    <?php if(isset($this->breadcrumb)):?>
                    <?=$this->breadcrumb?>
                <?php endif;?>
                    <h1><?=$this->page_title?></h1>
                    <?=$this->page_content?>
                    <?php
                    if(isset($this->contact_form) && $this->contact_form )
                        include_once("views/content/contact_form.php");
                    if(isset($this->booking_form) && $this->booking_form )
                        include_once("views/content/booking_form.php");
                    ?>
              </div><!--leftContDiv end-->
                
                </div><!--span9 end-->
<?php require_once("views/_templates/sidebar.php");?>
            
            </div><!--row-fluid" end-->        
        </div><!--inContentHolder end-->
        </div></div>
