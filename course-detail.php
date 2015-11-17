<?php 
session_start();
define("CONST_FILE_PATH", "includes/constants.php");
include ('classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$courseObj = new Course($dbMoObj, MOODLE_DB_PREFIX);
//get the category id; if failed redirect to course-categories page
$thisCourseId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : $thisPage->redirectTo('courses-overview');

foreach ($courseObj->fetchRaw("*", " visible = 1 AND category > 0 AND id = $thisCourseId ") as $course) {
    $courseData = array('id' => 'id', 'name' => 'fullname', 'image' => 'image', 'shortName' => 'shortname', 'category' => 'category', 'startDate' => 'startdate', 'description' => 'summary', 'status' => 'visible');
    
    foreach ($courseData as $key => $value){
        switch ($key) { 
            case 'image': $contextId = Context::getContextId($dbMoObj, MOODLE_DB_PREFIX, CONTEXT_COURSE, $thisCourseId);
                          $courseObj->$key = MOODLE_URL.'pluginfile.php/'.$contextId.'/course/overviewfiles/'.Files::getCourseImage($dbMoObj, MOODLE_DB_PREFIX, $contextId);break;
            
            default     :   $courseObj->$key = $course[$value]; break; 
        }
    }
    
}
$courseObj->status = Course::getSingle($dbObj, '', 'status', " name = '".$courseObj->name."'"); 
$courseObj->promotionAmount = Course::getSingle($dbObj, '', 'promotion_amount', " name = '".$courseObj->name."'");
$courseObj->amount = Course::getSingle($dbObj, '', 'amount', " name = '".$courseObj->name."'");

$thisPage->title = StringManipulator::trimStringToFullWord(62, stripslashes(strip_tags($courseObj->name." Course - International Academy of Dental Education and Training (IADET)")));
$thisPage->description = StringManipulator::trimStringToFullWord(150, stripslashes(strip_tags("The details including cost of ".$courseObj->name." course")));
$thisPage->keywords = "online, ecourses, dental, courses, development";
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
    <?php include ('includes/analytics.php'); ?><link rel='stylesheet' id='dt-sc-css-css'  href='plugins/designthemes-core-features/shortcodes/css/shortcodesf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='dt-sc-css-css'  href='plugins/designthemes-core-features/shortcodes/css/shortcodesf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='jeweltheme-jquery-ui-style-css'  href='plugins/wp-awesome-faq/jquery-uif9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='layerslider-css'  href='plugins/LayerSlider/static/css/layerslider3c21.css?ver=5.1.1' type='text/css' media='all' />
    <link rel='stylesheet' id='ls-google-fonts-css'  href='http://fonts.googleapis.com/css?family=Lato:100,300,regular,700,900|Open+Sans:300|Indie+Flower:regular|Oswald:300,regular,700&amp;subset=latin,latin-ext' type='text/css' media='all' />
    <link rel='stylesheet' id='bbp-default-css'  href='themes/Guru/css/bbpress98d8.css?ver=2.5.4-5380' type='text/css' media='screen' />
    <link rel='stylesheet' id='responsive_map_css-css'  href='plugins/responsive-maps-plugin/includes/css/rsmaps6f16.css?ver=2.22' type='text/css' media='all' />
    <link rel='stylesheet' id='rs-plugin-settings-css'  href='plugins/revslider/rs-plugin/css/settings17d1.css?rev=4.6.0&amp;ver=4.0' type='text/css' media='all' />
    <style type='text/css'> .tp-caption a{color:#ff7302;text-shadow:none;-webkit-transition:all 0.2s ease-out;-moz-transition:all 0.2s ease-out;-o-transition:all 0.2s ease-out;-ms-transition:all 0.2s ease-out}.tp-caption a:hover{color:#ffa902}</style>
    <link rel='stylesheet' id='wpmenucart-icons-css'  href='plugins/woocommerce-menu-bar-cart/css/wpmenucart-iconsf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='wpmenucart-css'  href='plugins/woocommerce-menu-bar-cart/css/wpmenucart-mainf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='woocommerce_prettyPhoto_css-css'  href='plugins/woocommerce/assets/css/prettyPhotof9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='woothemes-sensei-frontend-css'  href='plugins/woothemes-sensei/assets/css/frontend1f22.css?ver=1.6.2' type='text/css' media='screen' />
    <link rel='stylesheet' id='default-css'  href='themes/Guru/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='shortcode-css'  href='themes/Guru/css/shortcodef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='skin-css'  href='themes/Guru/skins/dark-blue/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='animations-css'  href='themes/Guru/css/animationsf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='menumenu-css'  href='themes/Guru/css/meanmenuf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='isotope-css'  href='themes/Guru/css/isotopef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='style.fontawesome-css'  href='themes/Guru/css/font-awesome.minf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='stylewoo-css'  href='themes/Guru/framework/woocommerce/css/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='responsive-css'  href='themes/Guru/css/responsivef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='stylesensei-css'  href='themes/Guru/sensei/css/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='et_lb_modules-css'  href='plugins/elegantbuilder/style7793.css?ver=2.4' type='text/css' media='all' />
    <link rel='stylesheet' id='yith-magnifier-css'  href='plugins/yith-woocommerce-zoom-magnifier/assets/css/yith_magnifierf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='yith_wcmg_frontend-css'  href='plugins/yith-woocommerce-zoom-magnifier/assets/css/frontendf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='fancybox-css'  href='plugins/easy-fancybox/fancybox/jquery.fancybox-1.3.7.min00e2.css?ver=1.5.7' type='text/css' media='screen' />
    <link rel='stylesheet' id='mytheme-google-fonts-css'  href='http://fonts.googleapis.com/fonts.googleapis.com/cssb7b0.css?family=Open+Sans:300,400,600,700|Droid+Serif:400,400italic,700,700italic|Pacifico|Patrick+Hand|Crete+Round:400' type='text/css' media='all' />
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
    <link href="sweet-alert/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="sweet-alert/twitter.css" rel="stylesheet" type="text/css"/>
</head>
    
<body class="single single-product postid-283 custom-background woocommerce woocommerce-page tribe-theme-Guru page-template-single-php no-js">
    <div class="main-content">
	<!-- wrapper div starts here -->
        <div id="wrapper">
            <?php include('includes/header.php'); ?>
            <!-- breadcrumb starts here -->
            <section class="breadcrumb-wrapper">
                <div class="container">
                    <h1><?php echo StringManipulator::trimStringToFullWord(35, stripslashes(strip_tags($courseObj->shortName))); ?></h1>
                    <div class="breadcrumb">
                        <a href="index">Home</a><span class="default" >  </span>
                        <a href="course-categories" rel="tag">Course Category</a><span class="default" >  </span>
                        <h4><?php echo StringManipulator::trimStringToFullWord(15, stripslashes(strip_tags($courseObj->shortName))); ?></h4>
                    </div>                    
                </div>                      
            </section>
            <!-- breadcrumb ends here -->
            <div class="content">
                <div class="container">
                    <section class="content-full-width" id="primary">
                        <div itemscope itemtype="http://schema.org/Product" id="product-283" class="post-283 product type-product status-publish has-post-thumbnail post pif-has-gallery shipping-taxable purchasable product-type-simple product-cat-dental instock">
                            <div class="product-thumb-wrapper">    
                                <div class="images">
                                    <a href="<?php echo $courseObj->image; ?>" itemprop="image" class="yith_magnifier_zoom woocommerce-main-image" title="<?php echo $courseObj->name; ?>">
                                        <img width="400" height="267" src="<?php echo $courseObj->image; ?>" class="attachment-shop_single wp-post-image" alt="<?php echo $courseObj->name; ?>" />
                                    </a>
                                </div>
                                <script type="text/javascript" charset="utf-8"> var yith_magnifier_options = { enableSlider: true, sliderOptions: { responsive: true, circular: true, infinite: true, direction: 'left', debug: false, auto: false, align: 'left', prev	: { button	: "#slider-prev", key		: "left" }, next	: { button	: "#slider-next", key		: "right" }, scroll : { items     : 1, pauseOnHover: true }, items   : { visible: 3            } }, showTitle: false, zoomWidth: 'auto', zoomHeight: 'auto', position: 'right', lensOpacity: 0.5, softFocus: false, adjustY: 0, disableRightClick: false, phoneBehavior: 'default', loadingLabel: 'Loading...'}; </script>
                                <div class="summary entry-summary">
                                    <h1 itemprop="name" class="product_title entry-title"><?php echo $courseObj->name; ?></h1>
                                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                        <p class="price">Amount: <span class="amount" <?php if($courseObj->status == 1) echo 'style="text-decoration: line-through"'; ?>>&pound;<?php echo $courseObj->amount; ?></span></p>
                                        <?php if($courseObj->status == 1) { ?>
                                        <p class="price">Promotional Amount: <span class="amount">&pound;<?php echo $courseObj->promotionAmount; ?></span></p>
                                        <?php } ?>
                                        <meta itemprop="price" content="<?php echo $courseObj->amount; ?>" />
                                        <meta itemprop="priceCurrency" content="GBP" />
                                        <link itemprop="availability" href="#" />
                                    </div>
                                    <form class="cart" method="POST" name="cartItemForm" id="cartItemForm" enctype='multipart/form-data'>
                                        <input type="hidden" name="course" id="course" value="<?php echo $courseObj->id; ?>" />
                                        <input type="hidden" name="addNewCartItem" id="addNewCartItem" value="addNewCartItem" />
                                        <button style="margin-bottom:5px" type="submit" data-course-id="<?php echo $courseObj->id; ?>" name="add-to-cart" id="add-to-cart" class="single_add_to_cart_button button alt"> <i class="fa fa-shopping-cart"></i> Add to cart</button>
                                        <button style="margin-left:5px" type="submit" name="purchase-now" id="purchase-now" data-course-id="<?php echo $courseObj->id; ?>" class="single_add_to_cart_button button alt" > <i class="fa fa-money"></i> Purchase</button>
                                    </form>
                                    <div class="product_meta">
                                        <span class="sku_wrapper">Course Code: <span class="sku" itemprop="sku"><strong><?php echo $courseObj->shortName; ?></strong></span>.</span><br/>
                                        <span class="posted_in">Number of Lesson(s): <strong><?php echo Lesson::getSingleCourseCount($dbMoObj, $courseObj->id, MOODLE_DB_PREFIX); ?></strong></span><br/>
                                        <span class="posted_in">Category: <strong><a href="single-category-courses?id=<?php echo $courseObj->category; ?>" rel="tag"><?php echo CourseCategory::getSingle($dbMoObj, MOODLE_DB_PREFIX, 'name', " id = $courseObj->category"); ?></a></strong></span>
                                    </div>
                                </div><!-- .summary -->
                                <div class="woocommerce-tabs">
                                    <ul class="tabs">
                                        <li class="description_tab">
                                            <a href="#tab-description">Description</a>
                                        </li>
                                        <li class="lessons_tab">
                                            <a href="#tab-lessons">Lessons</a>
                                        </li>
                                        <li class="reviews_tab">
                                            <a href="#tab-reviews">Reviews (<?php echo CourseReview::getRawCount($dbObj, $courseObj->id); ?>)</a>
                                        </li>
                                    </ul>
                                    <div class="panel entry-content" id="tab-description" style="text-align:justify;">
                                        <h2>Course Description</h2>
                                        <p><?php echo $courseObj->description; ?>&nbsp;</p>
                                        <p>&nbsp;</p>
                                    </div>
                                    <div class="panel entry-content" id="tab-lessons">
                                        <section class="course-lessons">
                                            <header><h2>Lessons</h2></header>
                                            <?php 
                                            $lessonObj = new Lesson($dbMoObj, MOODLE_DB_PREFIX); $counter = 1;
                                            foreach ($lessonObj->fetchRaw("*", " course = $courseObj->id ") as $lesson) {
                                            ?>
                                            <article class="post-129 lesson type-lesson status-publish has-post-thumbnail hentry course post">
                                                <header>
                                                    <h2><a href="<?php echo MOODLE_URL; ?>" title="<?php echo $lesson['name']; ?>"><?php echo $counter.". ".$lesson['name']; ?></a></h2>
                                                    <p class="lesson-meta"></p>
                                                </header>
                                                <section class="entry"></section>
                                            </article>
                                            <?php $counter++; } if(Lesson::getSingleCourseCount($dbMoObj, $courseObj->id, MOODLE_DB_PREFIX) ==0) { echo "<em>There are currently no lessons for this course. Please check later</em>";} ?>
                                        </section>
                                    </div>
                                    <div class="panel entry-content" id="tab-reviews">
                                        <div id="reviews">
                                            <h2>Reviews</h2>
                                            <div id="comments">
                                                <?php
                                                $courseReviewObj = new CourseReview($dbObj); $reviewCounter =1;
                                                foreach ($courseReviewObj->fetchRaw("*", " status = 1 AND course = $courseObj->id ") as $courseReview) {
                                                    $dateParam = explode('-', $courseReview['date_added']);
                                                    $dateObj   = DateTime::createFromFormat('!m', $dateParam[1]);
                                                ?>
                                                <article id="post-537" class="post-537 faq type-faq status-publish hentry blog-post">
                                                    <div class="post-details">                
                                                        <div class="date"><p><span><?php echo $dateParam[2]; ?></span><br /><?php echo $dateObj->format('F'); ?></p></div>                                  
                                                        <div class="post-comments">
                                                            <span><i class="fa fa-calendar"></i> <?php echo $dateParam[0]; ?></span>                                  
                                                        </div>                          
                                                    </div>
                                                    <div class="post-content">
                                                        <div class="entry-detail">
                                                            <p><?php echo $reviewCounter.". ".$courseReview['review']; ?></p>
                                                            <h2><a href="mailto:<?php echo $courseReview['email']; ?>"><?php echo $courseReview['name']; ?></a></h2>
                                                            <div class="social-bookmark"></div>                              
                                                        </div>
                                                        <div class="post-meta">
                                                            <div class="post-format"><span class="post-icon-format">  </span></div>                                  
                                                        </div>
                                                    </div>
                                                </article>
                                                
                                                <?php $reviewCounter++; } if(CourseReview::getRawCount($dbObj, $courseObj->id)==0) { ?><p class="woocommerce-noreviews">There are no reviews yet.</p> <?php } ?>
                                            </div>
                                            <div id="review_form_wrapper">
                                                <div id="review_form">
                                                    <div id="respond" class="comment-respond">
                                                        <h3 id="reply-title" class="comment-reply-title">Review &ldquo;<?php echo $courseObj->name; ?>&rdquo; <small><a rel="nofollow" id="cancel-comment-reply-link" href="index.html#respond" style="display:none;">Cancel reply</a></small></h3>
                                                        <form action="REST/add-course-review.php" method="post" id="commentform" class="comment-form">
                                                            <p class="comment-form-author">
                                                                <label for="author">Name <span class="required">*</span></label> 
                                                                <input name="name" id="name" type="text" value="" size="30" aria-required="true" />
                                                            </p>
                                                            <p class="comment-form-email"><label for="email">Email <span class="required">*</span></label> 
                                                                <input name="email" id="email" type="text" value="" size="30" aria-required="true" />
                                                            </p>
                                                            <p class="comment-form-comment"><label for="review">Your Review</label><textarea name="review" id="review" cols="45" rows="8" aria-required="true"></textarea></p>												
                                                            <p class="form-submit">
                                                                <input name="submit" type="submit" id="submit" value="Submit" />
                                                                <input type='hidden' name='addNewCourseReview' id="addNewCourseReview" value='addNewCourseReview' />
                                                                <input type='hidden' name='course' id='course' value='<?php echo $courseObj->id; ?>' />
                                                            </p>
                                                        </form>
                                                    </div><!-- #respond -->
						</div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>			
                                    </div>
                                </div>
                            </div>
                            <div class='related-products-container'>
                                <div class="related products">
                                    <div class="hr-title">
                                        <h2>Related Course</h2>
                                        <div class="title-sep"><span></span></div>
                                    </div>
                                    <ul class="products">
                                        <li class="post-308 product type-product status-publish has-post-thumbnail first post pif-has-gallery shipping-taxable purchasable product-type-simple product-cat-dental instock">
                                            <div class=' dt-sc-one-fourth column  in-stock-product '>
                                                <?php 
                                                $relatedCourseObj = new Course($dbMoObj, MOODLE_DB_PREFIX);
                                                foreach ($relatedCourseObj->fetchRaw("*", " category = $courseObj->category AND id != $courseObj->id ", " RAND() LIMIT 1 ") as $relatedCourse) {
                                                    $contextId = Context::getContextId($dbMoObj, MOODLE_DB_PREFIX, CONTEXT_COURSE, $relatedCourse['id']);
                                                    $relatedCourseObj->image = MOODLE_URL.'pluginfile.php/'.$contextId.'/course/overviewfiles/'.Files::getCourseImage($dbMoObj, MOODLE_DB_PREFIX, $contextId);
                                                ?>
                                                <div class='product-wrapper'>
                                                    <a href="course-detail?id=<?php echo $relatedCourse['id']; ?>">
                                                        <div class='product-thumb'>
                                                            <img width="400" height="267" src="<?php echo $relatedCourseObj->image; ?>" class="attachment-shop_catalog wp-post-image" alt="<?php echo $relatedCourse['fullname']; ?>" />
                                                            <img width="874" height="656" src="<?php echo $relatedCourseObj->image; ?>" class="secondary-image attachment-shop-catalog" alt="<?php echo $relatedCourse['fullname']; ?>" />
                                                            <a href="course-detail?id=<?php echo $relatedCourse['id']; ?>" data-product_id="308" data-product_sku="" data-quantity="1" class="small button add_to_cart_button product_type_simple">View Details</a>
                                                        </div>
                                                        <div class='product-title'>
                                                            <a href="course-detail?id=<?php echo $relatedCourse['id']; ?>">
                                                                <h3><?php echo $relatedCourse['fullname']."(".$relatedCourse['shortname'].")"; ?></h3>
                                                            </a>
                                                        </div>
                                                    </a>
                                                    <div class='product-details'>
                                                        <span class="price"><span class="amount">&pound;<?php echo Course::getSingle($dbObj, '', 'amount', " name = '".$relatedCourse['fullname']."'"); ?></span></span>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- #product-283 -->
                    </section>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
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
    <script type='text/javascript' src='plugins/designthemes-core-features/shortcodes/js/jquery.tipTip.minifiedf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='plugins/designthemes-core-features/shortcodes/js/jquery.tabs.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='plugins/designthemes-core-features/shortcodes/js/jquery.viewportf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='plugins/designthemes-core-features/shortcodes/js/shortcodesf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='plugins/bbpress/templates/default/js/editor98d8.js?ver=2.5.4-5380'></script>
    <script type='text/javascript' src='js/comment-reply.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='plugins/contact-form-7/includes/js/jquery.form.mind03d.js?ver=3.51.0-2014.06.20'></script>
    <script type='text/javascript' src='plugins/contact-form-7/includes/js/scripts2f54.js?ver=4.1'></script>
    <script type='text/javascript' src='plugins/woocommerce/assets/js/frontend/add-to-cart.min7888.js?ver=2.2.8'></script>
    <script type='text/javascript' src='plugins/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.minc6bd.js?ver=3.1.5'></script>
    <script type='text/javascript' src='plugins/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.init.min7888.js?ver=2.2.8'></script>
    <script type='text/javascript'>
    /* <![CDATA[ */
    var wc_single_product_params = {"i18n_required_rating_text":"Please select a rating","review_rating_required":"yes"};
    var wc_single_product_params = {"i18n_required_rating_text":"Please select a rating","review_rating_required":"yes"};
    /* ]]> */
    </script>
    <script type='text/javascript' src='plugins/woocommerce/assets/js/frontend/single-product.min7888.js?ver=2.2.8'></script>
    <script type='text/javascript' src='plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.minc8cb.js?ver=2.60'></script>
    <script type='text/javascript' src='plugins/woocommerce/assets/js/frontend/woocommerce.min7888.js?ver=2.2.8'></script>
    <script type='text/javascript' src='plugins/woocommerce/assets/js/frontend/cart-fragments.min7888.js?ver=2.2.8'></script>
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
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.donutchartf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.fitvidsf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.bxsliderf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.parallax-1.1.3f9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/customf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='plugins/yith-woocommerce-zoom-magnifier/assets/js/jquery.carouFredSel.minf731.js?ver=6.2.1'></script>
    <script type='text/javascript' src='plugins/yith-woocommerce-zoom-magnifier/assets/js/yith_magnifier.min8daf.js?ver=1.1.4'></script>
    <script type='text/javascript' src='plugins/yith-woocommerce-zoom-magnifier/assets/js/frontend.min8daf.js?ver=1.1.4'></script>
    <script type='text/javascript' src='js/jquery/ui/jquery.ui.tabs.min2c18.js?ver=1.10.4'></script>
    <script type='text/javascript' src='plugins/woothemes-sensei/assets/js/user-dashboard.min6bc5.js?ver=1.5.2'></script>
    <script type='text/javascript' src='plugins/woothemes-sensei/assets/js/general-frontend.minaff7.js?ver=1.6.0'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/fancybox/jquery.fancybox-1.3.7.min00e2.js?ver=1.5.7'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/jquery.easing.pack4e44.js?ver=1.3'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/jquery.mousewheel.min4830.js?ver=3.1.12'></script>
    <script type="text/javascript">
    jQuery(document).on('ready post-load', easy_fancybox_handler );
    </script>
    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($){
            $('form#commentform').submit(function (e) {
                e.stopPropagation(); 
                e.preventDefault(); 
                var formDatas = $(this).serialize();
                var comFormRest = $(this).attr("action");
                ajaxQuery(comFormRest, "POST", formDatas, "Review Sent !!!", "Review Not Sent !!!", '', "Please enter: ");
                return false;
            });
            $("#add-to-cart").click(function(e){
                e.stopPropagation(); 
                e.preventDefault(); 
                var formDatas = $("form#cartItemForm").serialize();
                ajaxQuery("REST/manage-cart-item.php", "POST", formDatas, "Item Added to Cart !!!", "Add to Cart Failed !!!", '', '');
                return false;
            });
            $("#purchase-now").click(function(e){
                e.stopPropagation(); 
                e.preventDefault(); 
                $("form#cartItemForm").attr('action', 'paypal/order-process.php').trigger('submit');
            });
            
            function ajaxQuery(restUrl, ajaxType, data, succMsgHead, errMsgHead, succMsg, errMsg){
                $.ajax({
                    url:  restUrl,
                    type: ajaxType,
                    data: data,
                    cache: false,
                    success : function(data, status) {
                        if(data.status != null && data.status !=1) { 
                            swal({
                                title: errMsgHead,
                                text: errMsg+data.msg,
                                confirmButtonText: "Okay",
                                html: true,
                                customClass: 'twitter',
                                type: 'warning'
                            });
                        }
                        else if(data.status == 1) { 
                            swal({
                                title: succMsgHead,
                                type: 'success',
                                text: succMsg+data.msg,
                                html: true,
                                confirmButtonText: "Okay",
                                customClass: 'twitter'
                            });
                        }
                        else {
                            swal({
                                title: errMsgHead,
                                text: data,
                                type: 'error',
                                html: true,
                                confirmButtonText: "Okay",
                                customClass: 'twitter'
                            });
                        }
                    },
                    error : function(xhr, status) {
                        erroMsg = '';
                        if(xhr.status===0){ erroMsg = 'There is a problem connecting to internet. Please review your internet connection.'; }
                        else if(xhr.status===404){ erroMsg = 'Requested page not found.'; }
                        else if(xhr.status===500){ erroMsg = 'Internal Server Error.';}
                        else if(status==='parsererror'){ erroMsg = 'Error. Parsing JSON Request failed.'; }
                        else if(status==='timeout'){  erroMsg = 'Request Time out.';}
                        else { erroMsg = 'Unknow Error.\n'+xhr.responseText;}          
                        swal({
                                title: errMsgHead,
                                text: erroMsg,
                                html: true,
                                type: 'error',
                                confirmButtonText: "Okay",
                                customClass: 'twitter'
                        });
                    }
                });
            }
        });
    </script>
</body>
</html>