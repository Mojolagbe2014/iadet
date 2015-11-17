<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>All Courses Tree - AIDET</title>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link href="css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
        <link href="scripts/jtree/src/skin-win8-n/ui.fancytree.css" rel="stylesheet" type="text/css"/>
        <link href="scripts/jtree/lib/prettify.css" rel="stylesheet" type="text/css"/>
        <link href="scripts/jtree/sample.css" rel="stylesheet" type="text/css"/>
        <style>
            div.dataTables_wrapper {
                width: 800px;
                margin: 0 auto;
            }th, td { white-space: nowrap; }
            span.fancytree-icon { position: relative; } span.fancytree-childcounter {color: #fff; background: #428BCA; border: 1px solid gray; position: absolute;top: -6px;right: -6px;min-width: 10px;height: 10px; line-height: 1;vertical-align: baseline;border-radius: 10px; /*50%;*/padding: 2px; text-align: center; font-size: 9px;}
            span.fancytree-node.category span.fancytree-icon {
		background-position: 0 0;
		background-image: url("scripts/jtree/skin-custom/folder_docs.gif");
            }
            span.fancytree-node.lesson span.fancytree-icon {
                    background-position: 0 0;
                    background-image: url("scripts/jtree/skin-custom/page_white_lightning.png");
            }
        </style>
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
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                        <div class="content">
                            <div class="module">
                                <div class="module-head">
                                    <h3>All Courses &nbsp; [Category > Course > Lesson > Assessment]</h3>
                                </div>
                                <div class="module-body">
                                    <div>
                                        <label for="skinswitcher">Skin:</label> <select class="" id="skinswitcher"></select>
                                    </div>
                                    <!-- Add a <table> element where the tree should appear: -->
                                    <div id="tree"> </div>
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
        
        <script src="../js/jquery-1.11.3.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui.1.11.4.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/common-handler.js" type="text/javascript"></script>
        <script src="scripts/view-courses-tree.js" type="text/javascript"></script>
        
        <script src="scripts/jtree/src/jquery.fancytree.js" type="text/javascript"></script>
        <script src="scripts/jtree/src/jquery.fancytree.childcounter.js" type="text/javascript"></script>
        <script src="scripts/jtree/lib/prettify.js" type="text/javascript"></script>
        <script src="scripts/jtree/sample.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function(){ 
                $("#tree").fancytree({ extensions: ["childcounter"], checkbox: true, source: { url: "../REST/fetch-courses-tree.php" }, childcounter: { deep: true, hideZeros: true, hideExpanded: true } });
            });
        </script>
    </body>
</html>