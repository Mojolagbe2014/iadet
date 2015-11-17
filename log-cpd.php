<?php 
session_start();
define("CONST_FILE_PATH", "includes/constants.php");
include ('classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$dbMoObj = new Database(MOODLE_DB_NAME);//Instantiate Databse object for moodle database

$userObj = new User($dbMoObj, MOODLE_DB_PREFIX); // Create an object of User class
$filesObj = new Files($dbMoObj, MOODLE_DB_PREFIX);
//If user already login redirect the user to index page
if(!isset($_SESSION['IADETUserName']) && !isset($_SESSION['IADETuserEmail'])) {
    $thisPage->redirectTo('index');
}
$thisUserId = $_SESSION['IADETuserId'];

foreach ($userObj->fetchRaw("*", " confirmed = 1 AND id = $thisUserId ") as $user) {
    $userData = array('id', 'firstName', 'lastName','email','description','picture', 'phone', 'address', 'userName', 'dateRegistered');
    foreach ($userData as $userParam){
        switch ($userParam) { 
            case 'firstName': $userObj->$userParam = ucwords($user['firstname']); break;
            case 'lastName': $userObj->$userParam = ucwords($user['lastname']); break;
            case 'userName': $userObj->$userParam = ucwords($user['username']); break;
            case 'phone': $userObj->$userParam = $user['phone1']; break;
            case 'dateRegistered': $userObj->$userParam = date('m/d/Y H:i:s', $user['timecreated']); break;
            default     :   $userObj->$userParam = $user[$userParam]; break; 
        }
    }
    $thisUserPicture = '';
    foreach ($filesObj->fetchRaw("*", " id = $userObj->picture ", "id LIMIT 1 ") as $picture) {
        $userObj->picture = MOODLE_URL.'pluginfile.php/'.$picture['contextid'].'/user/icon/'.$picture['filearea'].'/clean/'.$picture['filename'].'?rev='.$userObj->id;  
    }    
}

$thisPage->title = StringManipulator::trimStringToFullWord(62, stripslashes(strip_tags("Log CPD - International Academy of Dental Education and Training (IADET)")));
$thisPage->description = StringManipulator::trimStringToFullWord(150, stripslashes(strip_tags("Add new course or log new CPD.")));
$thisPage->keywords = "course, cpd, log, add";
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
    <style type='text/css'>.tp-caption a{color:#ff7302;text-shadow:none;-webkit-transition:all 0.2s ease-out;-moz-transition:all 0.2s ease-out;-o-transition:all 0.2s ease-out;-ms-transition:all 0.2s ease-out}.tp-caption a:hover{color:#ffa902}</style>
    <link rel='stylesheet' id='wpmenucart-icons-css'  href='plugins/woocommerce-menu-bar-cart/css/wpmenucart-iconsf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='wpmenucart-css'  href='plugins/woocommerce-menu-bar-cart/css/wpmenucart-mainf9b8.css?ver=4.0' type='text/css' media='all' />
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
    <link rel='stylesheet' id='sccss_style-css'  href='../indexcf5c.html?sccss=1&amp;ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='fancybox-css'  href='plugins/easy-fancybox/fancybox/jquery.fancybox-1.3.7.min00e2.css?ver=1.5.7' type='text/css' media='screen' />
    <link rel='stylesheet' id='mytheme-google-fonts-css'  href='../../fonts.googleapis.com/cssb7b0.css?family=Open+Sans:300,400,600,700|Droid+Serif:400,400italic,700,700italic|Pacifico|Patrick+Hand|Crete+Round:400' type='text/css' media='all' />
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
    <link href="operator/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="operator/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
</head>
    
<body class="page page-id-107 page-template-default custom-background woocommerce-account woocommerce-page tribe-theme-Guru page-template-page-php no-js">
    <div class="main-content">
	<!-- wrapper div starts here -->
        <div id="wrapper">
            <?php include('includes/header.php'); ?>			  
            <!-- breadcrumb starts here -->
            <section class="breadcrumb-wrapper">
                    <div class="container">
                        <h1>Log CPD</h1>
                        <div class="breadcrumb">
                        <a href="index">Home</a><span class="default" >  </span>
                        <a href="profile">Profile</a><span class="default" >  </span><h4>Log CPD</h4>
                        </div>				  
                    </div>                      
            </section>
            <!-- breadcrumb ends here -->    
	  <!-- content starts here -->
	  <div class="content">
            <div class="container">
                <section class="with-right-sidebar" id="primary">
                    <article id="post-4125" class="post-4125 page type-page status-publish hentry">
                        <section id="main-course" class="course-container">
                            <article class="course post post-2541 type-course status-publish has-post-thumbnail hentry course-category-food">
                                <div class="woocommerce">
                                    <h2>New CPD </h2>
                                    <form action="REST/add-user-course.php" method="post" class="login" id="addUserCourse" name="addUserCourse">
                                        <p class="form-row form-row-wide"> <input type="text" name="speciality" id="speciality" placeholder="Course Speciality" value=""  autocomplete="off" autocapitalize="none"/> </p>
                                        <p class="form-row form-row-wide"> <input  id="topic" name="topic" placeholder="Course Topic" type="text" value="" aria-required="true"> </p>
                                        <p class="form-row form-row-wide"> <input type="text" name="attendanceDate" placeholder="Date of the course" id="attendanceDate" value="" /> </p>
                                        <p class="form-row form-row-wide"> <input type="text"  title="To clear this values, simply select all and press delete/backspace" name="point" placeholder="CPD/CME Points/Hours" id="point" value="" /> </p>
                                        <p class="form-row form-row-wide"><input  id="location" name="location" placeholder="Venue/Location" type="text" value="" aria-required="true"></p>
                                        <p class="form-row form-row-wide"><textarea  id="comment" name="comment" placeholder="Comments (optional)" style="height:20%" aria-required="true"></textarea></p>
                                        <p class="form-row form-row-wide">
                                            <label for="certificate">Upload Certificate: <span class="required">*</span></label><br/>
                                            <input  id="certificate" name="certificate" type="file" value="" aria-required="true">
                                        </p>
                                        <p class="form-row">
                                            <input type="hidden" id="user" name="user" value="<?php echo $userObj->id; ?>" />
                                            <input type="hidden" id="LoggedInUserId" name="LoggedInUserId" value="<?php echo $userObj->id; ?>" />
                                            <input type="submit" class="button" name="change-password" value="Upload CPD" /> 
                                            <br/>
                                        </p>
                                    </form>
                                </div>
                            </article>
                        </section>
                        <div class="social-bookmark"></div>                  
                    </article>
                </section>
                <?php include('includes/profile-sidebar.php'); ?>
            </div>
        </div>
        <!-- content ends here -->

        <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <script type='text/javascript' src='js/jquery/jquery90f9.js?ver=1.11.1'></script>
    <script src="sweet-alert/sweetalert.min.js" type="text/javascript"></script>
    <script src="operator/scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($){
            //$("form#addUserCourse #point").keyup(function(){ if ($(this).val().length == 2){ $(this).val($(this).val() + "/1"); } });
            $('#attendanceDate').datetimepicker({ dayOfWeekStart : 1, lang:'en' });
            $('form#addUserCourse').submit(function (e) {
                e.stopPropagation(); 
                e.preventDefault(); 
                var formDatas = new FormData($(this)[0]);
                $.ajax({
                    url:  $(this).attr("action"),
                    type: 'POST',
                    data: formDatas,
                    cache: false,
                    contentType: false,
                    async: false,
                    success : function(data, status) {
                        if(data.status != null && data.status !=1) { 
                            swal({
                                title: "CPD Log Failed !!!",
                                text: "Please supply: "+data.msg,
                                confirmButtonText: "Okay",
                                customClass: 'twitter',
                                type: 'warning'
                            });
                        }
                        else if(data.status != null && data.status == 1) { 
                            swal({
                                title: "CPD Successfully Logged !!!",
                                type: 'success',
                                text: data.msg+ "<br/> Do you want to move to profile now?",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Yes, Profile!",
                                cancelButtonText: "No, thanks!",
                                closeOnConfirm: false,
                                closeOnCancel: true,
                                html: true,
                                customClass: 'twitter'
                                },
                                function(isConfirm){ if (isConfirm) { setInterval(function(){ window.location = 'profile';}, 3000); } 
                            });
                        }
                        else {
                            swal({
                                title: "CPD Log Failed !!!",
                                text: data,
                                type: 'error',
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
                                title: "CPD Log Failed !!!",
                                text: erroMsg,
                                type: 'error',
                                confirmButtonText: "Okay",
                                customClass: 'twitter'
                        });
                    },
                    processData: false
                });
                return false;
            });
        });
    </script>
    <script src="operator/scripts/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
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
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.stickyf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.smartresizef9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery-smoothscrollf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery-easing-1.3f9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.inviewf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.validate.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.carouFredSel-6.2.0-packedf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.isotope.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.ui.totop.minf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.meanmenuf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.bxsliderf9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/jquery.parallax-1.1.3f9b8.js?ver=4.0'></script>
    <script type='text/javascript' src='themes/Guru/framework/js/public/customf9b8.js?ver=4.0'></script>
    
</body>
</html>