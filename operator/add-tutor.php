<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Member - AIDET</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    <script src="../ckeditor/ckeditor.js" type="text/javascript"></script>
    <link href="css/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <style>
        .ui-datepicker-prev { background: url(images/jquery-ui/left.png); cursor: pointer }
        .ui-datepicker-next { background: url(images/jquery-ui/right.png); cursor: pointer}
    </style>
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
                                <h3>Add New Member</h3>
                            </div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid" id="CreateTutor" name="CreateTutor" action="../REST/add-tutor.php" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label" for="name">Full Name:</label>
                                        <div class="controls">
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
                                            <input data-title="tutor picture" type="file" placeholder="tutor picture" id="picture" name="picture" data-original-title="Tutor picture" class="span8 tip">
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
                                        <label class="control-label" for="passWord">Password:</label>
                                        <div class="controls">
                                            <input data-title="password" type="password" placeholder="password" id="passWord" name="passWord" data-original-title="password" class="span8 tip">
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
                                            <input type="hidden" name="addNewTutor" id="addNewTutor" value="addNewTutor"/>
                                            <button type="submit" name="addTutor" id="addTutor" class="btn btn-danger">Add Member</button> &nbsp; &nbsp;
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
    <script src="scripts/add-tutor.js" type="text/javascript"></script>
</body>