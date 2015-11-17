<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Lesson - AIDET</title>
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
                                <h3>Add New Lesson</h3>
                            </div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid" id="CreateLesson" name="CreateLesson" action="../REST/add-lesson.php" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label" for="form">Select Parent Category:</label>
                                        <div class="controls">
                                            <label class="radio">
                                                <input type="radio" name="form" id="form" data-value="course" value="course">
                                                Course
                                            </label> 
                                            <label class="radio">
                                                <input type="radio" name="form" id="form" data-value="lesson" value="lesson">
                                                Lesson
                                            </label> 
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="parent">Select Parent:</label>
                                        <div class="controls">
                                            <select tabindex="1" name="parent" id="parent" data-placeholder="Select a parent course/lesson.." class="span8">
                                                <option value="">Select a parent course/lesson..</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="title">Lesson Title:</label>
                                        <div class="controls">
                                            <input data-title="Lesson Title" type="text" placeholder="Lesson Title" id="title" name="title" data-original-title="Lesson title" class="span8 tip">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="body">Lesson Body:</label>
                                        <div class="controls">
                                            <textarea class="span5" id="body" name="body" class="span8 tip"></textarea>
                                            <script>
                                                CKEDITOR.replace('body');
                                            </script>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="startDate">Start Date:</label>
                                        <div class="controls">
                                            <input data-title="start date" type="text" placeholder="YYYY/MM/DD" id="startDate" name="startDate" data-original-title="Start DAte" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="endDate">End Date:</label>
                                        <div class="controls">
                                            <input data-title="start date" type="text" placeholder="YYYY/MM/DD" id="endDate" name="endDate" data-original-title="End Date" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="material">Lesson Material:</label>
                                        <div class="controls">
                                            <input data-title="lesson material" type="file" placeholder="lesson material" id="material" name="material" data-original-title="Lesson material" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="tutor">Tutor:</label>
                                        <div class="controls">
                                            <select tabindex="1" name="tutor" id="tutor" data-placeholder=" Select a tutor " class="span8">
                                                <option value=""> -- Select a tutor -- </option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="addNewLesson" id="addNewLesson" value="addNewLesson"/>
                                            <button type="submit" name="addLesson" id="addLesson" class="btn btn-danger">Add Lesson</button> &nbsp; &nbsp;
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
    <script src="scripts/add-lesson.js" type="text/javascript"></script>
</body>