<?php 
session_start();
define("CONST_FILE_PATH", "includes/constants.php");
include ('classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$websiteServicesObj = new WebsiteServices($dbObj); // Create an object of WebsiteServices class

$thisPage->title = StringManipulator::trimStringToFullWord(62, stripslashes(strip_tags(WebsiteServices::getSingle($dbObj, 'title', 1))));
$thisPage->description = StringManipulator::trimStringToFullWord(150, stripslashes(strip_tags(WebsiteServices::getSingle($dbObj, 'description', 1))));
$thisPage->keywords = WebsiteServices::getSingle($dbObj, 'keywords', 1);
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
    
<body class="page page-id-377 page-template page-template-tpl-fullwidth-php custom-background tribe-theme-Guru no-js">
    <div class="main-content">
	<!-- wrapper div starts here -->
        <div id="wrapper">
            <?php include('includes/header.php'); ?>
            <!-- breadcrumb starts here -->
            <section class="breadcrumb-wrapper">
                <div class="container">
                    <h1>Our Services</h1>
                    <div class="breadcrumb"><a href="index">Home</a><span class="default" >  </span>
                        <h4>Our Services</h4>
                    </div>				  
                </div>                      
            </section>
            <!-- breadcrumb ends here -->      
            <!-- content starts here -->
            <div class="content">
            <section class="content-full-width" id="primary">
                <article id="post-377" class="post-377 page type-page status-publish hentry"><div class='fullwidth-section  '  style="background-color:#f0f0f0;background-repeat:no-repeat;"><div class="fullwidth-bg">	<div class="container"><div class='dt-sc-hr-invisible  '></div>
                        <div  class='column dt-sc-one-half  first'><div class='hr-title'><h2><?php echo WebsiteServices::getSingle($dbObj, 'content_header', 1); ?></h2><div class='title-sep'><span></span></div></div>
                        <p style="color: 0f0f0f; font-size: 18px;"><?php echo WebsiteServices::getSingle($dbObj, 'content', 1); ?></p></div>
                                <div  class='column dt-sc-one-half  '><a href="media/web-page/services/<?php echo WebsiteServices::getSingle($dbObj, 'content_image', 1); ?>"><img class="alignnone wp-image-378 size-medium" src="media/web-page/services/<?php echo WebsiteServices::getSingle($dbObj, 'content_image', 1); ?>" alt="<?php echo WebsiteServices::getSingle($dbObj, 'content_header', 1); ?>" width="300" height="300" /></a></div>
                        <div class='dt-sc-hr-invisible  '></div>	
                            </div></div></div>
                        <div class='fullwidth-section  '  style="background-repeat:no-repeat;background-position:left top;">
                            <div class="fullwidth-bg">	
                                <div class="container"><div class='dt-sc-hr-invisible-medium  '></div>
                                    <div class='dt-sc-tabs-container'>
                                        <ul class="dt-sc-tabs-frame">
                                            <li><a href="#"><?php echo WebsiteServices::getSingle($dbObj, 'first_tab_header', 1); ?></a></li>
                                            <li><a href="#"><?php echo WebsiteServices::getSingle($dbObj, 'second_tab_header', 1); ?></a></li>
                                            <li><a href="#"><?php echo WebsiteServices::getSingle($dbObj, 'third_tab_header', 1); ?></a></li>
                                        </ul>
                                        <div class="dt-sc-tabs-frame-content">
                                            <?php echo WebsiteServices::getSingle($dbObj, 'first_tab_content', 1); ?>
                                        </div>
                                        <div class="dt-sc-tabs-frame-content">
                                            <?php echo WebsiteServices::getSingle($dbObj, 'second_tab_content', 1); ?>
                                        </div>
                                        <div class="dt-sc-tabs-frame-content">
                                            <?php echo WebsiteServices::getSingle($dbObj, 'third_tab_content', 1); ?>
                                        </div>
                                    </div>
                                    <div class='dt-sc-hr-invisible  '></div>	
                                </div>
                            </div>
                        </div>
                        <div class='fullwidth-section  '  style="background-color:#fafafa;background-repeat:no-repeat;background-position:left top;"><div class="fullwidth-bg">	<div class="container"><div class='dt-sc-hr-invisible-medium  '></div>
                        <div class='intro-text type1 '>
                        If you are looking for an answer to a specific question here is a quick and easy way to get help.
                        You&#8217;ll get what you came for!</p>
                        <a href='contact'  class='dt-sc-button  small  ' >Contact Us</a>
                        </div>
                        <div class='dt-sc-hr-invisible-medium  '></div>	</div></div></div>

                      <div style="background-repeat:no-repeat;background-position:left top;" class="fullwidth-section">
                          <div class="fullwidth-bg">
                              <div class="container">
                                <div class="social-bookmark"></div>                          </div>
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
    <script type='text/javascript' src='plugins/bbpress/templates/default/js/editor98d8.js?ver=2.5.4-5380'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.stickyf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.smartresizef9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery-smoothscrollf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery-easing-1.3f9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.inviewf9b8.js?ver=4.0'></script>
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
    <script type='text/javascript' src='themes/Guru/framework/js/public/customf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='js/jquery/ui/jquery.ui.tabs.min2c18.js?ver=1.10.4'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/fancybox/jquery.fancybox-1.3.7.min00e2.js?ver=1.5.7'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/jquery.easing.pack4e44.js?ver=1.3'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/jquery.mousewheel.min4830.js?ver=3.1.12'></script>
    <script type="text/javascript"> jQuery(document).on('ready post-load', easy_fancybox_handler ); </script>
</body>
</html>