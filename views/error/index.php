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
                    <span>Page NOT Found<br>
                <h2>Error 404-Page NOT Found</h2></span><br />
                <p>
                    It seems we can't find what you're looking for.<br />
                    You have typed the web address incorrectly, or the page you were looking for may have been moved, updated or deleted.<br />
                    Check for a mis-typed URL error, then press the refresh button on your browser.
                </p>
                <div class="clear"></div>
              </div><!--leftContDiv end-->
                
                </div><!--span9 end-->
<?php require_once("views/_templates/sidebar.php");?>
            
            </div><!--row-fluid" end-->        
        </div><!--inContentHolder end-->
        </div></div>
