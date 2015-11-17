<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Image to Gallery - AIDET</title>
        <link href="media-uploader/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="media-uploader/css/uploader.css" rel="stylesheet" type="text/css"/>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        
        <link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link href="css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
        <style>
            div.dataTables_wrapper {
                width: 800px;
                margin: 0 auto;
            }th, td { white-space: nowrap; }
        </style>
        <script src="../ckeditor/ckeditor.js" type="text/javascript"></script>
        <link href="css/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <link href="media-uploader/css/demo.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include("includes/header.php"); ?>
        
        <div class="wrapper">
            <div class="span3">
                <?php include("includes/side-menu.php"); ?>
            </div>
            <div class="container">
                <div class="row">
                    <div class="span9">
                        <div class="content">
                            <div class="module">
                                <div class="module-head">
                                    <h3>Add New Image to Gallery</h3>
                                </div>
                                <div class="module-body">
                                    <div class="row demo-columns">
                                        <div class="col-md-6">
                                          <!-- D&D Zone-->
                                          <div id="drag-and-drop-zone" class="uploader">
                                            <div>Drag &amp; Drop Images Here</div>
                                            <div class="or">-or-</div>
                                            <div class="browser">
                                              <label>
                                                <span>Click to open the file Browser</span>
                                                <input type="file" name="files[]"  accept="image/*" multiple="multiple" title='Click to add Images'>
                                              </label>
                                            </div>
                                          </div>
                                          <!-- /D&D Zone -->

                                          <!-- Debug box -->
                                          <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <h3 class="panel-title">Status/Result</h3>
                                            </div>
                                            <div class="panel-body demo-panel-debug">
                                              <ul id="demo-debug">
                                              </ul>
                                            </div>
                                          </div>
                                          <!-- /Debug box -->
                                        </div>
                                        <!-- / Left column -->

                                        <div class="col-md-6">
                                          <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <h3 class="panel-title">Uploads</h3>
                                            </div>
                                            <div class="panel-body demo-panel-files" id='demo-files'>
                                              <span class="demo-note">No Files have been selected/dropped yet...</span>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- / Right column -->
                                    </div>
                                </div>
                            </div>
                            <!--/.module-->
                           
                        </div>
                        <!--/.content-->
                    </div>
                    <!--/.span9-->
                </div>
                
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        
        <?php include("includes/footer.php"); ?>
        
        <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui.1.11.4.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables1.js" type="text/javascript"></script>
        <script src="scripts/common-handler.js" type="text/javascript"></script>
        <script src="media-uploader/js/jquery-1.10.1.min.js" type="text/javascript"></script>
        <script src="media-uploader/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
        <script src="media-uploader/js/demo-preview.min.js" type="text/javascript"></script>
        <script src="media-uploader/js/dmuploader.min.js" type="text/javascript"></script>
        <script src="scripts/add-gallery-image.js" type="text/javascript"></script>
    </body>
</html>