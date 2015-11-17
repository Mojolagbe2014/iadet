<?php 
session_start();
define("CONST_FILE_PATH", "includes/constants.php");
include ('classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$websiteWhatWeDoObj = new WebsiteWhatWeDo($dbObj); // Create an object of WebsiteWhatWeDo class

$thisPage->title = StringManipulator::trimStringToFullWord(62, stripslashes(strip_tags(WebsiteWhatWeDo::getSingle($dbObj, 'title', 1))));
$thisPage->description = StringManipulator::trimStringToFullWord(150, stripslashes(strip_tags(WebsiteWhatWeDo::getSingle($dbObj, 'description', 1))));
$thisPage->keywords = WebsiteWhatWeDo::getSingle($dbObj, 'keywords', 1);
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
    <script type='text/javascript' src='plugins/LayerSlider/static/js/layerslider.kreaturamedia.jquery3c21.js?ver=5.1.1'></script>
    <script type='text/javascript' src='plugins/LayerSlider/static/js/greensock4a80.js?ver=1.11.2'></script>
    <script type='text/javascript' src='plugins/LayerSlider/static/js/layerslider.transitions3c21.js?ver=5.1.1'></script>
    <script type='text/javascript' src='plugins/revslider/rs-plugin/js/jquery.themepunch.tools.min17d1.js?rev=4.6.0&amp;ver=4.0'></script>
    <script type='text/javascript' src='plugins/revslider/rs-plugin/js/jquery.themepunch.revolution.min17d1.js?rev=4.6.0&amp;ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/modernizr-2.6.2.minf9b8.js?ver=4.0'></script>
    <link href="sweet-alert/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="sweet-alert/twitter.css" rel="stylesheet" type="text/css"/>
</head>
    
<body class="page page-id-242 page-template page-template-tpl-fullwidth-php custom-background tribe-theme-Guru no-js">
    <div class="main-content">
	<!-- wrapper div starts here -->
        <div id="wrapper">
            <?php include ('includes/header.php'); ?>
            <div class="banner"> 
                <script type="text/javascript">var lsjQuery = jQuery;</script>
                <script type="text/javascript"> lsjQuery(document).ready(function() { if(typeof lsjQuery.fn.layerSlider == "undefined") { lsShowNotice('layerslider_4','jquery'); } else { lsjQuery("#layerslider_4").layerSlider({responsiveUnder: 960, layersContainer: 960, skinsPath: 'plugins/LayerSlider/static/skins/'}) } }); </script>
                <div class="ls-wp-fullwidth-container">
                    <div class="ls-wp-fullwidth-helper">
                        <div id="layerslider_4" class="ls-wp-container" style="width:100%;height:600px;margin:0 auto;margin-bottom: 0px;">
                            <div class="ls-slide" data-ls=" transition2d: all;">
                                <img src="plugins/LayerSlider/static/img/blank.gif" data-src="media/web-page/what-we-do/<?php echo WebsiteWhatWeDo::getSingle($dbObj, 'top_slider_background', 1); ?>" class="ls-bg" alt="Slide background" />
                                <h1 class="ls-l" style="top:85px;left:357px;font-size:50px;color:#ffffff;white-space: nowrap;"><?php echo WebsiteWhatWeDo::getSingle($dbObj, 'top_slider_header', 1); ?></h1>
                                <img class="ls-l" style="top:189px;left:50px;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:100;delayin:1000;easingin:easeInQuad;" src="plugins/LayerSlider/static/img/blank.gif" data-src="uploads/2014/10/cash-meri-designview_new.png" alt="">
                                <h3 class="ls-l" style="top:208px;left:507px;font-size:20px;color:rgba(255, 255, 255, 0.81);white-space: nowrap;" data-ls="delayin:1600;"><li><?php echo WebsiteWhatWeDo::getSingle($dbObj, 'top_slider_first_text', 1); ?></li> </h3>
                                <h3 class="ls-l" style="top:262px;left:508px;font-size:20px;color:rgba(255, 255, 255, 0.81);white-space: nowrap;" data-ls="delayin:2400;"><li><?php echo WebsiteWhatWeDo::getSingle($dbObj, 'top_slider_second_text', 1); ?></li> </h3>
                                <h3 class="ls-l" style="top:315px;left:507px;font-size:20px;color:rgba(255, 255, 255, 0.81);white-space: nowrap;" data-ls="delayin:3200;"><li><?php echo WebsiteWhatWeDo::getSingle($dbObj, 'top_slider_third_text', 1); ?></li> </h3>
                                <h3 class="ls-l" style="top:373px;left:506px;font-size:20px;color:rgba(255, 255, 255, 0.81);white-space: nowrap;" data-ls="delayin:4000;"> <li><?php echo WebsiteWhatWeDo::getSingle($dbObj, 'top_slider_fourth_text', 1); ?></li>  </h3>
                                <p class="ls-l" style="top:458px;left:688px; color: #ffffff; padding: 18px 30px 18px 30px; background: #355c7d; border-radius: 5px; cursor: pointer; font-size: 25.8532px; font-weight: 600; line-height: 17.4436px; text-transform: uppercase; white-space: nowrap; filter: none; width: auto; height: auto; border-width: 0px; margin-left: 0px; margin-top: 0px; transform-origin: 50% top 0px; transform: translate3d(0px, 0px, 0px); opacity: 1; visibility: visible;color:#ffffff;white-space: nowrap;" data-ls="delayin:5000;"><a href="register">Join Now</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
            <!-- content starts here -->
            <div class="content">
                <section class="content-full-width" id="primary">
                    <article id="post-242" class="post-242 page type-page status-publish hentry"><div class='fullwidth-section  '  style="background-repeat:no-repeat;background-position:left top;"><div class="fullwidth-bg">	<div class="container"><div class='dt-sc-hr-invisible-medium  '></div>
                        <div class='dt-sc-tabs-container'><ul class="dt-sc-tabs-frame"><li><a href="#"><?php echo WebsiteWhatWeDo::getSingle($dbObj, 'content_header', 1); ?></a></li></ul><div class="dt-sc-tabs-frame-content"><p><?php echo WebsiteWhatWeDo::getSingle($dbObj, 'content', 1); ?></p></div></div>
                        <div class='dt-sc-hr-invisible  '></div>	</div></div></div>
                        <div class='fullwidth-section  '  style="background-color:#fafafa;background-repeat:no-repeat;background-position:left top;"><div class="fullwidth-bg">	<div class="container"><div class='dt-sc-hr-invisible-medium  '></div>
                        <div class='intro-text type1 '>
                        <h4>If you are looking for an answer to a specific question here is a quick and easy way to get help.</h4>
                        <h5>You&#8217;ll get what you came for!</h5>
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
            <?php include ('includes/footer.php'); ?>
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
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.carouFredSel-6.2.0-packedf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.isotope.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.ui.totop.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.meanmenuf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.fitvidsf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.bxsliderf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.parallax-1.1.3f9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/customf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='js/jquery/ui/jquery.ui.tabs.min2c18.js?ver=1.10.4'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/fancybox/jquery.fancybox-1.3.7.min00e2.js?ver=1.5.7'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/jquery.easing.pack4e44.js?ver=1.3'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/jquery.mousewheel.min4830.js?ver=3.1.12'></script>
</body>
</html>