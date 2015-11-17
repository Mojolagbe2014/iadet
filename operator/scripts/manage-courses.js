$(document).ready(function(){
    $('#name, #amount, #name2, #promotionAmount').val('');
    loadAllRegisteredCourses();
    function loadAllRegisteredCourses(){
        var dataTable = $('#courseslist').DataTable( {
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                url :"../REST/manage-courses.php", //employee-grid-data.php",// json datasource
                type: "post",  // method  , by default get
                data: {fetchCourses:'true'},
                error: function(data, test){  // error handling
                        $("#courseslist-error").html("");
                        $("#courseslist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#courseslist_processing").css("display","none");
                }
            }
        } );
        
    }
    
    $(document).on('click', '.edit-course', function() {
        if(confirm("Are you sure you want to edit this course ["+$(this).attr('data-name')+"] details?")) editCourse($(this).attr('data-name'), $(this).attr('data-amount'), $(this).attr('data-promotion-amount'));
    });
    $(document).on('click', '.delete-course', function() {
        if(confirm("Are you sure you want to DELETE this course ["+$(this).attr('data-name')+"] details?")) deleteCourse($(this).attr('data-name'));
    });
    var currentStatus;
    $(document).on('click', '.activate-course', function() {
        currentStatus = 'Activate Promotional Offer'; if(parseInt($(this).attr('data-status')) == 1) currentStatus = "De-activate promotional offer";
        if(confirm("Are you sure you want to "+currentStatus+" this course? Course Name: '"+$(this).attr('data-name')+"'")) activateCourse($(this).attr('data-name'),$(this).attr('data-status'));
    });
    
    function activateCourse(name, status){
        $.ajax({
            url: "../REST/manage-courses.php",
            type: 'GET',
            data: {activateCourse: 'true', name:name, status:status},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Course Successfully '+currentStatus+'d! <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Reloading ...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else {
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Course Activation Failed. '+data.msg+'</div>');
                }
            }
        });
    }
    
    $("form#UpdateCourse").submit(function(e){ 
        e.stopPropagation(); 
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        var alertType = ["danger", "success", "danger", "error"];
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
        return false;
    });
    
    function editCourse(name, amount, promotionAmount){//,
        $('#updateThisCourse').val('updateThisCourse');
        var formVar = {name:name, amount:amount, name2:name, promotionAmount:promotionAmount};
        $.each(formVar, function(key, value) { 
            $('form #'+key).val(value);  
        });
        $('#name2').attr('disabled');
        $('#submitUpdateCourse').text('Update Course');
    }
    
    function deleteCourse(name){
        $.ajax({
            url: "../REST/manage-courses.php",
            type: 'POST',
            data: {deleteThisCourse: 'true', name:name},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+' <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Re-loading...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else {
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                }
            }
        });
    }
});