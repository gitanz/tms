<?php
	if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');

?>
<script type="text/javascript" src="<?=SITE_URL?>/assets/js/jquery.nivo.slider.pack.js"></script>
<script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=SITE_URL?>/assets/js/jquery.msform.js"></script>

<script type="text/javascript">  
$(document).ready(function () {  
	 $('#slider').nivoSlider({
                // effect:'slideInLeft'
     });
	$('.dropdown-toggle').dropdown();
 //    $('.bxslider').bxSlider({
	//     slideWidth: 350,
	//     minSlides: 3,
	//     maxSlides: 3,
	//     pager: false
	//     });
    });  
	$('#myTab a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	});

	$("#extentions").click(function(){
		$("li.tab.active").removeClass("active");
	    $(this).addClass("active");
	    $.ajax({
	    	type: "POST",
		    url: '<?=SITE_URL?>/itineraries/do_ajax',
		    dataType:'json',
		    cache: 'false',
		    data:{
		    iType:'extention',
	    	},
	    beforeSend:function(){
	    	$(".tab-content").html('<img width= "100" src="assets/images/loading.gif" align="absmiddle" /> processing...');
	    	},
	    success: function(data){
	    	$(".tab-content").html(data.message);
	    	}                                     
		});
		return false;
	});
	$("select#holidaytype").change(function(){
	    var pid = $(this).val();
	    // alert(pid);
	    $.ajax({
	    	type: "POST",
		    url: '<?=SITE_URL?>/itineraries/ajax_holidays',
		    dataType:'json',
		    cache: 'false',
		    data:{
		    	id:pid,
	    	},
	    beforeSend:function(){
	    	$("#holidays").html('<option>processing...</option>');
	    	},
	    success: function(data){
	    	$("#holidays").html(data.message);
	    	}                                     
		});
	});
	$("select#holidays").change(function(){
		var val = $(this).val();
		window.location.href = "<?=SITE_URL?>/itineraries/book/"+val;
	});
	$("#addreview").click(function(){
		alert("clicked");	
	});

	<?php if(isset($tabs)): foreach($tabs as $key=>$value):?>
	$("#<?=$key?>").click(function(){
	$("li.tab.active").removeClass("active");
    $(this).addClass("active");
    $.ajax({
    	type: "POST",
	    url: '<?=SITE_URL?>/itineraries/getAjax/<?=$key?>',
	    dataType:'json',
	    cache: 'false',
	    data:{
	    tId:'<?=$this->result->trip_id?>',
    	},
	    beforeSend:function(){
	    	$(".tab-content").html('<img src="<?=SITE_URL?>/assets/images/loading.gif" align="absmiddle" /> processing...');
	    },
	    success: function(data){
	    	$(".tab-content").html(data.message);
	    }                                     
    });	
    return false;
});
<?php endforeach;endif;?>
$('a.gallery').colorbox({rel:'gal'});
$("a.px1").colorbox({rel:'a.px1', maxWidth:"90%", maxHeight:"80%"});
$("a.px2").colorbox({rel:'a.px2', maxWidth:"90%", maxHeight:"80%"});
</script>
<script type="text/javascript">
$(window).load(function() {
    $('#slider').nivoSlider({
    effect:'slideInLeft'
    });
	});
</script>
</body>

</html>
