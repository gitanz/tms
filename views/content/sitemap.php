<?php
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
/**
 * Site page detail
 * @package himalayanpursuits
 */
require_once("views/_templates/topheader.php");
require_once("views/_templates/nav.php");
$sitemap = $mdlObj->sitemap(0,0,"","");

?>
<div class="mainHolder">
<div class="inContentHolder">        
            <div class="row-fluid">
                <div class="span9">
                    <div class="leftContDiv fltLeft">
                        <h1>Sitemap</h1>
                        <?=$sitemap?>                        
                    </div><!--leftContDiv end-->
                </div><!--span9 end-->
<?php require_once("views/_templates/sidebar.php");?>
            
            </div><!--row-fluid" end-->        
</div><!--inContentHolder end-->
</div>
</div>
