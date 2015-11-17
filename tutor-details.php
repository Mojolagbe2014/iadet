<?php 
session_start();
define("CONST_FILE_PATH", "includes/constants.php");
include ('classes/WebPage.php'); //Set up page as a web page
$thisPage = new WebPage(); //Create new instance of webPage class

$dbObj = new Database();//Instantiate database
$teamObj = new Tutor($dbObj); // Create an object of WebsiteContact class
$tutorId = filter_input(INPUT_GET, 'post_id') ? filter_input(INPUT_GET, 'post_id', FILTER_VALIDATE_INT) : 1;

foreach ($teamObj->fetchRaw("*", " visible =1 AND id = $tutorId ") as $tutorObj){
?>
    <div class="content">
          <div class="container">
              <section class="content-full-width" id="primary">
                  <article id="post-225" class="post-225 dt_teachers type-dt_teachers status-publish has-post-thumbnail hentry">
                      <div class="hr-title"><h2><?php echo $tutorObj['name']; ?></h2><div class="title-sep"><span></span></div></div>
                      <div class="column dt-sc-one-fourth first">
                          <div class="team-thumb">
                              <img width="250" height="268" src="media/tutor/<?php echo $tutorObj['picture']; ?>" class="attachment-full wp-post-image" alt="<?php echo $tutorObj['name']; ?>" title="<?php echo $tutorObj['name']; ?>" />	  
                          </div>
                      </div>
                      <div class="column dt-sc-three-fourth" style="max-height:350px;max-width:74%; overflow-y: auto;">
                          <ul class="dt-sc-fancy-list rounded-arrow">	                              
                              <li><strong>Qualification : </strong><?php echo $tutorObj['qualification']; ?></li>
                              <li><strong>Email : </strong><a href="malto:<?php echo $tutorObj['email']; ?>"><?php echo $tutorObj['email']; ?></a></li>
                              <li><strong>Specialist in : </strong>
                                  <?php echo $tutorObj['field']; ?>
                              </li>                          
                          </ul>
                          <p><?php echo $tutorObj['bio']; ?></p>
                      </div>
                  </article>
              </section>
          </div>
      </div>
<?php } ?>