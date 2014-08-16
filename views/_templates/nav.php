<?php
	if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
	$nav = $mdlObj->menu_adjacency_main(0,0,'Main','',true);
?>
<div class="navDiv">
        <div class="navHolder">
        
        <div class="navbar navbar-default">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div><!-- end div class:navbar-header -->
        <div class="navbar-collapse collapse ">
            <?=$nav?>
        </div><!-- end div class:navbar-collapse collapse  -->
</div><!-- end div class:navbar navbar-default -->  
        
        </div><!--navHolder end-->
    </div><!--navHolder end-->
    