<?php
/*
*@package:Adventure Club
*Page Top Header
*/
	if ( ! defined('WEB_ROOT')) exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Adventure Club Inc.</title>

    <link href="<?=SITE_URL?>/assets/css/bootstrap-responsive.css" type="text/css" rel="stylesheet" />
    <link href="<?=SITE_URL?>/assets/css/navbar.css" type="text/css" rel="stylesheet" />
    <link href="<?=SITE_URL?>/assets/css/carousel.css" rel="stylesheet">
    <link href="<?=SITE_URL?>/assets/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=SITE_URL?>/assets/css/nivo/default.css" type="text/css" media="screen" />
    <link href="<?=SITE_URL?>/assets/css/style.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="<?=SITE_URL?>/assets/css/nivo/nivo-slider.css" type="text/css" media="screen" />
    <link href="<?=SITE_URL?>/assets/css/jquery.bxslider.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?=SITE_URL?>/assets/css/datepicker.css" type="text/css" media="screen" />

    <script type="text/javascript" src="<?=SITE_URL?>/assets/js/jquery-1.9.1.min.js"></script>  
    <script src="<?=SITE_URL?>/assets/js/bootstrap.js"></script>
    <script src="<?=SITE_URL?>/assets/js/bootstrap-datepicker.js"></script>
    <script src="<?=SITE_URL?>/assets/html5lightbox/html5lightbox.js"></script>
    <script type="text/javascript" src="<?=SITE_URL?>/assets/js/jquery.nivo.slider.pack.js"></script>
    <script src="<?=SITE_URL?>/assets/js/jquery.bxslider.min.js"></script>
    <script type="text/javascript">  
        $(document).ready(function () {  
            $('.dropdown-toggle').dropdown();
            $('.bxslider').bxSlider({
                slideWidth: 350,
                minSlides: 3,
                maxSlides: 3,
                pager: false
              });
            $('#datepicker1').datepicker()
            $('#datepicker2').datepicker()
        });  
         var html5lightbox_options = {
            watermark: "Adventure Club",
            watermarklink: '<?=SITE_URL?>'
        };
    </script>
    <script type="text/javascript">
            $(window).load(function() {
            $('#slider').nivoSlider({
                effect:'fade'
            });
        });
    </script>
</head> 
<body>