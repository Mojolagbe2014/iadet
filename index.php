<?php 
session_start();
define("CONST_FILE_PATH", "includes/constants.php");
include ('classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$websiteIndexObj = new WebsiteIndex($dbObj); // Create an object of WebsiteIndex class

$thisPage->title = StringManipulator::trimStringToFullWord(62, stripslashes(strip_tags(WebsiteIndex::getSingle($dbObj, 'title', 1))));
$thisPage->description = StringManipulator::trimStringToFullWord(150, stripslashes(strip_tags(WebsiteIndex::getSingle($dbObj, 'description', 1))));
$thisPage->keywords = WebsiteIndex::getSingle($dbObj, 'keywords', 1);
$thisPage->author = WEBSITE_AUTHOR;
?>
<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#"> <!--<![endif]-->
<head>
    <?php include ('includes/meta-tags.php'); ?>
    <?php include ('includes/analytics.php'); ?>
    <link rel="canonical" href="<?php echo SITE_URL; ?>" />
    <link rel='stylesheet' id='dt-sc-css-css'  href='plugins/designthemes-core-features/shortcodes/css/shortcodesf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='jeweltheme-jquery-ui-style-css'  href='plugins/wp-awesome-faq/jquery-uif9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='layerslider-css'  href='plugins/LayerSlider/static/css/layerslider3c21.css?ver=5.1.1' type='text/css' media='all' />
    <link rel='stylesheet' id='ls-google-fonts-css'  href='http://fonts.googleapis.com/css?family=Lato:100,300,regular,700,900|Open+Sans:300|Indie+Flower:regular|Oswald:300,regular,700&#038;subset=latin,latin-ext' type='text/css' media='all' />
    <link rel='stylesheet' id='bbp-default-css'  href='themes/Guru/css/bbpress98d8.css?ver=2.5.4-5380' type='text/css' media='screen' />
    <link rel='stylesheet' id='bp-parent-css-css'  href='themes/Guru/css/buddypressdc8c.css?ver=2.2' type='text/css' media='screen' />
    <link rel='stylesheet' id='contact-form-7-css'  href='plugins/contact-form-7/includes/css/styles2f54.css?ver=4.1' type='text/css' media='all' />
    <link rel='stylesheet' id='bwg_frontend-css'  href='plugins/photo-gallery/css/bwg_frontend2a18.css?ver=1.2.15' type='text/css' media='all' />
    <link rel='stylesheet' id='bwg_font-awesome-css'  href='plugins/photo-gallery/css/font-awesome/font-awesomeae82.css?ver=4.2.0' type='text/css' media='all' />
    <link rel='stylesheet' id='bwg_mCustomScrollbar-css'  href='plugins/photo-gallery/css/jquery.mCustomScrollbar2a18.css?ver=1.2.15' type='text/css' media='all' />
    <link rel='stylesheet' id='responsive_map_css-css'  href='plugins/responsive-maps-plugin/includes/css/rsmaps6f16.css?ver=2.22' type='text/css' media='all' />
    <link rel='stylesheet' id='rs-plugin-settings-css'  href='plugins/revslider/rs-plugin/css/settings17d1.css?rev=4.6.0&amp;ver=4.0' type='text/css' media='all' />
    <style type='text/css'>.tp-caption a{color:#ff7302;text-shadow:none;-webkit-transition:all 0.2s ease-out;-moz-transition:all 0.2s ease-out;-o-transition:all 0.2s ease-out;-ms-transition:all 0.2s ease-out}.tp-caption a:hover{color:#ffa902}</style>
    <link rel='stylesheet' id='woothemes-sensei-frontend-css'  href='plugins/woothemes-sensei/assets/css/frontend1f22.css?ver=1.6.2' type='text/css' media='screen' />
    <link rel='stylesheet' id='default-css'  href='themes/Guru/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='shortcode-css'  href='themes/Guru/css/shortcodef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='skin-css'  href='themes/Guru/skins/dark-blue/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='animations-css'  href='themes/Guru/css/animationsf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='menumenu-css'  href='themes/Guru/css/meanmenuf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='isotope-css'  href='themes/Guru/css/isotopef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='prettyphoto-css'  href='themes/Guru/css/prettyPhotof9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='style.fontawesome-css'  href='themes/Guru/css/font-awesome.minf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='stylewoo-css'  href='themes/Guru/framework/woocommerce/css/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='responsive-css'  href='themes/Guru/css/responsivef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='stylesensei-css'  href='themes/Guru/sensei/css/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='et_lb_modules-css'  href='plugins/elegantbuilder/style7793.css?ver=2.4' type='text/css' media='all' />
    <link rel='stylesheet' id='fancybox-css'  href='plugins/easy-fancybox/fancybox/jquery.fancybox-1.3.7.min00e2.css?ver=1.5.7' type='text/css' media='screen' />
    <link rel='stylesheet' id='mytheme-google-fonts-css'  href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Droid+Serif:400,400italic,700,700italic|Pacifico|Patrick+Hand|Crete+Round:400' type='text/css' media='all' />
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
    <link href="sweet-alert/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="sweet-alert/twitter.css" rel="stylesheet" type="text/css"/>
</head>
<body class="home-page home page page-id-39 page-template page-template-tpl-fullwidth-php custom-background tribe-theme-Guru no-js">
    <div class="main-content">
	<!-- wrapper div starts here -->
        <div id="wrapper">
            <?php include('includes/header.php'); ?>
            <div class="banner"> 
                <script type="text/javascript">var lsjQuery = jQuery;</script>
                <script type="text/javascript"> lsjQuery(document).ready(function() { if(typeof lsjQuery.fn.layerSlider == "undefined") { lsShowNotice('layerslider_2','jquery'); } else { lsjQuery("#layerslider_2").layerSlider({responsiveUnder: 960, layersContainer: 960, skinsPath: 'plugins/LayerSlider/static/skins/'}) } }); </script>
                <div class="ls-wp-fullwidth-container">
                    <div class="ls-wp-fullwidth-helper">
                        <div id="layerslider_2" class="ls-wp-container" style="width:100%;height:480px;margin:0 auto;margin-bottom: 0px;">
                            <div class="ls-slide" data-ls=" transition2d: all;">
                                <img src="plugins/LayerSlider/static/img/blank.gif" data-src="media/web-page/index/<?php echo WebsiteIndex::getSingle($dbObj, 'top_slider_background', 1) ?>" class="ls-bg" alt="Slide background" />
                                <img class="ls-l" style="top:72px;left:373px;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:100;delayin:1000;easingin:easeInQuad;offsetxout:0;offsetyout:-100;easingout:easeInQuad;" src="plugins/LayerSlider/static/img/blank.gif" data-src="media/web-page/index/<?php echo WebsiteIndex::getSingle($dbObj, 'top_slider_logo', 1) ?>" alt="">
                                <h1 class="ls-l" style="top:308px;left:113px;font-size:28px;color:rgba(255, 255, 255, 0.8);white-space: nowrap;" data-ls="offsetxin:0;offsetyin:100;delayin:1600;easingin:easeInQuad;offsetxout:0;offsetyout:-100;easingout:easeInQuad;"><?php echo WebsiteIndex::getSingle($dbObj, 'top_slider_h1', 1) ?></h1>
                                <h3 class="ls-l" style="top:385px;left:223px;color:rgba(255, 255, 255, 0.71);white-space: nowrap;" data-ls="offsetxin:0;offsetyin:100;delayin:2800;offsetxout:0;offsetyout:-100;"><?php echo WebsiteIndex::getSingle($dbObj, 'top_slider_h3', 1) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
            <!-- content starts here -->
            <div class="content">
                <section class="content-full-width" id="primary">
                    <article id="post-39" class="post-39 page type-page status-publish hentry"> 
                        <div class='fullwidth-section  dt-sc-parallax-section'  style="background-color:#f4f4f4;background-repeat:no-repeat;background-attachment:fixed; ">
                            <div class="fullwidth-bg">	
                                <div class="container">
                                    <div class='dt-sc-hr-invisible  '></div>
                                    <?php 
                                    $categoryObj = new CourseCategory($dbMoObj, MOODLE_DB_PREFIX);
                                    foreach($categoryObj->fetchRaw("*", " visible = 1 AND parent = 0 ", " RAND() LIMIT 4") as $featuredCategory){
                                        echo '<div  class="column dt-sc-one-half  first" style="text-align:justify; margin-right:10px;">'
                                            . '<h3>'.$featuredCategory['name'].'</h3>'
                                            . '<p style="text-align: justify;">'.StringManipulator::trimStringToFullWord(150, stripslashes(strip_tags($featuredCategory['description']))).'</p>'
                                            . '<a href="single-category-courses?id='.$featuredCategory['id'].'" class="dt-sc-button  medium  alignright "  style="background-color:#1e73be;border-color:#1e73be;color:#ffffff;">More Info</a>'
                                            . '</div>';
                                    }
                                    ?>
                                    <div class='dt-sc-hr-invisible  '></div>	
                                </div>
                            </div>
                        </div>
                        <div class='fullwidth-section  '  style="background-color:#355C7D;">
                            <div class="fullwidth-bg">	
                                <div class="container">
                                    <div class='dt-sc-hr-invisible  '></div>
                                    <div  class='column dt-sc-one-fourth  first'>
                                        <div class="dt-sc-animate-num">
                                            <div class="dt-sc-icon">
                                                <i class="fa fa-group"></i>
                                            </div>
                                            <span class="dt-sc-num-count" data-value="<?php echo User::getRawCount($dbMoObj, MOODLE_DB_PREFIX); ?>"><?php echo User::getRawCount($dbMoObj, MOODLE_DB_PREFIX); ?></span>
                                            <h3>Learners Educated</h3>
                                        </div>
                                    </div>
                                    <div  class='column dt-sc-one-fourth  '>
                                        <div class="dt-sc-animate-num">
                                            <div class="dt-sc-icon">
                                                <i class="fa fa-trophy"></i>
                                            </div>
                                            <span class="dt-sc-num-count" data-value="<?php echo Course::getRawCount($dbMoObj, MOODLE_DB_PREFIX); ?>"><?php echo Course::getRawCount($dbMoObj, MOODLE_DB_PREFIX); ?></span>
                                            <h3>Courses Listed</h3>
                                        </div>
                                    </div>
                                    <div  class='column dt-sc-one-fourth  '>
                                        <div class="dt-sc-animate-num">
                                            <div class="dt-sc-icon">
                                                <i class="fa fa-flag"></i>
                                            </div>
                                            <span class="dt-sc-num-count" data-value="5">5</span>
                                            <h3>Languages Available</h3>
                                        </div>
                                    </div>
                                    <div  class='column dt-sc-one-fourth  '>
                                        <div class="dt-sc-animate-num">
                                            <div class="dt-sc-icon"><i class="fa fa-book"></i></div>
                                            <span class="dt-sc-num-count" data-value="<?php echo Lesson::getRawCount($dbMoObj, MOODLE_DB_PREFIX); ?>"><?php echo Lesson::getRawCount($dbMoObj, MOODLE_DB_PREFIX); ?></span>
                                            <h3>Lessons Available</h3>
                                        </div>
                                    </div>
                                    <div class='dt-sc-hr-invisible  '></div>	
                                </div>
                            </div>
                        </div>
                        <div class='fullwidth-section  '  style="background-color:#fdfdfd;">
                            <div class="fullwidth-bg">	
                                <div class="container">
                                    <div class='dt-sc-hr-invisible-medium  '></div>
                                    <div class='hr-title'><h2>Our Featured Courses</h2><div class='title-sep'><span></span></div></div>
                                    <?php 
                                    $courseObj = new Course($dbMoObj, MOODLE_DB_PREFIX);
                                    $filesObj = new Files($dbMoObj, MOODLE_DB_PREFIX);
                                    foreach($courseObj->fetchRaw("*", " visible = 1 AND category > 0 ", " RAND() LIMIT 3") as $featuredCourse){
                                        $contextId = Context::getContextId($dbMoObj, MOODLE_DB_PREFIX, CONTEXT_COURSE, $featuredCourse['id']);
                                        echo '<div class="column dt-sc-one-third first" style="margin-right:10px"><!-- Course Starts -->'
                                            . '<article id="post-134" class="post-134 course type-course status-publish has-post-thumbnail hentry dt-sc-course post">'
                                            . '<div class="dt-sc-course-thumb">'
                                            . '<a href="course-detail?id='.$featuredCourse['id'].'" title="'.$featuredCourse['fullname'].'"><img width="400" height="267" src="'.MOODLE_URL.'pluginfile.php/'.$contextId.'/course/overviewfiles/'.Files::getCourseImage($dbMoObj, MOODLE_DB_PREFIX, $contextId).'" class="attachment-full wp-post-image" alt="'.$featuredCourse['fullname'].'" title="'.$featuredCourse['fullname'].'" /></a>'
                                            . '</div>'
                                            . '<div class="dt-sc-course-content">'
                                            . '<p class="dt-sc-course-meta"><a href="course-detail?id='.$featuredCourse['id'].'" rel="tag">'.$featuredCourse['shortname'].'</a></p>'
                                            . '<h2 class="dt-sc-course-title"><a href="course-detail?id='.$featuredCourse['id'].'" title="'.$featuredCourse['fullname'].'">'.$featuredCourse['fullname'].'</a></h2>'
                                            . '<a href="course-detail?id='.$featuredCourse['id'].'" class="dt-sc-course-price">&pound;'.Course::getSingle($dbObj, '', 'amount', " name = '".$featuredCourse['fullname']."'").'</a>'
                                            . '<span class="dt-sc-lessons">'.Lesson::getSingleCourseCount($dbMoObj, $featuredCourse['id'], MOODLE_DB_PREFIX).'&nbsp;Lesson(s)</span>'
                                            . '</div></article>'
                                            . '</div><!-- Course Ends -->';
                                        
                                    }
                                    ?>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>	
                                </div>
                            </div>
                        </div>
                        <div class='fullwidth-section  dt-sc-parallax-section'  style="background-color:#ffffff;background-repeat:no-repeat;background-attachment:fixed; ">
                            <div class="fullwidth-bg">	
                                <div class="container">
                                    <script type="text/javascript">var lsjQuery = jQuery;</script>
                                    <script type="text/javascript"> lsjQuery(document).ready(function() { if(typeof lsjQuery.fn.layerSlider == "undefined") { lsShowNotice('layerslider_3','jquery'); } else { lsjQuery("#layerslider_3").layerSlider({responsiveUnder: 960, layersContainer: 960, skin: 'noskin', skinsPath: 'plugins/LayerSlider/static/skins/'}) } }); </script>
                                    <div class="ls-wp-fullwidth-container">
                                        <div class="ls-wp-fullwidth-helper">
                                            <div id="layerslider_3" class="ls-wp-container" style="width:100%;height:486px;margin:0 auto;margin-bottom: 0px;">
                                                <div class="ls-slide" data-ls=" transition2d: all;">
                                                    <img src="plugins/LayerSlider/static/img/blank.gif" data-src="media/web-page/index/<?php echo WebsiteIndex::getSingle($dbObj, 'bottom_slider_background', 1) ?>" class="ls-bg" alt="Slide background" />
                                                    <h1 class="ls-l" style="top:104px;left:106px;font-size:30px;color:rgba(0, 0, 0, 0.8);white-space: nowrap;" data-ls="delayin:400;"><?php echo WebsiteIndex::getSingle($dbObj, 'bottom_slider_h1', 1) ?></h1>
                                                    <h2 class="ls-l" style="top:161px;left:127px;color:rgba(0, 0, 0, 0.64);white-space: nowrap;" data-ls="delayin:800;"><?php echo WebsiteIndex::getSingle($dbObj, 'bottom_slider_h2', 1) ?></h2>
                                                    <img class="ls-l" style="top:115px;left:464px;white-space: nowrap;" src="plugins/LayerSlider/static/img/blank.gif" data-src="images/ipad1.png" alt="">
                                                    <div class="ls-l" style="top:132px;left:499px;white-space: nowrap;">
                                                        <video width="370" height="270" preload="metadata" controls><source src="media/web-page/index/<?php echo WebsiteIndex::getSingle($dbObj, 'bottom_slider_video', 1) ?>" type="video/mp4"></video> 
                                                    </div>
                                                    <p class="ls-l" style="top:372px;left:104px;border:1px solid #C5B7CC; color: #755187 !important; -webkit-box-shadow:rgba(0, 0, 0, 0.199219) 0 1px 1px; border-bottom-left-radius:2px; border-bottom-right-radius:2px; border-top-left-radius:2px; border-top-right-radius:2px; box-shadow:rgba(0, 0, 0, 0.199219) 0 1px 1px; font-family:PTSansBold, arial, helvetica, sans-serif; font-size:23px; font-variant:normal; font-weight:bold; height:43px; line-height:43px; padding:0 30px; text-align:center; text-shadow:#FFFFFF 0 1px 0; ;border-radius:10px;white-space: nowrap;" data-ls="delayin:1600;">
                                                        <a class="button_default_blue_large" href="register">Join Now</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                        </div>
                        <div class='fullwidth-section  '  style="background-color:#fafafa;background-repeat:no-repeat;background-position:left top;">
                            <div class="fullwidth-bg">	
                                <div class="container"><div class='dt-sc-hr-invisible-medium  '></div>
                                    <div class='hr-title'><h4>OUR SPONSORS/PARTNERS</h4><div class='title-sep'><span></span></div></div>
                                    <div class='intro-text type1 ' style="text-align:left;">
                                        <?php
                                        $sponsorObj = new Sponsor($dbObj);
                                        foreach($sponsorObj->fetchRaw("*", " status = 1 ") as $sponsor){
                                            echo '<a href="sponsor?id='.$sponsor['id'].'" class="small" style="margin:10px" title="'.$sponsor['name'].'"><img src="media/sponsor/'.$sponsor['logo'].'" style="width:120px;height:100px;"></a>';
                                        } 
                                        ?>
                                    </div>
                                    <div class='dt-sc-hr-invisible-medium  '></div>	
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
            </div>
            <!-- content ends here -->
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
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.fitvidsf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.bxsliderf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.parallax-1.1.3f9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.animateNumber.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/customf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='js/jquery/ui/jquery.ui.tabs.min2c18.js?ver=1.10.4'></script>
</body>
</html>