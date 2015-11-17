<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Main Website Index Page - AIDET</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    <script src="../ckeditor/ckeditor.js" type="text/javascript"></script>
    <link href="css/jquery-ui.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php include("includes/header.php"); ?>

    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <?php include("includes/side-menu.php"); ?>
                </div><!--/.span3-->
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3> Page Manager: Home</h3>
                            </div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid" id="ManageWebsiteIndex" name="ManageWebsiteIndex" action="../REST/manage-website-index.php" enctype="multipart/form-data">
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="title">Page Title:</label>
                                        <div class="controls">
                                            <input data-title="" type="text" placeholder="Page Title" id="title" name="title" data-original-title="" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="description">Page Description:</label>
                                        <div class="controls">
                                            <textarea class="span8" id="description" placeholder="Page Description" name="description" class="span8 tip"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="keywords">Page Keywords:</label>
                                        <div class="controls">
                                            <textarea class="span8" id="keywords" placeholder="Page Keywords" name="keywords" class="span8 tip"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="topBackGround">Top Slider Background:</label>
                                        <div class="controls">
                                            <input type="hidden" name="id" id="id" /> <input type="hidden" name="oldTopBackGround" id="oldTopBackGround" />
                                            <input data-title="" type="file" placeholder="" id="topBackGround" name="topBackGround" data-original-title="topBackGround" class="span8 tip">
                                            <br/>Old Top Slider Background: <span id="oldTopBackGroundComment"></span>
                                            <div id="oldTopBackGroundSource"></div>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="topLogo">Top Slider Logo:</label>
                                        <div class="controls">
                                            <input type="hidden" name="oldTopLogo" id="oldTopLogo" />
                                            <input data-title="" type="file" placeholder="" id="topLogo" name="topLogo" data-original-title="topLogo" class="span8 tip">
                                            <br/>Old Top Logo: <span id="oldTopLogoComment"></span>
                                            <div id="oldTopLogoSource"></div>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="topH1">Top Slider First Title:</label>
                                        <div class="controls">
                                            <input data-title="" type="text" placeholder="Top Slider First Title" id="topH1" name="topH1" data-original-title="" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="topH3">Top Slider Second Title:</label>
                                        <div class="controls">
                                            <input data-title="" type="text" placeholder="Top Slider Second Title" id="topH3" name="topH3" data-original-title="" class="span8 tip">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="bottomBackGround">Bottom Slider Background:</label>
                                        <div class="controls">
                                            <input type="hidden" name="oldBottomBackGround" id="oldBottomBackGround" />
                                            <input data-title="" type="file" placeholder="" id="bottomBackGround" name="bottomBackGround" data-original-title="topBackGround" class="span8 tip">
                                            <br/>Old Bottom Slider Background: <span id="oldBottomBackGroundComment"></span>
                                            <div id="oldBottomBackGroundSource"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="bottomH1">Bottom Slider First Title:</label>
                                        <div class="controls">
                                            <input data-title="" type="text" placeholder="Bottom Slider First Title" id="bottomH1" name="bottomH1" data-original-title="" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="bottomH2">Bottom Slider Second Title:</label>
                                        <div class="controls">
                                            <textarea class="span8" id="bottomH2" name="bottomH2" class="span8 tip"></textarea>
                                            <script>
                                                CKEDITOR.replace('bottomH2');
                                            </script>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="bottomVideo">Bottom Slider Video:</label>
                                        <div class="controls">
                                            <input type="hidden" name="oldBottomVideo" id="oldBottomVideo" />
                                            <input data-title="" type="file" placeholder="" id="bottomVideo" name="bottomVideo" data-original-title="topLogo" class="span8 tip">
                                             <br>Old Video: <span id="oldBottomVideoComment"></span>
                                             <div id="videoSource"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="updateThisIndex" id="updateThisIndex" value="updateThisIndex"/>
                                            <button type="submit" name="updateContent" id="updateContent" class="btn btn-danger">Update Index Page</button> &nbsp; &nbsp;
                                            <button type="button" id="cancelEdit" class="btn btn-info">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="messageBox"></div>
                    </div><!--/.content-->
                </div><!--/.span9-->
            </div>
        </div><!--/.container-->
    </div><!--/.wrapper-->

    <?php include("includes/footer.php"); ?>

    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<!--    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>-->
    <script src="scripts/jquery-ui.1.11.4.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
    <script src="scripts/common-handler.js" type="text/javascript"></script>
    <script src="scripts/manage-website-index.js" type="text/javascript"></script>
</body>