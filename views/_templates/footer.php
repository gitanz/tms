  <?php 
if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
$testi = $testMdl->getTestimonialsFooter();
$contact = $mdlObj->getHomeContactContent();
$counts = $mdlObj->getSiteCount();
$cats = $itiMdl->getAllCategories();
?>
     
     <div class="footerHolder">
     <div class="footerBgHolder">
        <div class="footerDiv">
            <ul>
                <li><h2>Activities</h2> 
                <?php foreach($cats as $cat):?>
                    <a href="<?=SITE_URL?>/itineraries/categories/<?=$cat->category_id?>"><?=$cat->category_title?></a><br /> 
                <?php endforeach;?>
                </li>
                
                <li><h2>Beyond Nepal</h2>   
                   <?=$mdlObj->menu_adjacency_other(0, 0 ,"Beyond","");?>
                </li>
                
                <li><h2>Nepal Travel Info</h2>  
                   <?=$mdlObj->menu_adjacency_other(0, 0 ,"Info","");?>
                </li>
                
                <li><h2>Explore</h2>    
                    <?=$mdlObj->menu_adjacency_other(0, 0 ,"Explore","");?>
                </li> 
                
                <li><h2>Contact Address</h2>    
                   <?=$contact->page_content?>
                </li>
                
            </ul>
        <div class="clear"></div>
        </div><!--footerDiv end-->
             
        <div class="footerHolder2">
         <div class="footerDiv2">        
            <ul>
                <li><h2>We are Associated with</h2> 
                    <?=$assoc?>                    
                </li>
                
                <li> <div class="weAreDiv">
                    <h2>We are ready to hear you!</h2>
                    <form method = "POST" action = "<?=SITE_URL?>/index/page/<?=$contact->nav_alias?>">
                    <input type = "text" name = "name" class = "" id = "" placeholder = "Enter name" required/>
                    <input type = "email" name = "email" class = "" id = "" placeholder = "Enter email" required/>
                    <input type = "image"src = "<?=SITE_URL?>/assets/images/continue-but.jpg"class = "continueBut"/>
                    </div>  
                </li>
                
                <li><h2>Stay Connected</h2> 
                <?=$social?>
                </li>
            </ul>
          </div><!--footerDiv2 end-->
        <div class="clear"></div>
        </div><!--footerHolder2 end-->
     
     </div><!--footerBgHolder end-->
     </div><!--footerHolder end-->
    
    <div class="copyHolder">
        <div class="copyDiv">
            <div class="copyLeft fltLeft"><?=SITE_COPYRIGHT?><br />
            <a href="http://www.axilcreations.com" target="_blank">Website Design</a> &amp; <a href="http://www.axilcreations.com" target="_blank">Web Development</a> by <a href="http://www.axilcreations.com" target="_blank">Axil Creations</a></div><!--copyLeft end-->
            <div class="copyRight fltRight"><?=$mdlObj->menu_adjacency_other(0, 0 ,"Tail","");?></a><br />
            This website has been visited <span><?=$counts?></span> times.</div><!--copyRight end-->
        </div><!--copyDiv end-->
    <div class="clear"></div>
    </div><!--copyHolder end-->
    
    <div class="clear"></div>
    </div><!--mainHolder end-->
    
    <div class="clear"></div>
    </div><!--container end-->
    <div class="clear"></div>
</div><!--wrapper end-->

