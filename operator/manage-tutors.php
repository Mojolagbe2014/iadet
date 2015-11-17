<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage All Tutors - AIDET</title>
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
                                    <h3>All Members</h3>
                                </div>
                                <div class="module-body table">
                                    <table id="tutorslist" cellpadding="0" cellspacing="0" border="0" class="display"  width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Actions</th>
                                                <th>Picture</th>
                                                <th>Member Name</th>
                                                <th>Qualification</th>
                                                <th>Area of Specialization</th>
                                                <th>Bio</th>
                                                <th>Email</th>
                                                <th>Username</th>
                                                <th>Website</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/.module-->
                            <div class="module hidden" id="hiddenUpdateForm">
                                <div class="module-head">
                                    <h3>Edit Member Details</h3>
                                </div>
                                <div class="module-body">
                                    <form class="form-horizontal row-fluid" id="UpdateTutor" name="UpdateTutor" action="../REST/manage-tutors.php" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label" for="name">Full Name:</label>
                                            <div class="controls">
                                                <input type="hidden" id="id" name="id" value=""/> <input type="hidden" id="oldPicture" name="oldPicture" value=""/>
                                                <input type="text" id="name" name="name" placeholder="Member full name" class="span8">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="qualification">Qualifications:</label>
                                            <div class="controls">
                                                <input data-title="Qualification" type="text" placeholder="Qualifications" id="qualification" name="qualification" data-original-title="Qualification" class="span8 tip">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="field">Specialization:</label>
                                            <div class="controls">
                                                <textarea class="span5" id="field" name="field" class="span8 tip"></textarea>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="bio">Bio:</label>
                                            <div class="controls">
                                                <textarea class="span5" id="bio" name="bio" class="span8 tip"></textarea>
                                                <script>
                                                    CKEDITOR.replace('bio');
                                                </script>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="picture">Picture:</label>
                                            <div class="controls">
                                                <input data-title="tutor picture" type="file" placeholder="member picture" id="picture" name="picture" data-original-title="Tutor picture" class="span8 tip">
                                                <br/><span>Old Picture: <strong id="oldPictureComment"></strong></span>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="email">Email:</label>
                                            <div class="controls">
                                                <input data-title="tutor's email" type="email" placeholder="member's email" id="email" name="email" data-original-title="Tutor's email" class="span8 tip">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="username">Username:</label>
                                            <div class="controls">
                                                <input data-title="username" type="text" placeholder="username" id="userName" name="userName" data-original-title="username" class="span8 tip">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="website">Website:</label>
                                            <div class="controls">
                                                <input data-title="website" type="url" placeholder="website" id="website" name="website" data-original-title="website" class="span8 tip">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="hidden" name="updateThisTutor" id="updateThisTutor" value="updateThisTutor"/>
                                                <button type="submit" name="submitUpdateTutor" id="submitUpdateTutor" class="btn btn-danger">Update Details</button> &nbsp; &nbsp;
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
        <script src="scripts/manage-tutors.js" type="text/javascript"></script>
    </body>
</html>