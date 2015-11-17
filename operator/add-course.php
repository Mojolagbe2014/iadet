<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course - AIDET</title>
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
                                <h3>Add New Course</h3>
                            </div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid" id="CreateCourse" name="CreateCourse" action="../REST/add-course.php" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label" for="name">Full Name:</label>
                                        <div class="controls">
                                            <input type="text" id="name" name="name" placeholder="course full name" class="span8">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="shortName">Short Name:</label>
                                        <div class="controls">
                                            <input data-title="Short Name" type="text" placeholder="short name" id="shortName" name="shortName" data-original-title="Short name" class="span8 tip">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="category">Category:</label>
                                        <div class="controls">
                                            <select tabindex="1" name="category" id="category" data-placeholder="Select a category.." class="span8">
                                                <option value="">Select a category..</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="startDate">Start Date:</label>
                                        <div class="controls">
                                            <input data-title="start date" type="text" placeholder="YYYY/MM/DD" id="startDate" name="startDate" data-original-title="Start DAte" class="span8 tip">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="code">Course Code:</label>
                                        <div class="controls">
                                            <input data-title="course code" type="text" placeholder="course code" id="code" name="code" data-original-title="Course Code" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="description">Description:</label>
                                        <div class="controls">
                                            <textarea class="span5" id="description" name="description" class="span8 tip"></textarea>
                                            <script>
                                                CKEDITOR.replace('description');
                                            </script>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="image">Course Image:</label>
                                        <div class="controls">
                                            <input data-title="course image" type="file" placeholder="course image" id="image" name="image" data-original-title="Course image" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="file">Media:</label>
                                        <div class="controls">
                                            <input data-title="course media" type="file" placeholder="course media" id="file" name="file" data-original-title="Course media" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="amount">Price ($):</label>
                                        <div class="controls">
                                            <input data-title="course amount" type="number" placeholder="course amount" id="amount" name="amount" data-original-title="Course amount" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="addNewCourse" id="addNewCourse" value="addNewCourse"/>
                                            <button type="submit" name="addCourse" id="addCourse" class="btn btn-danger">Add Course</button> &nbsp; &nbsp;
                                            <button type="reset" class="btn btn-info">Reset Form</button>
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
    <script src="scripts/add-course.js" type="text/javascript"></script>
</body>