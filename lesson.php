<?php 
session_start();
define("CONST_FILE_PATH", "includes/constants.php");
include ('classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$userObj = new User($dbObj); // Create an object of User class
$courseObj = new Course($dbObj); // Create an instance of course class/CPD class
$lessonObj = new Lesson($dbObj);//Instantiate lesson
$purchaseRecordObj = new PurchaseRecord($dbObj); //Instantiate purchase record

//If user already login redirect the user to index page
if(!isset($_SESSION['IADETUserName']) && !isset($_SESSION['IADETuserEmail'])) {
    $thisPage->redirectTo('index');
}
$thisUserId = $_SESSION['IADETuserId'];
//get the course id; if failed redirect to profile page
$thisCourseId = filter_input(INPUT_GET, 'course', FILTER_VALIDATE_INT) ? filter_input(INPUT_GET, 'course', FILTER_VALIDATE_INT) : $thisPage->redirectTo('profile');

$thisLessonId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : $thisPage->redirectTo('profile');

foreach ($userObj->fetchRaw("*", " status = 1 AND id = $thisUserId ") as $user) {
    $userData = array('id', 'name','email','city','country','description','picture','website', 'skypeId', 'yahooId', 'phone', 'address', 'userName', 'passWord', 'dateRegistered', 'facebookId', 'twitterId');
    foreach ($userData as $userParam){
        switch ($userParam) { 
            case 'skypeId': $userObj->$userParam = $user['skype_id']; break;
            case 'yahooId': $userObj->$userParam = $user['yahoo_id']; break;
            case 'userName': $userObj->$userParam = $user['username']; break;
            case 'passWord': $userObj->$userParam = $user['password']; break;
            case 'facebookId': $userObj->$userParam = $user['facebook_id']; break;
            case 'twitterId': $userObj->$userParam = $user['twitter_id']; break;
            case 'dateRegistered': $userObj->$userParam = $user['date_registered']; break;
            default     :   $userObj->$userParam = $user[$userParam]; break; 
        }
    }
    
}

foreach ($courseObj->fetchRaw("*", " status = 1 AND id = $thisCourseId ") as $course) {
    $courseData = array('id', 'name','image','shortName','category','startDate','code','description', 'media', 'amount', 'dateRegistered');
    foreach ($courseData as $courseParam){
        switch ($courseParam) { 
            case 'shortName': $courseObj->$courseParam = $course['short_name']; break;
            case 'startDate': $courseObj->$courseParam = $course['start_date']; break;
            case 'dateRegistered': $courseObj->$courseParam = $course['date_registered']; break;
            default     :   $courseObj->$courseParam = $course[$courseParam]; break; 
        }
    }
    
}

foreach ($lessonObj->fetchRaw("*", " status = 1 AND id = $thisLessonId ") as $lesson) {
    $lessonData = array('id','form','title','body','startDate','endDate','tutor','material','parent', 'dateAdded');
    foreach ($lessonData as $lessonParam){
        switch ($lessonParam) { 
            case 'endDate': $lessonObj->$lessonParam = $lesson['end_date']; break;
            case 'startDate': $lessonObj->$lessonParam = $lesson['start_date']; break;
            case 'dateAdded': $lessonObj->$lessonParam = $lesson['date_added']; break;
            default     :   $lessonObj->$lessonParam = $lesson[$lessonParam]; break; 
        }
    }

}

//If user has not purchase the course, then redirect it to profile
if(count($purchaseRecordObj->fetchRaw("*", " user = $userObj->id AND course = $courseObj->id "))<1){ $thisPage->redirectTo('profile');}

$thisPage->title = StringManipulator::trimStringToFullWord(62, stripslashes(strip_tags($lessonObj->title.' ('.$courseObj->code.')'." - International Academy of Dental Education and Training (IADET)")));
$thisPage->description = StringManipulator::trimStringToFullWord(150, stripslashes(strip_tags($lessonObj->body)));
$thisPage->keywords = $lessonObj->title.", course, detail";
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
    <link rel="canonical" href="<?php echo SITE_URL; ?>" />
    <link rel='stylesheet' id='dt-sc-css-css'  href='plugins/designthemes-core-features/shortcodes/css/shortcodesf9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='jeweltheme-jquery-ui-style-css'  href='plugins/wp-awesome-faq/jquery-uif9b8.css?ver=4.0' type='text/css' media='all' />
    <link rel='stylesheet' id='layerslider-css'  href='plugins/LayerSlider/static/css/layerslider3c21.css?ver=5.1.1' type='text/css' media='all' />
    <link rel='stylesheet' id='ls-google-fonts-css'  href='http://fonts.googleapis.com/css?family=Lato:100,300,regular,700,900|Open+Sans:300|Indie+Flower:regular|Oswald:300,regular,700&#038;subset=latin,latin-ext' type='text/css' media='all' />
    <link rel='stylesheet' id='bbp-default-css'  href='themes/Guru/css/bbpress98d8.css?ver=2.5.4-5380' type='text/css' media='screen' />
    <link rel='stylesheet' id='bp-parent-css-css'  href='themes/Guru/css/buddypressdc8c.css?ver=2.2' type='text/css' media='screen' />
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
    <link rel='stylesheet' id='style.fontawesome-css'  href='themes/Guru/css/font-awesome.minf9b8.css?ver=4.0' type='text/css' media='all' />
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
    <link href="sweet-alert/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="sweet-alert/twitter.css" rel="stylesheet" type="text/css"/>
</head>
    
<body class="page page-id-107 page-template-default custom-background woocommerce-account woocommerce-page tribe-theme-Guru page-template-page-php no-js">
    <div class="main-content">
	<!-- wrapper div starts here -->
        <div id="wrapper">
            <?php include('includes/header.php'); ?>			  
            <!-- breadcrumb starts here -->
            <section class="breadcrumb-wrapper">
                    <div class="container">
                        <h1><?php echo $courseObj->code.': '.StringManipulator::trimStringToFullWord(30, $lessonObj->title); ?></h1>
                        <div class="breadcrumb">
                        <a href="index">Home</a><span class="default" >  </span>
                        <a href="profile">Profile</a><span class="default" >  </span>
                        <a href="ecourse?id=<?php echo $courseObj->id; ?>"><?php echo StringManipulator::trimStringToFullWord(30, $courseObj->shortName); ?></a><span class="default" >  </span>
                        <h4><?php echo StringManipulator::trimStringToFullWord(20, $lessonObj->title); ?></h4>
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
                            <?php  
                            $lessonMediaType = pathinfo($lessonObj->material,PATHINFO_EXTENSION);
                            if($lessonMediaType == 'mp4' || $lessonMediaType == 'ogg' || $lessonMediaType == 'webm'){  
                            ?>
                            <article style="margin-left:-30%; padding-left: 0px" class="course post post-2541 type-course status-publish has-post-thumbnail hentry course-category-food">
                                <div class='fullwidth-section  '  style="color:#ffffff;background-repeat:no-repeat;">
                                    <div class="fullwidth-bg">	
                                        <div class="container">
                                            <script type="text/javascript">var lsjQuery = jQuery;</script>
                                            <script type="text/javascript"> 
                                                lsjQuery(document).ready(function() { if(typeof lsjQuery.fn.layerSlider == "undefined") { lsShowNotice('layerslider_7','jquery'); } 
                                                    else { lsjQuery("#layerslider_7").layerSlider({responsiveUnder: 960, layersContainer: 960, autoStart: true, pauseOnHover: false, skinsPath: 'plugins/LayerSlider/static/skins/'}) } }); 
                                            </script>
                                            <div id="layerslider_7" class="ls-wp-container" style="width:960px;height:460px;margin:0 auto;margin-bottom: 0px;">
                                                <div class="ls-slide" data-ls=" transition2d: all;">
                                                    <img src="plugins/LayerSlider/static/img/blank.gif" data-src="uploads/2014/11/macbook-air.png" class="ls-bg" alt="Slide background" />
                                                    <div class="ls-l" style="top:68px;left:244px;white-space: nowrap;" data-ls="offsetxin:0;offsetxout:0;">
                                                        <video width="470" height="290" preload="metadata" controls><source src="media/lesson/<?php echo $lessonObj->material; ?>" type="video/mp4"></video> 
                                                    </div>
                                                </div>
                                            </div>	
                                        </div>
                                    </div>
                                </div>
                                <div class="social-bookmark"></div> 
                            </article>
                            <?php } else { ?>
                            <article class="course post post-2541 type-course status-publish has-post-thumbnail hentry course-category-food">
                                <div><span class="required">[This lesson material is not mp4|ogg|webm. Only MP4|OGG|WEBM lesson material types are Playable]</span></div>
                            </article>
                            <?php } ?>
                            
                            <article class="course post post-2541 type-course status-publish has-post-thumbnail hentry course-category-food">
                                <div class="woocommerce" style="text-align:justify">
                                    <h2><?php echo $lessonObj->title; ?></h2>
                                    <p><?php echo $lessonObj->body; ?> </p>
                                </div>
                            </article>
                            <article class="course post post-2541 type-course status-publish has-post-thumbnail hentry course-category-food">
                                <div class="woocommerce">
                                    <h2>Lesson Media</h2>
                                    <p><a href="media/lesson/<?php echo $lessonObj->material; ?>">View/Download Lesson</a><br/>
                                    </p>
                                </div>
                            </article>
                            <article class="course post post-2541 type-course status-publish has-post-thumbnail hentry course-category-food">
                                <div class="woocommerce">
                                    <h2>Assessments</h2>
                                    <?php 
                                    $assessmentObj = new Assessment($dbObj); $assNum = 1;
                                    foreach ($assessmentObj->fetchRaw("*", " status = 1 AND lesson = $lessonObj->id ") as $assessment) {
                                    ?>
                                    <p><?php echo $assNum.'). '. $assessment['title']; ?><br/>
                                     <?php echo $assessment['question']; ?>
                                    <?php if($assessment['attachment']!=''){ ?>
                                        <a href="media/assessment/<?php echo $assessment['attachment']; ?>">Download Attachment</a>
                                    <?php } ?>
                                    </p>
                                    <?php $assNum++; } ?>
                                </div>
                            </article>
                            <article class="course post post-2541 type-course status-publish has-post-thumbnail hentry course-category-food">
                                <div class="woocommerce">
                                    <h2>Lesson Tutor</h2>
                                    <?php 
                                    $tutorObj = new Tutor($dbObj);
                                    foreach($tutorObj->fetchRaw("*", " id = $lessonObj->tutor ") as $tutor){
                                    ?>
                                    <img src="media/tutor/<?php echo $tutor['picture']; ?>" style="width:20%;height:20%" />
                                    <p><?php echo $tutor['name']; ?><br/><?php echo $tutor['qualification']; ?><br/>
                                    <a href="mailto:<?php echo $tutor['email']; ?>"><?php echo $tutor['email']; ?></a></p>
                                    <?php } ?>
                                </div>
                            </article>
                        </section>
                        <div class="social-bookmark"></div>                  
                    </article>
                </section>
                <section id="secondary">
                    <aside id="categories-6" class="widget widget_categories">
                        <div class="widget-title"><h3>Sub Lessons</h3><div class="title-sep"><span></span></div></div>		
                        <ul>
                            <?php 
                            foreach ($lessonObj->fetchRaw("*", " status = 1 AND form = 'lesson' AND parent = $lessonObj->id ") as $lesson) {
                            ?>
                            <li class="cat-item cat-item-56"><a href="lesson?id=<?php echo $lesson['id'].'&course='.$courseObj->id; ?>" title="<?php echo $lesson['title']; ?>"><?php echo $lesson['title']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </aside>
                </section>
                <section id="secondary">
                    <aside id="categories-6" class="widget widget_categories">
                        <div class="widget-title"><h3>Assessments</h3><div class="title-sep"><span></span></div></div>		
                        <ul>
                            <?php 
                            //$assessmentObj = new Assessment($dbObj);
                            foreach ($assessmentObj->fetchRaw("*", " status = 1 AND lesson = $lessonObj->id ") as $assessment) {
                            ?>
                            <li class="cat-item cat-item-56"><a href="#" title="<?php echo $assessment['title']; ?>"><?php echo $assessment['title']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </aside>
                </section>
            </div>
        </div>
        <!-- content ends here -->

        <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <script type='text/javascript' src='js/jquery/jquery90f9.js?ver=1.11.1'></script>
    <script src="sweet-alert/sweetalert.min.js" type="text/javascript"></script>
    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($){
            $('input[type="text"], input[type="file"], textarea').attr('disabled', 'disabled').css('cursor','no-drop');
            $('input#update-cpd, .hidden-p').hide();
            $('input#edit-cpd').click(function(){
                $(this).hide();
                $('input[type="text"], input[type="file"], textarea').removeProp('disabled').css('cursor','text');
                $('input#update-cpd, .hidden-p').show();
            });
            $('input#cancel-edit').click(function(){
                $(this).hide(); $('input#edit-cpd').show();
                $('input[type="text"], input[type="file"], textarea').attr('disabled','disabled').css('cursor','no-drop');
                $('input#update-cpd, .hidden-p').hide();
            });
            
            $('form#updateUserCourse').submit(function (e) {
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
                                title: "CPD Update Failed !!!",
                                text: "Please supply: "+data.msg,
                                confirmButtonText: "Okay",
                                customClass: 'twitter',
                                type: 'warning',
                                html:true
                            });
                        }
                        else if(data.status != null && data.status == 1) { 
                            swal({
                                title: "CPD Successfully Updated !!!",
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
                                title: "CPD Update Failed !!!",
                                text: data,
                                type: 'error',
                                confirmButtonText: "Okay",
                                customClass: 'twitter',
                                html:true
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
                                title: "CPD Update Failed !!!",
                                text: erroMsg,
                                type: 'error',
                                confirmButtonText: "Okay",
                                customClass: 'twitter',
                                html:true
                        });
                    },
                    processData: false
                });
                return false;
            });
        });
    </script>
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