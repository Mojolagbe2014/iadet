<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upcoming Events Manager - AIDET</title>
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
        <link href="css/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
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
                                    <h3>All Events</h3>
                                </div>
                                <div class="module-body table">
                                    <table id="eventlist" cellpadding="0" cellspacing="0" border="0" class="display"  width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Actions</th>
                                                <th>Event</th>
                                                <th>Image</th>
                                                <th>Description</th>
                                                <th>Date/Time</th>
                                                <th>Location</th>
                                                <th>Date Added</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/.module-->
                            <div class="module" id="">
                                <div class="module-head">
                                    <h3 id="multiHeader">Add Upcoming Event</h3>
                                </div>
                                
                                <div class="module-body">
                                    <form class="form-horizontal row-fluid" method="POST" id="CreateEvent" name="CreateEvent" action="../REST/manage-events.php"  enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label" for="name">Event Name:</label>
                                            <div class="controls">
                                                <input type="hidden" id="id" name="id"> 
                                                <textarea id="name" name="name" placeholder="Event/Partner Name" class="span8"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="image">Event Image:</label>
                                            <div class="controls">
                                                <input type="hidden" name="oldImage" id="oldImage" />
                                                <input data-title="" type="file" placeholder="" id="image" name="image" class="span8 tip">
                                                <br/><span id="oldImageComment"></span>
                                                <div id="oldImageSource"></div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="location">Location/Venue:</label>
                                            <div class="controls">
                                                <input type="text" id="location" name="location" placeholder="Event venue and/or location" class="span8"/>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="description">Description:</label>
                                            <div class="controls">
                                                <textarea id="description" name="description" class="span8"></textarea>
                                                <script> CKEDITOR.replace('description');</script>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="dateTime">Event Date/Time:</label>
                                            <div class="controls">
                                                <input type="text" id="dateTime" name="dateTime" placeholder="Date and Time" class="span8"/>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="hidden" name="addNewEvent" id="addNewEvent" value="addNewEvent"/>
                                                <button type="submit" class="btn btn-success" id="multi-action-eventAddEdit">Add Event</button> &nbsp; &nbsp;
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
        <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="scripts/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables1.js" type="text/javascript"></script>
        <script src="scripts/common-handler.js" type="text/javascript"></script>
        <script src="scripts/event.js" type="text/javascript"></script>
    </body>
</html>