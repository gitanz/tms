<div class="featuredDiv">
                        <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                              <li class = "tab active" id = "expeditions" ><a href = "#">Expeditions</a></li>
                              <li class = "tab" id = "trekking" ><a href = "#">Trekking</a></li>
                              <li class = "tab" id = "peakClimbing"><a href = "#">Peak Climbing</a></li>
                              <li class = "tab" id = "extentions"><a href = "#">Extentions</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <?php foreach($itis as $iti):?>
                                    <h5 class = "trekHead"><?=$iti->trip_title?><span class = "fltRight"><?=explode('/',$iti->info_trek_duration)[0];?>&nbsp;Days</span></h5>
                                    <div class ="left"><img width = "220" height = "145px" src = "<?=$iti->trip_image?>"/></div>
                                    <div class ="mid">
                                    <?=$this->text_cut($iti->trip_outline,150)."<br>"?>
                                        <a href="<?=SITE_URL?>/itineraries/show/<?=$iti->trip_parent?>"><img src="assets/images/view-trip.jpg" width="112" height="30" alt="Read More"></a>
                                        <a href="<?=SITE_URL?>/itineraries/book/<?=$iti->trip_id?>"><img src="assets/images/book-trip.jpg" width="112" height="30" alt="Read More"></a>
                                    </div>
                                    <div class ="right">
                                        <li>Grade: <?php for($i = 0; $i<intval($iti->info_grade); $i++):
                                            echo '<img src = "'.SITE_URL.'/assets/images/star.png">'.'&nbsp;';
                                        endfor;?></li>
                                        <li>Activities: <?=$iti->info_activities?></li>
                                        <li>Destination: Destination here</li>
                                        <li>Max.Altitude: <?=$iti->info_high_alt?></li>
                                        <li>Season: <?=implode(", ",unserialize($iti->info_seasons))?></li>

                                    </div>
                                    <div class = "clear"></div>
                                <?php endforeach;?>    
                                    <hr>
                                    <div class = "fltRight">
                                        <img src = "assets/images/view-all-trips.jpg">
                                    </div>
                                    <div class = "clear"></div>    
                               
                            </div>
                    </div><!--featuredDiv end-->