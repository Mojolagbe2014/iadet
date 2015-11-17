<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage All Assessments - AIDET</title>
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
                                    <h3>All Assessments</h3>
                                </div>
                                <div class="module-body table">
                                    <table id="assessmentslist" cellpadding="0" cellspacing="0" border="0" class="display"  width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Actions</th>
                                                <th>Lesson</th>
                                                <th>Title</th>
                                                <th>Question</th>
                                                <th>Mark</th>
                                                <th>Submission Date</th>
                                                <th>Attachment</th>
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
                                    <h3>Edit Assessment Details</h3>
                                </div>
                                <div class="module-body">
                                    <form class="form-horizontal row-fluid" id="UpdateAssessment" name="UpdateAssessment" action="../REST/manage-assessments.php" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label" for="lesson">Select Lesson:</label>
                                            <div class="controls">
                                                <input type="hidden" name="id" id="id" /> <input type="hidden" id="oldAttachment" name="oldAttachment" />
                                                <select tabindex="1" name="lesson" id="lesson" data-placeholder="Select a parent course/assessment.." class="span8">
                                                    <option value=""> -- Select a lesson -- </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="title">Assessment Title:</label>
                                            <div class="controls">
                                                <input data-title="title" type="text" placeholder="Assessment Title" id="title" name="title" data-original-title="Assessment Title" class="span8 tip">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="question">Question:</label>
                                            <div class="controls">
                                                <textarea class="span5" id="question" name="question" class="span8 tip"></textarea>
                                                <script>
                                                    CKEDITOR.replace('question');
                                                </script>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="submissionDate">Submission Date:</label>
                                            <div class="controls">
                                                <input data-title="Submission Date" type="text" placeholder="YYYY/MM/DD" id="submissionDate" name="submissionDate" data-original-title="Submission DAte" class="span8 tip">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="mark">Mark Obtainable:</label>
                                            <div class="controls">
                                                <input data-title="mark" type="number" placeholder="Mark Obtainable" id="mark" name="mark" data-original-title="mark" class="span8 tip">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="attachment">Attachment:</label>
                                            <div class="controls">
                                                <input data-title="assessment attachment" type="file" placeholder="Assessment attachment" id="attachment" name="attachment" data-original-title="Assessment attachment" class="span8 tip">
                                                <br/><span>Old Attachment: <strong id="oldAttachmentComment"></strong></span>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="hidden" name="updateThisAssessment" id="updateThisAssessment" value="updateThisAssessment"/>
                                                <button type="submit" name="submitUpdateAssessment" id="submitUpdateAssessment" class="btn btn-danger">Update Details</button> &nbsp; &nbsp;
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
        <script src="scripts/manage-assessments.js" type="text/javascript"></script>
    </body>
</html>