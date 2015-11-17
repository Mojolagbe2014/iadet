<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage All Course Categories - AIDET</title>
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
                                    <h3>All Registered Course Categories</h3>
                                </div>
                                <div class="module-body table">
                                    <table id="categorieslist" cellpadding="0" cellspacing="0" border="0" class="display"  width="100%">
                                        <thead>
                                            <tr>
                                                <th>Category Name</th>
                                                <th>Image Preview</th>
                                                <th>Amount (&pound;)</th>
                                                <th>Promotional Amount (&pound;)</th>
                                                <th>First Installment (&pound;)</th>
                                                <th>Other Installments (&pound;)</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/.module-->
                            <div class="module" id="hiddenUpdateForm">
                                <div class="module-head">
                                    <h3>Add/Edit Category Details</h3>
                                </div>
                                <div class="module-body">
                                    <form class="form-horizontal row-fluid" id="UpdateCategory" name="UpdateCategory" action="../REST/manage-categories.php" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label" for="name">Category Name:</label>
                                        <div class="controls">
                                            <input type="hidden" id="name" name="name" value="">
                                            <input type="text" name="name2" id="name2" class="span8" placeholder="category name">
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">
                                        <label class="control-label" for="image">Category Image:</label>
                                        <div class="controls">
                                            <input name="oldImage" id="oldImage" type="hidden" value="" />
                                            <input type="file" id="image" name="image"class="span8"/>
                                            <span><strong id="oldImageComment"></strong></span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="amount">Price (&pound;):</label>
                                        <div class="controls">
                                            <input data-title="category amount" type="text" placeholder="category amount" id="amount" name="amount" data-original-title="Category amount" class="span8 tip">
                                        </div>
                                    </div>
                       
                                    <div class="control-group">
                                        <label class="control-label" for="promotionAmount">Promotional Price (&pound;):</label>
                                        <div class="controls">
                                            <input data-title="promotional amount" type="text" placeholder="promotional amount" id="promotionAmount" name="promotionAmount" class="span8 tip">
                                        </div>
                                    </div>
                                        <p style="text-align:center; margin-top: 15px; color:red;"> <em>The fields below are required for installment plans</em></p>
                                    <div class="control-group">
                                        <label class="control-label" for="firstInstallment">First Installment (&pound;):</label>
                                        <div class="controls">
                                            <input type="text" placeholder="First Installment" id="firstInstallment" name="firstInstallment" class="span8 tip">
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">
                                        <label class="control-label" for="otherInstallment">Second Installments (&pound;):</label>
                                        <div class="controls">
                                            <input type="text" placeholder="Other Installments" id="otherInstallment" name="otherInstallment" class="span8 tip">
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="updateThisCategory" id="updateThisCategory" value="addCategory"/>
                                            <button type="submit" name="submitUpdateCategory" id="submitUpdateCategory" class="btn btn-danger">Add Category</button> &nbsp; &nbsp;
                                            <button type="reset" class="btn btn-info" id="cancelEdit">Cancel</button>
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
        
<!--        <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>-->
        <script src="scripts/jtree/lib/jquery.js" type="text/javascript"></script>
<!--        <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>-->
        <script src="scripts/jquery-ui.1.11.4.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables1.js" type="text/javascript"></script>
        <script src="scripts/common-handler.js" type="text/javascript"></script>
        <script src="scripts/manage-categories.js" type="text/javascript"></script>
    </body>
</html>