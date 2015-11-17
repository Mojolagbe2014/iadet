            <div class="top-bar">
                <div class="container">
                    <div>
                    <?php if(isset($_SESSION['illegalOperation'])) {  ?>
                    <script src="sweet-alert/sweetalert.min.js" type="text/javascript"></script>
                    <script>
                        swal({
                            title: "Illegal Operation!!!",
                            text: '<?php echo $_SESSION['illegalOperation']; ?>',
                            confirmButtonText: "Okay",
                            customClass: 'twitter',
                            html: true,
                            type: 'error'
                        });
                    </script>
                    <?php  unset($_SESSION['illegalOperation']);  } ?>
                    </div>
                    <?php if(!isset($_SESSION['IADETUserName']) && !isset($_SESSION['IADETuserEmail'])) { ?>
                    <div class="float-left">
                        Sign-up today to join learners already on IADET. <a href="register" title="Register Now">Register Now</a> /  <a href="login" title="Already have an account? Sign-in">Login</a>                   
                    </div>
                    <?php } else { ?>
                    <div class="float-left">
                        Howdy <a href="profile" style="text-decoration: none" title="Go to your profile page"><?php echo $_SESSION['IADETUserName']; ?></a>,                   
                    </div>
                    <?php } ?>
                    <?php if(isset($_SESSION['IADETUserName']) && isset($_SESSION['IADETuserEmail'])) { ?>
                    <div class="float-right" id="social-bar">                            	
                        <a href="profile" title="Go to profile page"><i class="fa fa-user" style="color:#FFF;font-size:26px;margin:5px"></i></a> 
                        <a href="#" class="logout" title="Sign out"><i class="fa fa-sign-out" style="color:#FFF;font-size:26px;"></i></a>
                        <a href="cart?id=<?php echo $_SESSION['IADETuserId']; ?>" title="Cart Items"><i class="fa fa-shopping-cart" style="color:#FFF;font-size:26px;"></i> Courses: <strong><?php echo CartItem::getSingleCount($dbObj, $_SESSION['IADETuserId']); ?></strong></a>
                    </div>
                    <?php } else {?>
                    <div class="float-right" id="social-bar">    
<!--                        <a href="register" title="Register"><i class="fa fa-plus-circle" style="color:#FFF;font-size:26px;margin-right:10px"></i></a> 
                        <a href="login" class="" title="Sign In"><i class="fa fa-sign-in" style="color:#FFF;font-size:26px;"></i></a>-->
                    </div>
                    <?php } ?>
                </div>
            </div>
            <!-- header starts here -->
            <div id="header-wrapper">
                <header>
                    <!-- main menu container starts here -->
                    <div class="menu-main-menu-container header1">
                        <div class="container">
                            <div id="logo">
                                    <a href="index" title="<?php echo WEBSITE_AUTHOR; ?>"><img src="images/iadet-logo.png" alt="<?php echo WEBSITE_AUTHOR; ?>" title="<?php echo WEBSITE_AUTHOR; ?>" /></a>                           
                            </div>
                            <div id="primary-menu">                        
                                <nav id="main-menu">
                                    <ul id="menu-main-menu" class="menu">
                                        <li id="menu-item-165" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-39 <?php echo $thisPage->active($_SERVER['REQUEST_URI'], 'index', 'current_page_item'); ?> menu-item-depth-0 menu-item-simple-parent "><a href="index">Home</a></li>
                                        <li id="menu-item-164" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-depth-0 <?php echo $thisPage->active($_SERVER['REQUEST_URI'], 'my-courses', 'current_page_item').$thisPage->active($_SERVER['REQUEST_URI'], 'course-categories', 'current_page_item').$thisPage->active($_SERVER['REQUEST_URI'], 'my-logged-cpds', 'current_page_item'); ?> menu-item-simple-parent "><a href="<?php echo MOODLE_URL; ?>">Courses</a>
                                            <ul class="sub-menu">
                                                <li id="menu-item-1641" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-1"><a href="course-categories">Course Categories</a></li>
                                                <?php if(isset($_SESSION['IADETUserName']) && isset($_SESSION['IADETuserEmail'])) { ?>
                                                <li id="menu-item-1641" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-1"><a href="my-courses">My Courses</a></li>
                                                <li id="menu-item-1641" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-1"><a href="my-logged-cpds">My Logged CPDs</a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <li id="menu-item-164" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-depth-0 <?php echo $thisPage->active($_SERVER['REQUEST_URI'], 'about', 'current_page_item').$thisPage->active($_SERVER['REQUEST_URI'], 'what-we-do', 'current_page_item'); ?> menu-item-simple-parent "><a href="about">About</a>
                                            <ul class="sub-menu">
                                                <li id="menu-item-249" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-1"><a href="about">About Us</a></li>
                                                <li id="menu-item-383" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-1"><a href="what-we-do">What We do</a></li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-455" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-0 <?php echo $thisPage->active($_SERVER['REQUEST_URI'], 'services', 'current_page_item'); ?> menu-item-simple-parent "><a href="services">Services</a></li>
                                        <li id="menu-item-234" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-0 <?php echo $thisPage->active($_SERVER['REQUEST_URI'], 'contact', 'current_page_item'); ?> menu-item-simple-parent "><a href="contact">Contact</a></li>
                                        <li id="menu-item-162" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-depth-0 <?php echo $thisPage->active($_SERVER['REQUEST_URI'], 'faq', 'current_page_item').$thisPage->active($_SERVER['REQUEST_URI'], 'training-facility', 'current_page_item').$thisPage->active($_SERVER['REQUEST_URI'], 'events', 'current_page_item'); ?> menu-item-simple-parent "><a href="#">More </a>
                                            <ul class="sub-menu">
                                                <?php if(isset($_SESSION['IADETUserName']) && isset($_SESSION['IADETuserEmail'])) { ?>
                                                <li id="menu-item-432" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-1"><a href="profile">Profile</a></li>
                                                <li id="menu-item-432" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-1"><a href="#" class="logout">Sign Out</a></li>
                                                <?php } else { ?>
                                                <li id="menu-item-432" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-1"><a href="login">Sign In</a></li>
                                                <li id="menu-item-432" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-1"><a href="register">Register</a></li>
                                                <?php } ?>
                                                <li id="menu-item-432" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-1"><a href="faq">FAQs</a></li>
                                                <li id="menu-item-432" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-1"><a href="events">Upcoming Events</a></li>
                                                <li id="menu-item-433" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-1"><a href="training-facility">Europe Training Facility</a></li>
                                            </ul>
                                        </li>
                                        <li><a style="margin-left:20px; padding: 0px 5px;" href="https://www.facebook.com/iadetblendededucation" rel="nofollow" target="_blank" title="Follow us on Facebook"><i class="fa fa-facebook-square" style="color:blue;font-size:26px;"></i></a> </li>
                                        <li><a style="padding: 0px 5px;" href="https://twitter.com/IADETBlendedEdu" rel="nofollow" target="_blank" title="Follow us on Twitter"><i class="fa fa-twitter-square" style="color:lightblue;font-size:26px;"></i></a></li>
                                        <li><a style="padding: 0px 5px;" href="https://plus.google.com/106890653952747125666/about" rel="nofollow" target="_blank" title="Follow us on Google Plus"><i class="fa fa-google-plus-square" style="color:darkred;font-size:26px;"></i></a></li>
                                        <li><a style="padding: 0px 5px;" href="https://www.youtube.com/channel/UCXR9vFJE1CgnebBctSN2VHQ" rel="nofollow" target="_blank" title="Subscribe to our channel on YouTube"><i class="fa fa-youtube-square" style="color:red;font-size:26px;"></i></a></li>
                                    </ul>
                                </nav>
                            </div>                            
                        </div>
                    </div>
                    <!-- main menu container ends here -->
                </header>
            </div>
            <!-- header ends here -->