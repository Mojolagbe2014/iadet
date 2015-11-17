<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - AIDET</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
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
                                <h3>Admin Profile [Editable]</h3>
                            </div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid" id="UpdateProfile" name="UpdateProfile" action="../REST/update-admin.php">
                                    <div class="control-group">
                                        <label class="control-label" for="name">Full Name:</label>
                                        <div class="controls">
                                            <input type="hidden" id="id" name="id" value=""/>
                                            <input type="text" id="name" name="name" placeholder="admin full name" class="span8">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="email">Email Address:</label>
                                        <div class="controls">
                                            <input data-title="Email Address" type="email" placeholder="email address" id="email" name="email" data-original-title="Email Address" class="span8 tip">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="role">Admin Role:</label>
                                        <div class="controls">
                                            <select tabindex="1" name="role" id="role" data-placeholder="Select a role.." class="span8">
                                                <option value="">Select a role..</option>
                                                <option value="Sub-Admin">Sub-Admin</option>
                                                <option value="Admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="userName">Username:</label>
                                        <div class="controls">
                                            <input data-title="username.." type="text" placeholder="username.." id="userName" name="userName" data-original-title="Username" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="updateThisAdmin" id="updateThisAdmin" value="updateThisAdmin"/>
                                            <button type="submit" class="btn btn-danger" id="mainUpdateButton">Update Profile</button> &nbsp; &nbsp;
                                            <button type="button" class="btn btn-info" id="cancelProfileUpdate">Cancel</button>
                                            <button type="button" class="btn btn-info" id="enableProfileUpdate">Edit Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="module">
                            <div class="module-head">
                                <h3>Change Password</h3>
                            </div>
                            <div class="messageBox"></div>
                            <div class="module-body">
                                <form class="form-horizontal row-fluid" id="changeAdminPassword" name="changeAdminPassword" action="../REST/change-admin-password.php">
                                    <div class="control-group">
                                        <label class="control-label" for="oldPassword">Old Password:</label>
                                        <div class="controls">
                                            <input type="text" placeholder="old password.." id="oldPassword" name="oldPassword" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="newPassword">New Password:</label>
                                        <div class="controls">
                                            <input type="password" placeholder="new password.." id="newPassword" name="newPassword" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="confirmPassword">Confirm New Password:</label>
                                        <div class="controls">
                                            <input type="password" placeholder="confirm password.." id="confirmPassword" name="confirmPassword" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="changeThisPassword" id="changeThisPassword" value="changeThisPassword"/>
                                            <button type="submit" class="btn btn-danger">Change Password</button> &nbsp; &nbsp;
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--/.content-->
                </div><!--/.span9-->
            </div>
        </div><!--/.container-->
    </div><!--/.wrapper-->

    <?php include("includes/footer.php"); ?>

    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
    <script src="scripts/common-handler.js" type="text/javascript"></script>
    <script src="scripts/profile.js" type="text/javascript"></script>
</body>