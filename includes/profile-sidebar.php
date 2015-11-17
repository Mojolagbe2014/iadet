<section id="secondary">
                    <aside id="categories-6" class="widget widget_categories">
                        <div class="widget-title"><h3>Navigation</h3><div class="title-sep"><span></span></div></div>		
                        <ul>
                            <li class="cat-item cat-item-56"><a href="my-courses" >My Courses</a> </li>
                            <li class="cat-item cat-item-56"><a href="my-logged-cpds" >My Logged CPDs</a> </li>
                            <li class="cat-item cat-item-56"><a href="edit-profile" >Edit Profile </a> </li>
                            <li class="cat-item cat-item-34"><a href="change-password" >Change Password </a> </li>
                            <li class="cat-item cat-item-34"><a href="log-cpd" >Log CPD </a> </li>
                            <li class="cat-item cat-item-34"><a href="cart?id=<?php echo $_SESSION['IADETuserId']; ?>" >Cart Items <span><?php echo CartItem::getSingleCount($dbObj, $_SESSION['IADETuserId']); ?></span></a> </li>
                        </ul>

                    </aside>
                    
                    <aside id="tag_cloud-2" class="widget widget_tag_cloud">
                        <div class="widget-title"><h3>Logged CPDs</h3><div class="title-sep"><span></span></div></div>
                        <div class="tagcloud">
                            <?php 
                            $userCourse = new UserCourse($dbObj);
                            foreach ($userCourse->fetchRaw("*", " user = $userObj->id ") as $loggedCpd) {
                            ?>
                            <a href='logged-cpd?id=<?php echo $loggedCpd['id']; ?>' class='tag-link-64' title='<?php echo $loggedCpd['topic']; ?>' style='font-size: 8pt;'><?php echo $loggedCpd['topic']; ?></a>
                            <?php } ?>
                        </div>
                    </aside>
                </section>