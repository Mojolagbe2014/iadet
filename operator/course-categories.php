<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Course Categories - AIDET</title>
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
                                    <h3>All Categories</h3>
                                </div>
                                <div class="module-body table">
                                    <table id="coursecategorylist" cellpadding="0" cellspacing="0" border="0" class="display"  width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Category Name</th>
                                                <th>Brief Description</th>
                                                <th>Category Image</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/.module-->
                            <div class="module" id="">
                                <div class="module-head">
                                    <h3>Add/Edit Category</h3>
                                </div>
                                <div class="messageBox"></div>
                                <div class="module-body">
                                    <form class="form-horizontal row-fluid" id="CreateCategory" name="CreateCategory" action="../REST/manage-course-categories.php"  enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label" for="name">Category Name:</label>
                                            <div class="controls">
                                                <input type="hidden" id="id" name="id"> <input type="hidden" id="oldFile" name="oldFile" value=""/>
                                                <input type="text" id="name" name="name" placeholder="category name" class="span8">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="description">Brief Description:</label>
                                            <div class="controls">
                                                <textarea id="description" name="description" placeholder="category's brief description" class="span8"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="image">Category Image:</label>
                                            <div class="controls">
                                                <input type="file" id="image" name="image"class="span8"/>
                                                <span>Old media: <strong id="oldFileComment"></strong></span>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="hidden" name="addNewCategory" id="addNewCategory" value="addNewCategory"/>
                                                <button type="submit" class="btn btn-success" id="multi-action-catAddEdit">Add Category</button> &nbsp; &nbsp;
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
        <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables1.js" type="text/javascript"></script>
        <script src="scripts/common-handler.js" type="text/javascript"></script>
        <script src="scripts/course-categories.js" type="text/javascript"></script>
    </body>
</html>