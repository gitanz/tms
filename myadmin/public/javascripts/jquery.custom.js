/*! Jquery Custom Library - 20th Dec 2013\n* http://jaygaha.com.np*/
	$("[rel=tooltip]").tooltip();
	$(function() {
		var iti = $("input[name='menu_itinerary']").val();
		if(iti == 1){
			$("#ifItinerary").show();
			$("#altNameforTab").show();
		}  
		$("input[name='menu_itinerary']").click(function(){
			var value = $(this).val();
			if(value==1){
				$("#ifItinerary").show();
					var checked = ($("input#homechecked:checked").length);
			}
			else if(value==0){
				$("#ifItinerary").hide();	
			}
		});
		
		$("input#homechecked").on("click", function(){
			var checked = $( "input#homechecked:checked" ).length;
			if(checked===1){
				$("#altNameforTab").show();
			}
			else{
				$("#altNameforTab").hide();
			}
		});

		$.selectall('input#selectall', '.checkbxtd');
		$('.disclose').on('click', function() {
			$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
		})
		$('ol.sortable').nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			maxLevels: 5,

			isTree: true,
			expandOnHover: 700,
			startCollapsed: true,
			update: function() {
				/*var arraied = $(this).nestedSortable('toArray', {startDepthCount: 0});
				alert(arraied);*/
				var order = $(this).nestedSortable("serialize");
				//var order = $(this).nestedSortable('toArray', {startDepthCount: 0});
				$.post(admin_url + "/menu/ajax_order", order, function(theResponse){
					$(".notification").html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button>Menu order updated successfully.</div>');
				});
			}
		});
		$('ol#bannerSort').nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			maxLevels: 5,

			isTree: true,
			expandOnHover: 700,
			startCollapsed: true,
			update: function() {
				var order = $(this).nestedSortable("serialize");
				$.post(admin_url + "/banners/ajax_order", order, function(theResponse){
					$(".notification").html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button>Menu order updated successfully.</div>');
				});
			}
		});
		$('ol#sortableCats').nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			maxLevels: 5,

			isTree: true,
			expandOnHover: 700,
			startCollapsed: true,
			update: function() {
				var order = $(this).nestedSortable("serialize");
				$.post(admin_url + "/itineraries/ajax_order_cats", order, function(theResponse){
					$(".notification").html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button>Menu order updated successfully.</div>');
				});
			}
		});				
		$('.iframe-btn').fancybox({
		  'width'	: 900,
		  'height'	: 800,
		  'type'	: 'iframe',
		  'autoScale'   : false
      	});
		$("a.inline").fancybox();
		$('#datetime').datetimepicker({
			dateFormat: 'yy-mm-dd',
			showSecond: true,
			timeFormat: 'HH:mm:ss',	
		});
		$('.datetime').datetimepicker({
			dateFormat: 'yy-mm-dd',
			showSecond: true,
			timeFormat: 'HH:mm:ss',	
		});		
		$('#datetime1').datetimepicker({
			dateFormat: 'yy-mm-dd',
			showSecond: true,
			timeFormat: 'HH:mm:ss',	
		});
		$( "#job_opening" ).datepicker({
			changeMonth: true,
			dateFormat: 'yy-mm-dd',
			onClose: function( selectedDate ) {
				$( "#job_closing" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		
		$( "#job_closing" ).datepicker({
			changeMonth: true,
			dateFormat: 'yy-mm-dd',
			onClose: function( selectedDate ) {
				$( "#job_opening" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	
		
		$("#tripPrice").change(function(){
			var priceVal = "";
			priceVal = $("select#tripPrice option:selected").val();
			if(priceVal == 1){
				$('#trekkingPrice').slideUp();
				$('#tourPrice').slideDown();
			}
			else if(priceVal == 2){
				$('#trekkingPrice').slideDown();
				$('#tourPrice').slideUp();
			}
			else if(priceVal == 0){
				$('#trekkingPrice').slideUp();
				$('#tourPrice').slideUp();
			}
			else{
				$('#trekkingPrice').slideUp();
				$('#tourPrice').slideUp();
			}
		});
		// var iti = $("input#radio1").val();

		
		var next = 1;
    	$(".add-more").click(function(e){
        	e.preventDefault();
			var count =$('div.controls-field').length;
			//alert(count);
	        var addto = "#b" + count;
    	    next = count + 1;
        	var newIn = '<div class="controls-field" id="b'+next+'"><br /><label>Banner Title '+next+'</label><input type="text" name="banner_title[]" value="" class="input-xlarge" placeholder="Enter banner title here" /><label class="control-label">Image '+next+'</label><div class="input-append"><input type="text" id="bannerImg' + next + '" name="banner_image[]" /><button type="button" class="btn iframe-btn" href="' + admin_url + '/libraries/filemanager/dialog.php?type=1&amp;field_id=bannerImg' + next + '">Select</button></div></div>';
			//<button id="b'+next+'" onClick="$(this).parents(\'div#b'+next+'\').remove();$(\'#count\').val('+next+'-1);" class="btn btn-danger" type="button">-</button>
	        var newInput = $(newIn);
    	    $(addto).after(newInput);
    	});
		
		$(".add-more-gallery").click(function(e){
        	e.preventDefault();
			var count =$('div.controls-field').length;
			//alert(count);
	        var addto = "#b" + count;
    	    next = count + 1;
        	var newIn = '<div class="controls-field" id="b'+next+'"><br /><label>Caption '+next+'</label><input type="text" name="gallery_titles[]" value="" class="input-xlarge" placeholder="Enter caption here" /><label class="control-label">Image '+next+'</label><div class="input-append"><input type="text" id="galleryImg' + next + '" name="gallery_image[]" /><button type="button" class="btn iframe-btn" href="' + admin_url + '/libraries/filemanager/dialog.php?type=1&amp;field_id=galleryImg' + next + '">Select</button></div></div>';
			//<button id="b'+next+'" onClick="$(this).parents(\'div#b'+next+'\').remove();$(\'#count\').val('+next+'-1);" class="btn btn-danger" type="button">-</button>
	        var newInput = $(newIn);
    	    $(addto).after(newInput);
    	});
    	$(".add-more-video").click(function(e){
        	e.preventDefault();
			var count =$('div.controls-field').length;
			//alert(count);
	        var addto = "#b" + count;
    	    next = count + 1;
        	var newIn = '<div class="controls-field" id="b'+next+'"><br /><label>Caption '+next+'</label><input type="text" name="video_titles[]" value="" class="input-xlarge" placeholder="Enter caption here" /><label class="control-label">Video Image'+next+'</label><div class="input-append"><input type="text" id="videoimg' + next + '" name="video_image[]" placeholder="Select video image" /><button type="button" class="btn iframe-btn" href="' + admin_url + '/libraries/filemanager/dialog.php?type=1&amp;field_id=videoimg' + next + '">Select</button></div><label class="control-label">Video '+next+'</label><div class="input-append"><input type="text" id="video' + next + '" name="video_path[]" placeholder = "Select Video" /><button type="button" class="btn iframe-btn" href="' + admin_url + '/libraries/filemanager/dialog.php?type=2&amp;field_id=video' + next + '">Select</button></div></div>';
			//<button id="b'+next+'" onClick="$(this).parents(\'div#b'+next+'\').remove();$(\'#count\').val('+next+'-1);" class="btn btn-danger" type="button">-</button>
	        var newInput = $(newIn);
    	    $(addto).after(newInput);
    	});
		$(".add-more-social").click(function(e){
        	e.preventDefault();
			var count =$('div.controls-field').length;
			//alert(count);
	        var addto = "#b" + count;
    	    next = count + 1;
        	var newIn = '<div class="controls-field" id="b'+next+'"><br /><label>Social Link '+next+'</label><input type="url" required pattern="https?://.+" name="site_social_links[]" value="" class="input-xxlarge" placeholder="Enter social URL" /><label class="control-label">Social Icon '+next+'</label><div class="input-append"><input type="text" class="input-xxlarge" id="socialImg' + next + '" name="site_social_icons[]" placeholder="Enter social icon" /><button type="button" class="btn iframe-btn" href="' + admin_url + '/libraries/filemanager/dialog.php?type=1&amp;field_id=socialImg' + next + '">Select</button></div></div>';
			//<button id="b'+next+'" onClick="$(this).parents(\'div#b'+next+'\').remove();$(\'#count\').val('+next+'-1);" class="btn btn-danger" type="button">-</button>
	        var newInput = $(newIn);
    	    $(addto).after(newInput);
    	});
		$(".add-more-assoc").click(function(e){
        	e.preventDefault();
			var count =$('div.controls-field').length;
			//alert(count);
	        var addto = "#b" + count;
    	    next = count + 1;
        	var newIn = '<div class="controls-field" id="b'+next+'"><br /><label>Association Link '+next+'</label><input type="url" required pattern="https?://.+" name="site_assoc_links[]" value="" class="input-xxlarge" placeholder="Enter association URL" /><label class="control-label">Association Icon '+next+'</label><div class="input-append"><input type="text" class="input-xxlarge" id="assocImg' + next + '" name="site_assoc_icons[]" placeholder="Enter association icon" /><button type="button" class="btn iframe-btn" href="' + admin_url + '/libraries/filemanager/dialog.php?type=1&amp;field_id=assocImg' + next + '">Select</button></div></div>';
			//<button id="b'+next+'" onClick="$(this).parents(\'div#b'+next+'\').remove();$(\'#count\').val('+next+'-1);" class="btn btn-danger" type="button">-</button>
	        var newInput = $(newIn);
    	    $(addto).after(newInput);
    	});
		$('.inline-edit').editable();
		$(".delete_image").click(function(){
			var del_id = $(this).attr('id');
			if(confirm("Sure you want to delete this image?")){
				$.ajax({
					type: "POST",
					url: admin_url + "/gallery/ajax_image_delete",
					data: 'pk=' + del_id,
					success: function(){}
				});
				$(this).parents(".dintro").animate({ backgroundColor: "#e91544" }, "fast").animate({ opacity: "hide" }, "slow");
			}
			return false;
		});
		$(".idelete_image").click(function(){
			var delete_id = $(this).attr('id');
			if(confirm("Sure you want to delete this image?")){
				$.ajax({
					type: "POST",
					url: admin_url + "/itineraries/ajax_image_delete",
					data: 'pk=' + delete_id,
					success: function(){}
				});
				$(this).parents(".dintro").animate({ backgroundColor: "#e91544" }, "fast").animate({ opacity: "hide" }, "slow");
			}
			return false;
		});
		$(".idelete_video").click(function(){
			var delete_vid = $(this).attr('id');
			if(confirm("Sure you want to delete this video?")){
				$.ajax({
					type: "POST",
					url: admin_url + "/itineraries/ajax_video_delete",
					data: 'pk=' + delete_vid,
					success: function(){}
				});
				$(this).parents(".dintro").animate({ backgroundColor: "#e91544" }, "fast").animate({ opacity: "hide" }, "slow");
			}
			return false;
		});
		// $("span.removable").click(function(e){
		// 	e.preventDefault;
		// 	alert("cakhsdk");
		// });
		$("#addmoresection").click(function(){
			var count = $("div[id^='addable']").length;
    		var ecount = count-1;
    		if(ecount == "0") ecount = "";
    		var markup = $("#form").html();
    		$("#addin").append(function(){
    			return "<div id = 'addable"+count+"' class = 'well' style = 'margin:0 0 10px 0;'>"+'<div class = "pull-right" style = "margin-top:-15px"><span id = "removable'+count+'" onClick = "abc('+count+')" style = "padding:5px 10px; font-weight:bold;background:#C75050;color:white;cursor:pointer">X</span></div>'+markup+"</div>";
    		});
    	});
		$(".delete_country").click(function(){
			var del_id = $(this).attr('id');
			if(confirm("Sure you want to delete this country?\nIt will delete all vacancies associated with it.")){
				$.ajax({
					type: "POST",
					url: admin_url + "/careers/ajax_country_delete",
					data: 'pk=' + del_id,
					success: function(){}
				});
				$(this).parents(".dintro").animate({ backgroundColor: "#e91544" }, "fast").animate({ opacity: "hide" }, "slow");
			}
			return false;
		});
		$(".delete_category").click(function(){
			var del_id = $(this).attr('id');
			if(confirm("Sure you want to delete this category?\nIt will delete all vacancies associated with it.")){
				$.ajax({
					type: "POST",
					url: admin_url + "/careers/ajax_category_delete",
					data: 'pk=' + del_id,
					success: function(){}
				});
				$(this).parents(".dintro").animate({ backgroundColor: "#e91544" }, "fast").animate({ opacity: "hide" }, "slow");
			}
			return false;
		});
		$(".delete_candidate").click(function(){
			var del_id = $(this).attr('id');
			if(confirm("Sure you want to delete this candidate?")){
				$.ajax({
					type: "POST",
					url: admin_url + "/careers/ajax_candidate_delete",
					data: 'pk=' + del_id,
					success: function(){}
				});
				$(this).parents(".candidate_record").animate({ backgroundColor: "#e91544" }, "fast").animate({ opacity: "hide" }, "slow");
			}
			return false;
		});
		$(function () {
    $( '#table' ).searchable({
        striped: true,
        oddRow: { 'background-color': '#f5f5f5' },
        evenRow: { 'background-color': '#fff' },
        searchType: 'fuzzy'
    });
    
   
    $( '#searchable-container' ).searchable({
        searchField: '#container-search',
        selector: '.row',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    });
});
	});
	
	function abc(id){
		$("#addable"+id).remove();
	}
	(function($){$.extend({selectall:function(all,child){$(all).on("click",function(){if($(all).prop("checked"))$(child).prop("checked","checked");else $(child).removeAttr("checked")});$(child).on("click",function(){if($(child+":not(:checked)").length>0)$(all).removeAttr("checked");else $(all).prop("checked","checked")})}})})(jQuery);
	
	tinymce.init({
    	selector: "#tinyEditor",
	    height: 300,
	    plugins: [
    	     "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        	 "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
	         "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
   		],
	    relative_urls: false,
    	browser_spellcheck : true ,
	    filemanager_title:"Responsive Filemanager",
    	external_filemanager_path:admin_url + "/libraries/filemanager/",
	    external_plugins: { "filemanager" : admin_url + "/libraries/filemanager/plugin.min.js"},  
	   	image_advtab: true,
	   	toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
	   	toolbar2: "| responsivefilemanager | image | media | link unlink anchor | print preview code  | colorpicker forecolor backcolor"
	 });
	tinymce.init({
    	selector: "#tinyEditor1",
	    height: 300,
	    plugins: [
    	     "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        	 "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
	         "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
   		],
	    relative_urls: false,
    	browser_spellcheck : true ,
	    filemanager_title:"Responsive Filemanager",
    	external_filemanager_path:admin_url + "/libraries/filemanager/",
	    external_plugins: { "filemanager" : admin_url + "/libraries/filemanager/plugin.min.js"},  
	   	image_advtab: true,
	   	toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
	   	toolbar2: "| responsivefilemanager | image | media | link unlink anchor | print preview code  | colorpicker forecolor backcolor"
	 });
	tinymce.init({
    	selector: "#tinyEditor2",
	    height: 300,
	    plugins: [
    	     "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        	 "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
	         "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
   		],
	    relative_urls: false,
    	browser_spellcheck : true ,
	    filemanager_title:"Responsive Filemanager",
    	external_filemanager_path:admin_url + "/libraries/filemanager/",
	    external_plugins: { "filemanager" : admin_url + "/libraries/filemanager/plugin.min.js"},  
	   	image_advtab: true,
	   	toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
	   	toolbar2: "| responsivefilemanager | image | media | link unlink anchor | print preview code  | colorpicker forecolor backcolor"
	 });
		tinymce.init({
    	selector: "#tinyEditor3",
	    height: 300,
	    plugins: [
    	     "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        	 "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
	         "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
   		],
	    relative_urls: false,
    	browser_spellcheck : true ,
	    filemanager_title:"Responsive Filemanager",
    	external_filemanager_path:admin_url + "/libraries/filemanager/",
	    external_plugins: { "filemanager" : admin_url + "/libraries/filemanager/plugin.min.js"},  
	   	image_advtab: true,
	   	toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
	   	toolbar2: "| responsivefilemanager | image | media | link unlink anchor | print preview code  | colorpicker forecolor backcolor"
	 });

