<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Purchased Courses Transaction Record - AIDET</title>
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
                                    <h3>All Transactions</h3>
                                </div>
                                <div class="module-body table">
                                    <table id="transactionslist" cellpadding="0" cellspacing="0" border="0" class="display"  width="100%">
                                        <thead>
                                            <tr>
                                                <th>Transaction ID</th>
                                                <th>Buyer Name</th>
                                                <th>Course Purchased</th>
                                                <th>Item Type</th>
                                                <th>Amount</th>
                                                <th>Currency</th>
                                                <th>Method</th>
                                                <th>State</th>
                                                <th>Date Purchased</th>
                                                <th>Payment Mode</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/.module-->
                           <div class="module" id="hiddenUpdateForm">
                                <div class="module-head">
                                    <h3>Log Manual Payment</h3>
                                </div>
                               <div class="messageBox"></div>
                                <div class="module-body">
                                    <form class="form-horizontal row-fluid" id="AddTransaction" name="AddTransaction" action="../REST/add-purchase-course.php" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label" for="transactionId">Teller No/Transaction ID:</label>
                                        <div class="controls">
                                            <input type="hidden" id="method" name="method" value="Manual Log" />
                                            <input type="hidden" id="state" name="state" value="approved" />
                                            <input type="text" id="transactionId" name="transactionId" value="" required="required" class="span8">
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">
                                        <label class="control-label" for="user">Paid By:</label>
                                        <div class="controls">
                                            <select name="user" id="user" required="required" class="span8">
                                                <option value=""> -- Select Payer -- </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="itemType">Payment For:</label>
                                        <div class="controls">
                                            <select name="itemType" id="itemType" required="required" class="span8">
                                                <option value=""> -- Select Course Type -- </option>
                                                <option value="course">Single Course</option>
                                                <option value="category">Course Category</option>
                                                <option value="sub-category">Sub-Category</option>
                                            </select>
                                        </div>
                                        <div class="controls">
                                            <select name="course" id="course" required="required" class="span8">
                                                <option value=""> -- Select Course -- </option>
                                            </select>
                                        </div>
                                    </div>
                       
                                    <div class="control-group">
                                        <label class="control-label" for="amount">Amount:</label>
                                        <div class="controls">
                                            <input type="text" placeholder="Amount Paid" id="amount" name="amount" class="span8 tip" required="required">
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">
                                        <label class="control-label" for="currency">Currency:</label>
                                        <div class="controls">
                                            <input type="text" placeholder="Currency e.g GBP, NGN" id="currency" name="currency" class="span8 tip" required="required">
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">
                                        <label class="control-label" for="mode">Payment Mode:</label>
                                        <div class="controls">
                                            <select name="mode" id="mode" required="required" class="span8">
                                                <option value=""> -- Select Mode -- </option>
                                                <option value="full">Full Payment</option>
                                                <option value="installment">Installment Payment</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="datePurchased">Payment Date/Time:</label>
                                        <div class="controls">
                                            <input type="text" placeholder="Date Purchased" id="datePurchased" name="datePurchased" class="span8 tip" required="required">
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" name="logThisPayment" id="logThisPayment" class="btn btn-danger">Log Payment</button> &nbsp; &nbsp;
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
        
        <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="scripts/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui.1.11.4.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables1.js" type="text/javascript"></script>
        <script src="scripts/common-handler.js" type="text/javascript"></script>
        <script src="scripts/transactions.js" type="text/javascript"></script>
    </body>
</html>