/**
 * fetchAllUsers fetches users
 * @param {string} id Id of the element to append the result to
 */
function fetchAllUsers(id){
    $.ajax({
        url: "../REST/fetch-users.php",
        cache:false,
        success : function(data, status) { 
            if(data.status === 1){ 
                $('#'+id).empty().append('<option value=""> -- Select Payer -- </option>');
                $.each(data.info, function(i, item){
                    $('#'+id).append('<option value="'+item.id+'">'+item.email+'</option>');
                });
            }  
        } 
    });
}
/**
 * fetchCoursesByType fetches courses using the item type
 * @param {string} itemType course|category
 * @param {string} id Id of the element to append the result to
 */
function fetchCoursesByType(itemType, id){
    var restLink = '';
    switch (itemType){
        case 'course': restLink = '../REST/fetch-courses.php'; break;
        case 'category': restLink = '../REST/fetch-course-categories.php?parent=0'; break;
        case 'sub-category': restLink = '../REST/fetch-course-categories.php?parent=1'; break;
        default: $('#'+id).empty().append('<option value=""> -- Select Course -- </option>');
    }
    $.ajax({
        url: restLink,
        cache:false, data: {totalNo:800},
        success : function(data, status) { 
            if(data.status === 1){ 
                $('#'+id).empty().append('<option value=""> -- Select Course -- </option>');
                $.each(data.info, function(i, item){
                    $('#'+id).append('<option value="'+item.id+'">'+item.name+'</option>');
                });
            }  
        } 
    });
}
$(document).ready(function(){
    //set up date picker
    $('#datePurchased').datetimepicker({cdayOfWeekStart : 1,clang:'en'});
    //Fetch all user
    fetchAllUsers('user');
    //fetch all transactions
    getTransactionRecords();
    function getTransactionRecords(){
        var dataTable = $('#transactionslist').DataTable( {
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            data: {fetchUsers: 'true'},
            "ajax":{
                url :"../REST/transaction.php", 
                type: "POST",  
                data: {fetchTransactions:'true'},
                error: function(){  // error handling
                        $("#transactionslist-error").html("");
                        $("#transactionslist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#transactionslist_processing").css("display","none");

                }
            }
        } );
        
    }
    $(document).on('change', '#itemType', function(){
        fetchCoursesByType($('#itemType').val(), 'course');
    });
    
    //on submit form
    $("form#AddTransaction").submit(function(e){ 
        e.stopPropagation(); 
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        var alertType = ["danger", "success", "danger", "error"];
        if(confirm('Are you sure you want to log this payment record.\nPlease confirm the details and be sure before ckicking [Ok] \nNOTE: Once this payment is added it cannot be editted or deleted.\n Are you sure you want to proceed?')){
            $.ajax({
                url: $(this).attr("action"),
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                async: false,
                success : function(data, status) {
                    if(data.status === 1) {
                        $("#messageBox, .messageBox").html('<div class="alert alert-'+alertType[data.status]+'"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+' <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Reloading ...</div>');
                        setInterval(function(){ window.location = "";}, 2000);
                    }
                    else if(data.status === 2 || data.status === 3 || data.status ===0 ) $("#messageBox, .messageBox").html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                    else $("#messageBox, .messageBox").html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data+'</div>');
                },
                error : function(xhr, status) {
                    erroMsg = '';
                    if(xhr.status===0){ erroMsg = 'There is a problem connecting to internet. Please review your internet connection.'; }
                    else if(xhr.status===404){ erroMsg = 'Requested page not found.'; }
                    else if(xhr.status===500){ erroMsg = 'Internal Server Error.';}
                    else if(status==='parsererror'){ erroMsg = 'Error. Parsing JSON Request failed.'; }
                    else if(status==='timeout'){  erroMsg = 'Request Time out.';}
                    else { erroMsg = 'Unknow Error.\n'+xhr.responseText;}          
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Failed. '+erroMsg+'</div>');
                },
                processData: false
            });
        }
        return false;
    });
});