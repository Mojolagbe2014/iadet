<?php 
session_start();
define("CONST_FILE_PATH", "includes/constants.php");
include ('classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$websiteTrainingFacilityObj = new WebsiteTrainingFacility($dbObj); // Create an object of WebsiteTrainingFacility class

$thisPage->title = StringManipulator::trimStringToFullWord(62, stripslashes(strip_tags(WebsiteTrainingFacility::getSingle($dbObj, 'title', 1))));
$thisPage->description = StringManipulator::trimStringToFullWord(150, stripslashes(strip_tags(WebsiteTrainingFacility::getSingle($dbObj, 'description', 1))));
$thisPage->keywords = WebsiteTrainingFacility::getSingle($dbObj, 'keywords', 1);
$thisPage->author = WEBSITE_AUTHOR;
?>
<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="ie ie6 lte9 lte8 lte7" lang="en-US" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 7]>     <html class="ie ie7 lte9 lte8 lte7" lang="en-US" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 8]>     <html class="ie ie8 lte9 lte8" lang="en-US" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 9]>     <html class="ie ie9 lte9" lang="en-US" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if gt IE 9]>  <html> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en-US" prefix="og: http://ogp.me/ns#"> <!--<![endif]-->
<head>
    <?php include ('includes/meta-tags.php'); ?>
    <?php include ('includes/analytics.php'); ?>
    <link rel='stylesheet' id='dt-sc-css-css'  href='plugins/designthemes-core-features/shortcodes/css/shortcodesf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='jeweltheme-jquery-ui-style-css'  href='plugins/wp-awesome-faq/jquery-uif9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='layerslider-css'  href='plugins/LayerSlider/static/css/layerslider3c21.css?ver=5.1.1' type='text/css' media='all' />
    <link rel='stylesheet' id='ls-google-fonts-css'  href='http://fonts.googleapis.com/css?family=Lato:100,300,regular,700,900|Open+Sans:300|Indie+Flower:regular|Oswald:300,regular,700&amp;subset=latin,latin-ext' type='text/css' media='all' />
    <link rel='stylesheet' id='bbp-default-css'  href='themes/Guru/css/bbpress98d8.css?ver=2.5.4-5380' type='text/css' media='screen' />
    <link rel='stylesheet' id='bp-parent-css-css'  href='themes/Guru/css/buddypressdc8c.css?ver=2.2' type='text/css' media='screen' />
    <link rel='stylesheet' id='contact-form-7-css'  href='plugins/contact-form-7/includes/css/styles2f54.css?ver=4.1' type='text/css' media='all' />
    <link rel='stylesheet' id='bwg_frontend-css'  href='plugins/photo-gallery/css/bwg_frontend2a18.css?ver=1.2.15' type='text/css' media='all' />
    <link rel='stylesheet' id='bwg_font-awesome-css'  href='plugins/photo-gallery/css/font-awesome/font-awesomeae82.css?ver=4.2.0' type='text/css' media='all' />
    <link rel='stylesheet' id='bwg_mCustomScrollbar-css'  href='plugins/photo-gallery/css/jquery.mCustomScrollbar2a18.css?ver=1.2.15' type='text/css' media='all' />
    <link rel='stylesheet' id='responsive_map_css-css'  href='plugins/responsive-maps-plugin/includes/css/rsmaps6f16.css?ver=2.22' type='text/css' media='all' />
    <link rel='stylesheet' id='rs-plugin-settings-css'  href='plugins/revslider/rs-plugin/css/settings17d1.css?rev=4.6.0&amp;ver=4.0' type='text/css' media='all' />
    <style type='text/css'> .tp-caption a{color:#ff7302;text-shadow:none;-webkit-transition:all 0.2s ease-out;-moz-transition:all 0.2s ease-out;-o-transition:all 0.2s ease-out;-ms-transition:all 0.2s ease-out}.tp-caption a:hover{color:#ffa902}</style>
    <link rel='stylesheet' id='woothemes-sensei-frontend-css'  href='plugins/woothemes-sensei/assets/css/frontend1f22.css?ver=1.6.2' type='text/css' media='screen' />
    <link rel='stylesheet' id='default-css'  href='themes/Guru/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='shortcode-css'  href='themes/Guru/css/shortcodef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='skin-css'  href='themes/Guru/skins/dark-blue/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='animations-css'  href='themes/Guru/css/animationsf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='menumenu-css'  href='themes/Guru/css/meanmenuf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='isotope-css'  href='themes/Guru/css/isotopef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='prettyphoto-css'  href='themes/Guru/css/prettyPhotof9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='style.fontawesome-css'  href='themes/Guru/css/font-awesome.minf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='responsive-css'  href='themes/Guru/css/responsivef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='stylesensei-css'  href='themes/Guru/sensei/css/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='et_lb_modules-css'  href='plugins/elegantbuilder/style7793.css?ver=2.4' type='text/css' media='all' />
    <link rel='stylesheet' id='fancybox-css'  href='plugins/easy-fancybox/fancybox/jquery.fancybox-1.3.7.min00e2.css?ver=1.5.7' type='text/css' media='screen' />
    <link rel='stylesheet' id='mytheme-google-fonts-css'  href='../../fonts.googleapis.com/cssb7b0.css?family=Open+Sans:300,400,600,700|Droid+Serif:400,400italic,700,700italic|Pacifico|Patrick+Hand|Crete+Round:400' type='text/css' media='all' />
    <script type='text/javascript' src='js/jquery/jquery90f9.js?ver=1.11.1'></script>
    <script src="sweet-alert/sweetalert.min.js" type="text/javascript"></script>
    <script type='text/javascript' src='js/jquery/jquery-migrate.min1576.js?ver=1.2.1'></script>
    <script type='text/javascript' src='js/jquery/ui/jquery.ui.core.min2c18.js?ver=1.10.4'></script>
    <script type='text/javascript' src='js/jquery/ui/jquery.ui.widget.min2c18.js?ver=1.10.4'></script>
    <script type='text/javascript' src='js/jquery/ui/jquery.ui.accordion.min2c18.js?ver=1.10.4'></script>
    <script type='text/javascript' src='plugins/wp-awesome-faq/accordion68b3.js?ver=1'></script>
    <script type='text/javascript' src='plugins/LayerSlider/static/js/layerslider.kreaturamedia.jquery3c21.js?ver=5.1.1'></script>
    <script type='text/javascript' src='plugins/LayerSlider/static/js/greensock4a80.js?ver=1.11.2'></script>
    <script type='text/javascript' src='plugins/LayerSlider/static/js/layerslider.transitions3c21.js?ver=5.1.1'></script>
    <script type='text/javascript' src='plugins/revslider/rs-plugin/js/jquery.themepunch.tools.min17d1.js?rev=4.6.0&amp;ver=4.0'></script>
    <script type='text/javascript' src='plugins/revslider/rs-plugin/js/jquery.themepunch.revolution.min17d1.js?rev=4.6.0&amp;ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/modernizr-2.6.2.minf9b8.js?ver=4.0'></script>
    <style type="text/css">
            .breadcrumb-wrapper { background-color: #23a4db; }.breadcrumb-wrapper, .breadcrumb-wrapper h1, .breadcrumb-wrapper .breadcrumb h4, .breadcrumb a { color: #ffffff; }    .gobutton{
        cursor:pointer; /*forces the cursor to change to a hand when the button is hovered*/
        padding:5px 25px; /*add some padding to the inside of the button*/
        background:#35b128; /*the colour of the button*/
        border:1px solid #33842a; /*required or the default border for the browser will appear*/
        /*give the button curved corners, alter the size as required*/
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px;
        /*give the button a drop shadow*/
        -webkit-box-shadow: 0 0 4px rgba(0,0,0, .75);
        -moz-box-shadow: 0 0 4px rgba(0,0,0, .75);
        box-shadow: 0 0 4px rgba(0,0,0, .75);
        /*style the text*/
        color:#f3f3f3;
        font-size:1.6em;
        margin: 0 auto;
        float: left;
        }
        /***NOW STYLE THE BUTTON'S HOVER AND FOCUS STATES***/
        .gobutton:hover, .gobutton:focus{
        background-color :#399630; /*make the background a little darker*/
        /*reduce the drop shadow size to give a pushed button effect*/
        -webkit-box-shadow: 0 0 1px rgba(0,0,0, .75);
        -moz-box-shadow: 0 0 1px rgba(0,0,0, .75);
        box-shadow: 0 0 1px rgba(0,0,0, .75);
    color:#f3f3f3;
        }
    </style>
    <!-- Easy FancyBox 1.5.7 using FancyBox 1.3.7 - RavanH (http://status301.net/wordpress-plugins/easy-fancybox/) -->
    <script type="text/javascript">
    /* <![CDATA[ */
    var fb_timeout = null;
    var fb_opts = { 'overlayShow' : true, 'hideOnOverlayClick' : true, 'showCloseButton' : true, 'centerOnScroll' : true, 'enableEscapeButton' : true, 'autoScale' : true };
    var easy_fancybox_handler = function(){
            /* IMG */
            var fb_IMG_select = 'a[href*=".jpg"]:not(.nofancybox,.pin-it-button), area[href*=".jpg"]:not(.nofancybox), a[href*=".jpeg"]:not(.nofancybox,.pin-it-button), area[href*=".jpeg"]:not(.nofancybox), a[href*=".png"]:not(.nofancybox,.pin-it-button), area[href*=".png"]:not(.nofancybox)';
            jQuery(fb_IMG_select).addClass('fancybox image');
            var fb_IMG_sections = jQuery('div.gallery');
            fb_IMG_sections.each(function() { jQuery(this).find(fb_IMG_select).attr('rel', 'gallery-' + fb_IMG_sections.index(this)); });
            jQuery('a.fancybox, area.fancybox, li.fancybox a:not(li.nofancybox a)').fancybox( jQuery.extend({}, fb_opts, { 'type' : 'image', 'transitionIn' : 'elastic', 'easingIn' : 'easeOutBack', 'transitionOut' : 'elastic', 'easingOut' : 'easeInBack', 'opacity' : false, 'hideOnContentClick' : false, 'titleShow' : true, 'titlePosition' : 'over', 'titleFromAlt' : true, 'showNavArrows' : true, 'enableKeyboardNav' : true, 'cyclic' : false }) );
            /* Inline */
            jQuery('a.fancybox-inline, area.fancybox-inline, li.fancybox-inline a').fancybox( jQuery.extend({}, fb_opts, { 'type' : 'inline', 'autoDimensions' : true, 'scrolling' : 'no', 'easingIn' : 'easeOutBack', 'easingOut' : 'easeInBack', 'opacity' : false, 'hideOnContentClick' : false }) );
            /* PDF */
            jQuery('a[href*=".pdf"]:not(.nofancybox), area[href*=".pdf"]:not(.nofancybox)').addClass('fancybox-pdf');
            jQuery('a.fancybox-pdf, area.fancybox-pdf, li.fancybox-pdf a:not(li.nofancybox a)').fancybox( jQuery.extend({}, fb_opts, { 'type' : 'html', 'width' : '90%', 'height' : '90%', 'padding' : 10, 'titleShow' : false, 'titlePosition' : 'float', 'titleFromAlt' : true, 'autoDimensions' : false, 'scrolling' : 'no', 'onStart' : function(selectedArray, selectedIndex, selectedOpts) { selectedOpts.content = '<embed src="' + selectedArray[selectedIndex].href + '#toolbar=1&navpanes=0&nameddest=self&page=1&view=FitH,0&zoom=80,0,0" type="application/pdf" height="100%" width="100%" />' } }) );
            /* SWF */
            jQuery('a[href*=".swf"]:not(.nofancybox), area[href*=".swf"]:not(.nofancybox)').addClass('fancybox-swf');
            jQuery('a.fancybox-swf, area.fancybox-swf, li.fancybox-swf a:not(li.nofancybox a)').fancybox( jQuery.extend({}, fb_opts, { 'type' : 'swf', 'width' : 680, 'height' : 495, 'padding' : 0, 'titleShow' : false, 'titlePosition' : 'float', 'titleFromAlt' : true, 'swf' : {'wmode':'opaque','allowfullscreen':true} }) );
            /* SVG */
            jQuery('a[href$=".svg"]:not(.nofancybox), area[href$=".svg"]:not(.nofancybox)').addClass('fancybox-svg');
            jQuery('a.fancybox-svg, area.fancybox-svg, li.fancybox-svg a:not(li.nofancybox a)').fancybox( jQuery.extend({}, fb_opts, { 'type' : 'svg', 'width' : 680, 'height' : 495, 'padding' : 0, 'titleShow' : false, 'titlePosition' : 'float', 'titleFromAlt' : true, 'svg' : {'wmode':'opaque','allowfullscreen':true} }) );
            /* YouTube */
            jQuery('a[href*="youtube.com/watch"]:not(.nofancybox), area[href*="youtube.com/watch"]:not(.nofancybox)').addClass('fancybox-youtube');
            jQuery('a[href*="youtu.be/"]:not(.nofancybox), area[href*="youtu.be/"]:not(.nofancybox)').addClass('fancybox-youtube');
            jQuery('a.fancybox-youtube, area.fancybox-youtube, li.fancybox-youtube a:not(li.nofancybox a)').fancybox( jQuery.extend({}, fb_opts, { 'type' : 'iframe', 'width' : 640, 'height' : 360, 'padding' : 0, 'titleShow' : false, 'titlePosition' : 'float', 'titleFromAlt' : true, 'onStart' : function(selectedArray, selectedIndex, selectedOpts) { selectedOpts.href = selectedArray[selectedIndex].href.replace(new RegExp('youtu.be', 'i'), 'www.youtube.com/embed').replace(new RegExp('watch\\?(.*)v=([a-z0-9\_\-]+)(&amp;|&|\\?)?(.*)', 'i'), 'embed/$2?$1$4'); var splitOn = selectedOpts.href.indexOf('?'); var urlParms = ( splitOn > -1 ) ? selectedOpts.href.substring(splitOn) : ""; selectedOpts.allowfullscreen = ( urlParms.indexOf('fs=0') > -1 ) ? false : true } }) );
            /* Vimeo */
            jQuery('a[href*="vimeo.com/"]:not(.nofancybox), area[href*="vimeo.com/"]:not(.nofancybox)').addClass('fancybox-vimeo');
            jQuery('a.fancybox-vimeo, area.fancybox-vimeo, li.fancybox-vimeo a:not(li.nofancybox a)').fancybox( jQuery.extend({}, fb_opts, { 'type' : 'iframe', 'width' : 500, 'height' : 281, 'padding' : 0, 'titleShow' : false, 'titlePosition' : 'float', 'titleFromAlt' : true, 'onStart' : function(selectedArray, selectedIndex, selectedOpts) { selectedOpts.href = selectedArray[selectedIndex].href.replace(new RegExp('//(www\.)?vimeo\.com/([0-9]+)(&|\\?)?(.*)', 'i'), '//player.vimeo.com/video/$2?$4'); var splitOn = selectedOpts.href.indexOf('?'); var urlParms = ( splitOn > -1 ) ? selectedOpts.href.substring(splitOn) : ""; selectedOpts.allowfullscreen = ( urlParms.indexOf('fullscreen=0') > -1 ) ? false : true } }) );
            /* Dailymotion */
            jQuery('a[href*="dailymotion.com/"]:not(.nofancybox), area[href*="dailymotion.com/"]:not(.nofancybox)').addClass('fancybox-dailymotion');
            jQuery('a.fancybox-dailymotion, area.fancybox-dailymotion, li.fancybox-dailymotion a:not(li.nofancybox a)').fancybox( jQuery.extend({}, fb_opts, { 'type' : 'iframe', 'width' : 560, 'height' : 315, 'padding' : 0, 'titleShow' : false, 'titlePosition' : 'float', 'titleFromAlt' : true, 'onStart' : function(selectedArray, selectedIndex, selectedOpts) { selectedOpts.href = selectedArray[selectedIndex].href.replace(new RegExp('/video/(.*)', 'i'), '/embed/video/$1'); var splitOn = selectedOpts.href.indexOf('?'); var urlParms = ( splitOn > -1 ) ? selectedOpts.href.substring(splitOn) : ""; selectedOpts.allowfullscreen = ( urlParms.indexOf('fullscreen=0') > -1 ) ? false : true } }) );
            /* iFrame */
            jQuery('a.fancybox-iframe, area.fancybox-iframe, li.fancybox-iframe a').fancybox( jQuery.extend({}, fb_opts, { 'type' : 'iframe', 'width' : '70%', 'height' : '90%', 'padding' : 0, 'titleShow' : false, 'titlePosition' : 'float', 'titleFromAlt' : true }) );
            /* Auto-click */ 
            jQuery('#fancybox-auto').trigger('click');
    }
    /* ]]> */
    </script>
    <link href="sweet-alert/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="sweet-alert/twitter.css" rel="stylesheet" type="text/css"/>
</head>
    
<body class="page page-id-486 page-template page-template-tpl-fullwidth-php custom-background tribe-theme-Guru no-js">
    <div class="main-content">
	<!-- wrapper div starts here -->
    <div id="wrapper">
        <?php include('includes/header.php'); ?> 
        <div class="banner"> 
            <script type="text/javascript">var lsjQuery = jQuery;</script>
            <script type="text/javascript"> lsjQuery(document).ready(function() { if(typeof lsjQuery.fn.layerSlider == "undefined") { lsShowNotice('layerslider_8','jquery'); } else { lsjQuery("#layerslider_8").layerSlider({responsiveUnder: 960, layersContainer: 960, skinsPath: 'plugins/LayerSlider/static/skins/'}) } }); </script>
            <div class="ls-wp-fullwidth-container">
                <div class="ls-wp-fullwidth-helper">
                    <div id="layerslider_8" class="ls-wp-container" style="width:100%;height:480px;margin:0 auto;margin-bottom: 0px;">
                        <div class="ls-slide" data-ls=" transition2d: all;">
                            <img src="plugins/LayerSlider/static/img/blank.gif" data-src="media/web-page/training-facility/<?php echo WebsiteTrainingFacility::getSingle($dbObj, 'top_slider_background', 1); ?>" class="ls-bg" alt="Slide background" /><img class="ls-l" style="top:124px;left:320px;white-space: nowrap;" src="plugins/LayerSlider/static/img/blank.gif" data-src="uploads/2015/02/tintbox620x300.png" alt="Overlay">
                            <h1 class="ls-l" style="top:138px;left:338px;font-size:45px;color:#ffffff;white-space: nowrap;" data-ls="offsetxin:100;delayin:1400;easingin:swing;"><?php echo WebsiteTrainingFacility::getSingle($dbObj, 'top_slider_header', 1); ?></h1><h1 class="ls-l" style="top:206px;left:341px;line-height:36px;color:rgba(255, 255, 255, 0.93);white-space: nowrap;" data-ls="offsetxin:100;delayin:1800;easingin:swing;offsetxout:0;offsetyout:-100;"><?php echo WebsiteTrainingFacility::getSingle($dbObj, 'top_slider_text', 1); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>      
        <!-- content starts here -->
        <div class="content">
            <section class="content-full-width" id="primary">
                <article id="post-486" class="post-486 page type-page status-publish hentry">
                    <div class='fullwidth-section  '  style="background-color:#efefef;background-repeat:no-repeat;">
                        <div class="fullwidth-bg">	
                            <div class="container">
                                <div class='dt-sc-hr-medium '></div>
                                <style>      #bwg_container1_0 #bwg_container2_0 .bwg_standart_thumbnails_0 * {        -moz-box-sizing: border-box;        box-sizing: border-box;      }      #bwg_container1_0 #bwg_container2_0 .bwg_standart_thumb_spun1_0 {        -moz-box-sizing: content-box;        box-sizing: content-box;        background-color: #FFFFFF;        display: inline-block;        height: 90px;        margin: 4px;        padding: 0px;        opacity: 1.00;        filter: Alpha(opacity=100);        text-align: center;        vertical-align: middle;        transition: all 0.3s ease 0s;-webkit-transition: all 0.3s ease 0s;        width: 180px;        z-index: 100;      }      #bwg_container1_0 #bwg_container2_0 .bwg_standart_thumb_spun1_0:hover {        -ms-transform: scale(1.1);        -webkit-transform: scale(1.1);        backface-visibility: hidden;        -webkit-backface-visibility: hidden;        -moz-backface-visibility: hidden;        -ms-backface-visibility: hidden;        opacity: 1;        filter: Alpha(opacity=100);        transform: scale(1.1);        z-index: 102;        position: relative;      }      #bwg_container1_0 #bwg_container2_0 .bwg_standart_thumb_spun2_0 {        border: 0px none #CCCCCC;        border-radius: 0;        box-shadow: 0px 0px 0px #888888;        display: inline-block;        height: 90px;        overflow: hidden;        width: 180px;      }      #bwg_container1_0 #bwg_container2_0 .bwg_standart_thumbnails_0 {        background-color: rgba(255, 255, 255, 0.00);        display: inline-block;        font-size: 0;        max-width: 960px;        text-align: center;      }      #bwg_container1_0 #bwg_container2_0 .bwg_standart_thumbnails_0 a {        border: none;        cursor: pointer;        text-decoration: none;      }      #bwg_container1_0 #bwg_container2_0 .bwg_standart_thumb_0 {        display: inline-block;        text-align: center;      }            #bwg_container1_0 #bwg_container2_0 .bwg_standart_thumb_spun1_0:hover .bwg_title_spun1_0 {        left: 0px;        top: 0px;        opacity: 1;        filter: Alpha(opacity=100);      }      #bwg_container1_0 #bwg_container2_0 .bwg_title_spun2_0 {        color: #CCCCCC;        display: table-cell;        font-family: segoe ui;        font-size: 16px;        font-weight: bold;        height: inherit;        padding: 2px;        text-shadow: 0px 0px 0px #888888;        vertical-align: middle;        width: inherit;        word-wrap: break-word;      }      /*pagination styles*/      #bwg_container1_0 #bwg_container2_0 .tablenav-pages_0 {        text-align: center;        font-size: 12px;        font-family: segoe ui;        font-weight: bold;        color: #666666;        margin: 6px 0 4px;        display: block;        height: 30px;        line-height: 30px;      }      @media only screen and (max-width : 320px) {        #bwg_container1_0 #bwg_container2_0 .displaying-num_0 {          display: none;        }      }      #bwg_container1_0 #bwg_container2_0 .displaying-num_0 {        font-size: 12px;        font-family: segoe ui;        font-weight: bold;        color: #666666;        margin-right: 10px;        vertical-align: middle;      }      #bwg_container1_0 #bwg_container2_0 .paging-input_0 {        font-size: 12px;        font-family: segoe ui;        font-weight: bold;        color: #666666;        vertical-align: middle;      }      #bwg_container1_0 #bwg_container2_0 .tablenav-pages_0 a.disabled,      #bwg_container1_0 #bwg_container2_0 .tablenav-pages_0 a.disabled:hover,      #bwg_container1_0 #bwg_container2_0 .tablenav-pages_0 a.disabled:focus {        cursor: default;        color: rgba(102, 102, 102, 0.5);      }      #bwg_container1_0 #bwg_container2_0 .tablenav-pages_0 a {        cursor: pointer;        font-size: 12px;        font-family: segoe ui;        font-weight: bold;        color: #666666;        text-decoration: none;        padding: 3px 6px;        margin: 0;        border-radius: 0;        border-style: solid;        border-width: 1px;        border-color: #E3E3E3;        background-color: #FFFFFF;        opacity: 1.00;        filter: Alpha(opacity=100);        box-shadow: 0;        transition: all 0.3s ease 0s;-webkit-transition: all 0.3s ease 0s;      }      #bwg_container1_0 #bwg_container2_0 .bwg_back_0 {        background-color: rgba(0, 0, 0, 0);        color: #000000 !important;        cursor: pointer;        display: block;        font-family: segoe ui;        font-size: 16px;        font-weight: bold;        text-decoration: none;        padding: 0;      }      #bwg_container1_0 #bwg_container2_0 #spider_popup_overlay_0 {        background-color: #000000;        opacity: 0.70;        filter: Alpha(opacity=70);      }     .bwg_play_icon_spun_0	 {        width: inherit;        height: inherit;        display: table;        position: absolute;      }	      .bwg_play_icon_0 {        color: #CCCCCC;        font-size: 32px;        vertical-align: middle;        display: table-cell !important;        z-index: 1;        text-align: center;        margin: 0 auto;      }    </style>    
                                <div id="bwg_container1_0">      
                                    <div id="bwg_container2_0">        
                                        <form id="gal_front_form_0" method="post" action="#">                    
                                            <div class="bwg_back_0"></div>          
                                            <div style="background-color:rgba(0, 0, 0, 0); text-align: center; width:100%; position: relative;">            
                                                <div id="ajax_loading_0" style="position:absolute;width: 100%; z-index: 115; text-align: center; height: 100%; vertical-align: middle; display:none;">              
                                                    <div style="display: table; vertical-align: middle; width: 100%; height: 100%; background-color: #FFFFFF; opacity: 0.7; filter: Alpha(opacity=70);">                
                                                        <div style="display: table-cell; text-align: center; position: relative; vertical-align: middle;" >                  
                                                            <div id="loading_div_0" style="display: inline-block; text-align:center; position:relative; vertical-align: middle;">                    
                                                                <img src="plugins/photo-gallery/images/ajax_loader.png" class="spider_ajax_loading" style="float: none; width:50px;">
                                                            </div>                
                                                        </div>              
                                                    </div>            
                                                </div> 
                                                <?php 
                                                $handle = opendir('media/gallery/');
                                                while($file = readdir($handle)){
                                                    if($file !== '.' && $file !== '..'){
                                                ?>
                                                <div id="bwg_standart_thumbnails_0" class="bwg_standart_thumbnails_0">                              
                                                    <a style="font-size: 0;" href="media/gallery/<?php echo $file; ?>" onclick="spider_createpopup('../wp-admin/admin-ajaxdc53.html?tag_id=0&amp;action=GalleryBox&amp;current_view=0&amp;image_id=14&amp;gallery_id=1&amp;theme_id=1&amp;thumb_width=180&amp;thumb_height=90&amp;open_with_fullscreen=0&amp;open_with_autoplay=0&amp;image_width=800&amp;image_height=500&amp;image_effect=fade&amp;wd_sor=order&amp;wd_ord=%20asc%20&amp;enable_image_filmstrip=1&amp;image_filmstrip_height=70&amp;enable_image_ctrl_btn=1&amp;enable_image_fullscreen=1&amp;popup_enable_info=1&amp;popup_info_always_show=0&amp;popup_info_full_width=0&amp;popup_hit_counter=0&amp;popup_enable_rate=0&amp;slideshow_interval=5&amp;enable_comment_social=1&amp;enable_image_facebook=1&amp;enable_image_twitter=1&amp;enable_image_google=1&amp;enable_image_pinterest=0&amp;enable_image_tumblr=0&amp;watermark_type=none&amp;current_url=pagename=europe-training-facility', 0, 800, 500, 1, 'testpopup', 5); return false;">                  
                                                        <span class="bwg_standart_thumb_0">                                        
                                                            <span class="bwg_standart_thumb_spun1_0">                      
                                                                <span class="bwg_standart_thumb_spun2_0">                        			
                                                                    <img class="bwg_standart_thumb_img_0" style="max-height: none !important;  max-width: none !important; padding: 0 !important; width:180px; height:135px; margin-left: 0px; margin-top: -22.5px;" id="14" src="media/gallery/<?php echo $file; ?>" alt="photo" />                      
                                                                </span>                    
                                                            </span>                                      
                                                        </span>                
                                                    </a>                                
                                                </div>                
                                                <?php }} ?>  
                                                <script type="text/javascript">      function spider_page_0(cur, x, y) {        if (jQuery(cur).hasClass('disabled')) {          return false;        }        var items_county_0 = 1;        switch (y) {          case 1:            if (x >= items_county_0) {              document.getElementById('page_number_0').value = items_county_0;            }            else {              document.getElementById('page_number_0').value = x + 1;            }            break;          case 2:            document.getElementById('page_number_0').value = items_county_0;            break;          case -1:            if (x == 1) {              document.getElementById('page_number_0').value = 1;            }            else {              document.getElementById('page_number_0').value = x - 1;            }            break;          case -2:            document.getElementById('page_number_0').value = 1;            break;          default:            document.getElementById('page_number_0').value = 1;        }        spider_frontend_ajax('gal_front_form_0', '0', 'bwg_standart_thumbnails_0', '0', '', 'album', 0);      }    </script>    
                                                <div class="tablenav-pages_0">            
                                                    <input type="hidden" id="page_number_0" name="page_number_0" value="1" />    
                                                </div>              
                                            </div>        
                                        </form>        
                                        <div id="spider_popup_loading_0" class="spider_popup_loading"></div>        
                                        <div id="spider_popup_overlay_0" class="spider_popup_overlay" onclick="spider_destroypopup(1000)"></div>      
                                    </div>    
                                </div>    
                            </div>
                        </div>
                    </div>

                    <div style="background-repeat:no-repeat;background-position:left top;" class="fullwidth-section">
                        <div class="fullwidth-bg">
                            <div class="container">
                              <div class="social-bookmark"></div>                          
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        </div><!-- content ends here -->

        <?php include('includes/footer.php'); ?> 
        </div>
    </div>
    <script type='text/javascript' src='plugins/designthemes-core-features/shortcodes/js/jquery.tipTip.minifiedf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='plugins/designthemes-core-features/shortcodes/js/jquery.tabs.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='plugins/designthemes-core-features/shortcodes/js/jquery.viewportf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='plugins/designthemes-core-features/shortcodes/js/shortcodesf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.stickyf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.smartresizef9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery-smoothscrollf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery-easing-1.3f9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.inviewf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.validate.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.carouFredSel-6.2.0-packedf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.isotope.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.prettyPhotof9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.ui.totop.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.meanmenuf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/contactf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.donutchartf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.fitvidsf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.bxsliderf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.parallax-1.1.3f9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.animateNumber.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/customf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='js/jquery/ui/jquery.ui.tabs.min2c18.js?ver=1.10.4'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/fancybox/jquery.fancybox-1.3.7.min00e2.js?ver=1.5.7'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/jquery.easing.pack4e44.js?ver=1.3'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/jquery.mousewheel.min4830.js?ver=3.1.12'></script>
    <script type="text/javascript"> jQuery(document).on('ready post-load', easy_fancybox_handler ); </script>
</body>
</html>