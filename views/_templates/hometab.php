<?php
  if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
  $tabs = $mdlObj->getHomeTabs();
  $homeIts = $itiMdl->getItineraries($tabs[0]->nav_id);
  $i=1;$html = "";
  foreach($homeIts as $result):
      if($i===3){
      $html .= '<div class="tabDivLast fltLeft">';
      $i=0;
      }
      else
      $html .= '<div class="tabDiv fltLeft">';
      $html .= '<img class = "tabImg" src="'.$result->trip_image.'" alt="'.$result->trip_title.'">';
      $html .= '<div class="tabTitle fltLeft"><strong>'.$result->trip_title.'</strong></div>';
      $html .= '<div class="fltRight"><strong>'.explode('/',$result->info_trek_duration)[0].' Days</strong></div>';
      $html .= '<div class="tabButDiv fltLeft"><a href="'.SITE_URL.'/itineraries/show/'.$result->trip_parent.'"><img src="'.SITE_URL.'/assets/images/og-view-trip.jpg" width="110" height="30" alt="View Trip"></a></div><div class="tabButDiv fltLeft"><a href="'.SITE_URL.'/itineraries/book/'.$result->trip_id.'"><img src="'.SITE_URL.'/assets/images/gr-book-trip.jpg" width="111" height="30" alt="Book Trip"></a></div>';
      $html .= '<div class="clear"></div>';
      $html .= '</div>';
      
      $i++;                                    
        endforeach;
?>
<div class="tabHolder">
            <div class="tabTop">
             <ul class="nav nav-tabs" role="tablist">
             <?php $count = 0; foreach($tabs as $tab): ?>
              <?php if($count==0):?>
              <li class = "tab active"><a class = "hometab" id = "<?=$tab->nav_id?>" href = "#"><?=$tab->nav_altname?></a></li>
              <?php else:?>
              <li class = "tab"><a class = "hometab" id = "<?=$tab->nav_id?>" href = "#"><?=$tab->nav_altname?></a></li>
             <?php endif;$count++;endforeach;?> 
            </ul>
            </div><!--tabTop end-->
            <div class="tabDivHolder">
              <div class = 'tab-content'>              
                <?=$html?>                
                <div class="clear"></div>
              </div>
            </div><!--tabDivHolder end-->          
        </div><!--tabHolder end-->
<script type="text/javascript">
  $(".hometab").click(function(){
      var iTid = $(this).attr("id");
      $("li.tab.active").removeClass("active");
      $(this).parent().addClass("active");
      $.ajax({
        type: "POST",
        url: '<?=SITE_URL?>/itineraries/do_ajax',
        dataType:'json',
        cache: 'false',
        data:{
        iTid:iTid,
        },
      beforeSend:function(){
        $(".tab-content").html('<img src="assets/images/loading.gif" align="absmiddle" /> processing...');
        },
      success: function(data){
        $(".tab-content").html(data.message);
        }                                     
      }); 
      return false;
  });
</script>