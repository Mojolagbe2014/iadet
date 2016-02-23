<?php 
session_start();
define("CONST_FILE_PATH", "includes/constants.php");
include ('classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$courseCategoryObj = new CourseCategory($dbMoObj, MOODLE_DB_PREFIX); // Create an object of CourseCategory class

$thisPage->title = StringManipulator::trimStringToFullWord(62, stripslashes(strip_tags("Course Categories - International Academy of Dental Education and Training (IADET)")));
$thisPage->description = StringManipulator::trimStringToFullWord(150, stripslashes(strip_tags("Categories of ecoures, online courses, elearining, dental courses, dental elearning, dental ecourses")));
$thisPage->keywords = "dental, ecourses, category, online, course, courses";
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
    <link rel='stylesheet' id='layerslider-css'  href='plugins/LayerSlider/static/css/layerslider3c21.css?ver=5.1.1' type='text/css' media='all' />
    <link rel='stylesheet' id='ls-google-fonts-css'  href='http://fonts.googleapis.com/css?family=Lato:100,300,regular,700,900|Open+Sans:300|Indie+Flower:regular|Oswald:300,regular,700&amp;subset=latin,latin-ext' type='text/css' media='all' />
    <link rel='stylesheet' id='responsive_map_css-css'  href='plugins/responsive-maps-plugin/includes/css/rsmaps6f16.css?ver=2.22' type='text/css' media='all' />
    <link rel='stylesheet' id='rs-plugin-settings-css'  href='plugins/revslider/rs-plugin/css/settings17d1.css?rev=4.6.0&amp;ver=4.0' type='text/css' media='all' />
    <style type='text/css'> .tp-caption a{color:#ff7302;text-shadow:none;-webkit-transition:all 0.2s ease-out;-moz-transition:all 0.2s ease-out;-o-transition:all 0.2s ease-out;-ms-transition:all 0.2s ease-out}.tp-caption a:hover{color:#ffa902}</style>
    <link rel='stylesheet' id='woothemes-sensei-frontend-css'  href='plugins/woothemes-sensei/assets/css/frontend1f22.css?ver=1.6.2' type='text/css' media='screen' />
    <link rel='stylesheet' id='default-css'  href='themes/Guru/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='shortcode-css'  href='themes/Guru/css/shortcodef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='skin-css'  href='themes/Guru/skins/dark-blue/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='menumenu-css'  href='themes/Guru/css/meanmenuf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='isotope-css'  href='themes/Guru/css/isotopef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='prettyphoto-css'  href='themes/Guru/css/prettyPhotof9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='style.fontawesome-css'  href='themes/Guru/css/font-awesome.minf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='stylewoo-css'  href='themes/Guru/framework/woocommerce/css/stylef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='responsive-css'  href='themes/Guru/css/responsivef9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='et_lb_modules-css'  href='plugins/elegantbuilder/style7793.css?ver=2.4' type='text/css' media='all' />
    <link rel='stylesheet' id='fancybox-css'  href='plugins/easy-fancybox/fancybox/jquery.fancybox-1.3.7.min00e2.css?ver=1.5.7' type='text/css' media='screen' />
    <link rel='stylesheet' id='mytheme-google-fonts-css'  href='http://fonts.googleapis.com/cssb7b0.css?family=Open+Sans:300,400,600,700|Droid+Serif:400,400italic,700,700italic|Pacifico|Patrick+Hand|Crete+Round:400' type='text/css' media='all' />
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
        input#access-courses {display:block;margin-top:-40px;margin-bottom:15px;margin-right:10px}
        @media screen and (max-width: 800px) { a#overlay-link {width:35%;margin:0px;padding:0px;}}
    </style>
    <link href="sweet-alert/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="sweet-alert/twitter.css" rel="stylesheet" type="text/css"/>
</head>
<body class="archive tax-product_cat term-dental term-8 custom-background woocommerce woocommerce-page tribe-theme-Guru page-template-archive-php no-js">
    <div class="main-content">
	<!-- wrapper div starts here -->
        <div id="wrapper">
            <?php echo include ('includes/header.php'); ?>
            <!-- breadcrumb starts here -->
            <section class="breadcrumb-wrapper">
                <div class="container">
                    <h1>Course Categories</h1>
                <div class="breadcrumb"><a href="index">Home</a><span class="default" >  </span><h4>Course Categories</h4></div>                    </div>                      
            </section>
            <!-- breadcrumb ends here -->
            <div class="content">
                <div class="submit" >
                            <input type="submit" id="access-courses" onclick="window.location='<?php echo MOODLE_URL; ?>'" value="Access Courses" />
                        </div>
                <div class="container">
                    <section class="content-full-width" id="primary">
                        
                        <ul class="products">
                            <?php 
                            foreach ($courseCategoryObj->fetchRaw("*", " parent=0 ", " id ") as $courseCategory) {
                                $courseCategoryObj->name = $courseCategory['name'];
                                $courseCategoryObj->status = CourseCategory::getSingle($dbObj, '', 'status', " name = '".$courseCategoryObj->name."'"); 
                                $courseCategoryObj->promotionAmount = CourseCategory::getSingle($dbObj, '', 'promotion_amount', " name = '".$courseCategoryObj->name."'");
                                $courseCategoryObj->amount = CourseCategory::getSingle($dbObj, '', 'amount', " name = '".$courseCategoryObj->name."'");
                                $courseCategoryObj->image = CourseCategory::getSingle($dbObj, '', 'image', " name = '".$courseCategoryObj->name."'");
                                $courseCategoryObj->installment = CourseCategory::getSingle($dbObj, '', 'installment', " name = '".$courseCategoryObj->name."'");
                            ?>
                            <li class="post-283 product type-product status-publish has-post-thumbnail first post pif-has-gallery shipping-taxable purchasable product-type-simple product-cat-dental instock">
                                <div class=' dt-sc-one-half column  in-stock-product '>
                                    <div class='product-wrapper'>
                                        <div class='product-thumb'>
                                            <img style="width:400px;height:267px" src="media/category/<?php echo $courseCategoryObj->image;  ?>" class="attachment-shop_catalog wp-post-image" alt="<?php echo $courseCategory['name']; ?>" />
                                            <img style="width:100px;height:80px" src="media/category/<?php echo $courseCategoryObj->image;  ?>" class="secondary-image attachment-shop-catalog" alt="<?php echo $courseCategory['name']; ?>" />
                                            <a href="single-category-courses?id=<?php echo $courseCategory['id']; ?>" id="overlay-link" data-product_id="283" data-product_sku="L1001" data-quantity="1" class="small button add_to_cart_button product_type_simple">View Courses</a>
                                        </div>
                                        <div class='product-title'>
                                            <a href='single-category-courses?id=<?php echo $courseCategory['id']; ?>'>
                                                <h3><?php echo $courseCategory['name']; ?></h3>
                                            </a>
                                        </div>
<!--                                        <div class='product-details'>
                                            <span class="price"><span class="amount"><?php //echo $courseCategory['description']; ?></span></span>
                                        </div>-->
                                        <div class='product-details' style="text-align:center">
                                            <span class="price"><span class="amount" style="font-weight:normal"><?php echo stripslashes(strip_tags($courseCategory['description'])); ?></span></span>
                                            <?php if($courseCategoryObj->amount !=0 || $courseCategoryObj->amount !='') { ?>
                                            <p class="price" style="font-weight: bold; line-height:1.0; margin-top: 15px">Amount: <span class="amount" <?php if($courseCategoryObj->status == 1) echo 'style="text-decoration: line-through; color:red;font-weight:bolder"'; ?>>&pound;<?php echo number_format($courseCategoryObj->amount); ?></span></p>
                                            <?php if($courseCategoryObj->status == 1) { ?>
                                            <p class="price" style="font-weight: bold;line-height:1.0;color:green">Promotional Amount: <span class="amount" style="font-weight:bolder">&pound;<?php echo number_format($courseCategoryObj->promotionAmount); ?></span></p>
                                            <?php } ?>
                                            <p class="price"  style="font-weight: bold;line-height:1.0;">Total Courses: <span class="amount" ><?php echo Course::getSingleCategoryCount($dbMoObj, $courseCategory['id'], MOODLE_DB_PREFIX); ?></span></p>
                                            <form class="cart" method="POST" class="purchasableCategories"  enctype='multipart/form-data'>
                                                <input type="hidden" name="category" id="category" value="<?php echo $courseCategory['id']; ?>" />
                                                <input type="hidden" name="addNewCartItem" id="addNewCartItem" value="addNewCartItem" />
                                                <input type="hidden" name="purchaseMode" id="purchaseMode" value="full" />
                                                <button style="margin-right:28%; background-color: #003bb3; font-size: 11px" class="purchase-now" type="submit" data-course-id="<?php echo $courseCategory['id']; ?>" class="single_add_to_cart_button button alt" > <i class="fa fa-money"></i> Purchase Category</button>
                                            </form>
                                            <?php if($courseCategoryObj->installment == 1) { ?>
                                            <form class="cart" method="POST" class="purchasableInstallment"  enctype='multipart/form-data'>
                                                <input type="hidden" name="category" id="category" value="<?php echo $courseCategory['id']; ?>" />
                                                <input type="hidden" name="addNewCartItem" id="addNewCartItem" value="addNewCartItem" />
                                                <input type="hidden" name="purchaseMode" id="purchaseMode" value="installment" />
                                                <button style="margin-right:26%; background-color: #003bb3; font-size: 11px" class="purchase-installment" type="submit" data-course-id="<?php echo $courseCategory['id']; ?>" class="single_add_to_cart_button button alt" > <i class="fa fa-money"></i> Installment Purchase</button>
                                            </form>
                                            <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </section>
                </div>
            </div>
            <?php include ('includes/footer.php'); ?>
        </div>
    </div>
    <script type='text/javascript' src='js/jquery/jquery90f9.js?ver=1.11.1'></script>
    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($){ 
            $(".purchase-now").click(function(e){
                e.stopPropagation(); 
                e.preventDefault(); 
                $(this).parent().attr('action', 'paypal/order-process.php').trigger('submit');
            });
            $(".purchase-installment").click(function(e){
                e.stopPropagation(); 
                e.preventDefault(); 
                $(this).parent().attr('action', 'paypal/order-process.php').trigger('submit');
            });
        });
    </script>
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
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.bxsliderf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.parallax-1.1.3f9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/customf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='js/jquery/ui/jquery.ui.tabs.min2c18.js?ver=1.10.4'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/fancybox/jquery.fancybox-1.3.7.min00e2.js?ver=1.5.7'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/jquery.easing.pack4e44.js?ver=1.3'></script>
    <script type='text/javascript' src='plugins/easy-fancybox/jquery.mousewheel.min4830.js?ver=3.1.12'></script>
    
</body>
</html>