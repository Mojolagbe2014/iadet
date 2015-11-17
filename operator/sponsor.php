<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sponsors/Partners Manager - AIDET</title>
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
                                    <h3>All Sponsors/Partners</h3>
                                </div>
                                <div class="module-body table">
                                    <table id="sponsorlist" cellpadding="0" cellspacing="0" border="0" class="display"  width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Actions</th>
                                                <th>Sponsor</th>
                                                <th>Official Logo</th>
                                                <th>Website</th>
                                                <th>Date Added</th>
                                                <th>Product/Services</th>
                                                <th>Description</th>
                                                <th>Product Image</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/.module-->
                            <div class="module" id="">
                                <div class="module-head">
                                    <h3 id="multiHeader">Add Sponsor/Partner</h3>
                                </div>
                                
                                <div class="module-body">
                                    <form class="form-horizontal row-fluid" id="CreateSponsor" method="POST" name="CreateSponsor" action="../REST/manage-sponsors.php"  enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label" for="name">Sponsor/Partner Name:</label>
                                            <div class="controls">
                                                <input type="hidden" id="id" name="id"> 
                                                <textarea id="name" name="name" placeholder="Sponsor/Partner Name" class="span8"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="logo">Official Logo:</label>
                                            <div class="controls">
                                                <input type="hidden" name="oldLogo" id="oldLogo" />
                                                <input data-title="" type="file" placeholder="" id="logo" name="logo" class="span8 tip">
                                                <br/><span class="hidden" id="oldLogoLabel">Old Logo:</span> <span id="oldLogoComment"></span>
                                                <div id="oldLogoSource"></div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="website">Website:</label>
                                            <div class="controls">
                                                <input type="url" id="website" name="website" placeholder="E.g http://www.sponsorwebsite.com" class="span8"/>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="product">Product/Services:</label>
                                            <div class="controls">
                                                <input type="text" id="product" name="product" placeholder="Product/Services" class="span8"/>
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
                                            <label class="control-label" for="image">Product Image:</label>
                                            <div class="controls">
                                                <input type="hidden" name="oldImage" id="oldImage" />
                                                <input data-title="" type="file" placeholder="" id="image" name="image" class="span8 tip">
                                                <br/><span class="hidden" id="oldImageLabel">Old Image:</span> <span id="oldImageComment"></span>
                                                <div id="oldImageSource"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="hidden" name="addNewSponsor" id="addNewSponsor" value="addNewSponsor"/>
                                                <button type="submit" class="btn btn-success" id="multi-action-sponsorAddEdit">Add Sponsor</button> &nbsp; &nbsp;
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
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables1.js" type="text/javascript"></script>
        <script src="scripts/common-handler.js" type="text/javascript"></script>
        <script src="scripts/sponsor.js" type="text/javascript"></script>
    </body>
</html>