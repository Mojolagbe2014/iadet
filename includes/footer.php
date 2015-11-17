            
<footer id="footer">
    <div class="footer-widgets">
        <div class="container">
            <div class='column dt-sc-one-half first'>
                <aside id="text-4" class="widget widget_text"><h3 class="widget-title">About</h3>			
                    <div class="textwidget" style="text-align: justify">
                        <img src="images/Logo-color.png" alt="footer-logo" style="width:40px;height:40px;" class="alignleft" />
                        The philosophy of IADET is to offer practical solutions for dental education, not only in terms of Continuous Professional Development but also in terms of expanding the dentist’s knowledge and offering him or her new career opportunities.
                    </div>
		</aside>
            </div>
            <div class='column dt-sc-one-fourth '>
                <aside id="text-5" class="widget widget_text">
                    <h3 class="widget-title">Contact Us</h3>			
                    <div class="textwidget">
                        <p> <span class='fa fa-map-marker'></span><b>Address: </b><?php echo WebsiteContact::getSingle($dbObj, 'address', 1); ?></p>
                        <p> <span class='fa fa-envelope'> </span><b>Mail: </b><a href='mailto:<?php echo WebsiteContact::getSingle($dbObj, 'email', 1); ?>'><?php echo WebsiteContact::getSingle($dbObj, 'email', 1); ?></a> </p>
                        <p> <span class='fa fa-phone'> </span><b>Phone: </b><?php echo WebsiteContact::getSingle($dbObj, 'phone', 1); ?> </p>
                    </div>
		</aside>
            </div>
            <div class='column dt-sc-one-fourth '>
                <aside id="text-6" class="widget widget_text">
                    <h3 class="widget-title">Follow Us</h3>			
                    <div class="textwidget">
                        <ul class='social-media'>
                            <li><a class='fa fa-facebook' href="https://www.facebook.com/iadetblendededucation" rel="nofollow" target="_blank"></a></li>
                            <li><a class='fa fa-twitter' href="https://twitter.com/IADETBlendedEdu" rel="nofollow" target="_blank"></a></li>
                            <li><a class='fa fa-google-plus' href="https://plus.google.com/106890653952747125666/about" rel="nofollow" target="_blank"></a></li>
                            <li><a class='fa fa-youtube' href="https://www.youtube.com/channel/UCXR9vFJE1CgnebBctSN2VHQ" rel="nofollow" target="_blank"></a></li>
                        </ul>
                        <p class='social-media-text'>We can be supported here!</p>
                    </div>
		</aside>
            </div>
        </div>
                
    </div>                
    <div class="footer-info">
        <div class="container">
            <p class="copyright">&copy; 2015 - <a href="http://iadet.net" title="">IADET</a></p>
            <ul id="footer-menu" class="footer-bottom-links">
                <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-39 current_page_item menu-item-293"><a href="index">Home</a></li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-563"><a href="ecourses">eCourses</a></li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-351"><a href="events">Events</a></li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-351"><a href="faq">FAQ</a></li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-291"><a href="contact">Contact Us</a></li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-351"><a href="training-facility">Training Facility</a></li>
            </ul>                
        </div>
            
    </div>
</footer>