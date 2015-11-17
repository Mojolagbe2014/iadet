<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Main Website Training Facility Page - AIDET</title>
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
                                <h3> Page Manager: Europe Training Facility</h3>
                            </div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid" id="ManageWebsiteTrainingFacility" name="ManageWebsiteTrainingFacility" action="../REST/manage-website-training-facility.php" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="id" /> 
                                     <div class="control-group">
                                        <label class="control-label" for="title">Page Title:</label>
                                        <div class="controls">
                                            <textarea class="span8" id="title" placeholder="Page Title" name="title" class="span8 tip"></textarea>
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
                                        <label class="control-label" for="topHeader">Top Slider Header:</label>
                                        <div class="controls">
                                            <textarea class="span8" id="topHeader" placeholder="Top Slider Header" name="topHeader" class="span8 tip"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="topBackGround">Top Slider Background:</label>
                                        <div class="controls">
                                            <input type="hidden" name="oldTopBackGround" id="oldTopBackGround" />
                                            <input data-title="" type="file" placeholder="" id="topBackGround" name="topBackGround" data-original-title="topBackGround" class="span8 tip">
                                            <br/>Old Top Slider Background: <span id="oldTopBackGroundComment"></span>
                                            <div id="oldTopBackGroundSource"></div>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="topText">Top Slider Text:</label>
                                        <div class="controls">
                                            <textarea class="span8" id="topText" placeholder="Top Slider Text" name="topText" class="span8 tip"></textarea>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="updateThisTrainingFacility" id="updateThisTrainingFacility" value="updateThisTrainingFacility"/>
                                            <button type="submit" name="updateContent" id="updateContent" class="btn btn-danger">Update Training Facility Page</button> &nbsp; &nbsp;
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
    <script src="scripts/jquery-ui.1.11.4.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
    <script src="scripts/common-handler.js" type="text/javascript"></script>
    <script src="scripts/manage-website-training-facility.js" type="text/javascript"></script>
</body>