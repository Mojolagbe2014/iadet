<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Main Website Contact Page - AIDET</title>
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
                                <h3> Page Manager: Contact</h3>
                            </div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid" id="ManageWebsiteContact" name="ManageWebsiteContact" action="../REST/manage-website-contact.php" enctype="multipart/form-data">
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="title">Page Title:</label>
                                        <div class="controls">
                                            <input type="hidden" id="id" name="id" />
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
                                        <label class="control-label" for="phone">Contact Phone Number:</label>
                                        <div class="controls">
                                            <input data-title="" type="text" placeholder="Contact Phone Number" id="phone" name="phone" data-original-title="" class="span8 tip">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="email">Contact Email:</label>
                                        <div class="controls">
                                            <input data-title="" type="email" placeholder="Contact Email" id="email" name="email" data-original-title="email" class="span8 tip">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="address">Contact Address:</label>
                                        <div class="controls">
                                            <input data-title="" type="text" placeholder="Contact Address" id="address" name="address" data-original-title="" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="updateThisContact" id="updateThisContact" value="updateThisContact"/>
                                            <button type="submit" name="updateContent" id="updateContent" class="btn btn-danger">Update Contact Page</button> &nbsp; &nbsp;
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
    <script src="scripts/manage-website-contact.js" type="text/javascript"></script>
</body>