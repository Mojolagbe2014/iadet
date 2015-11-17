<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage All Lessons - AIDET</title>
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
            .ui-datepicker-prev { background: url(images/jquery-ui/left.png); cursor: pointer }
            .ui-datepicker-next { background: url(images/jquery-ui/right.png); cursor: pointer}
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
                                    <h3>All Lessons</h3>
                                </div>
                                <div class="module-body table">
                                    <table id="lessonslist" cellpadding="0" cellspacing="0" border="0" class="display"  width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Actions</th>
                                                <th>Lesson Title</th>
                                                <th>Parent Category</th>
                                                <th>Parent</th>
                                                <th>Lesson Body</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Tutor</th>
                                                <th>Material</th>
                                                <th>Date Added</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/.module-->
                            <div class="module hidden" id="hiddenUpdateForm">
                                <div class="module-head">
                                    <h3>Edit Lesson Details</h3>
                                </div>
                                <div class="module-body">
                                    <form class="form-horizontal row-fluid" id="UpdateLesson" name="UpdateLesson" action="../REST/manage-lessons.php" enctype="multipart/form-data">

                                        <div class="control-group">
                                            <label class="control-label" for="title">Lesson Title:</label>
                                            <div class="controls">
                                                <input type="hidden" name="id" id="id" /> <input type="hidden" id="oldMaterial" name="oldMaterial" />
                                                <input data-title="Lesson Title" type="text" placeholder="Lesson Title" id="title" name="title" data-original-title="Lesson title" class="span8 tip">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="body">Lesson Body:</label>
                                            <div class="controls">
                                                <textarea id="body" name="body" class="span8 tip"></textarea>
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
                                                <br/><span>Old Material: <strong id="oldMaterialComment"></strong></span>
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
                                                <input type="hidden" name="updateThisLesson" id="updateThisLesson" value="updateThisLesson"/>
                                                <button type="submit" name="submitUpdateLesson" id="submitUpdateLesson" class="btn btn-danger">Update Details</button> &nbsp; &nbsp;
                                                <button type="button" class="btn btn-info" id="cancelEdit">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="messageBox"></div>
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
        <script src="scripts/manage-lessons.js" type="text/javascript"></script>
    </body>
</html>