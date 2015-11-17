$(document).ready(function(){

    loadAllRegisteredUsers();
    function loadAllRegisteredUsers(){
        var dataTable = $('#userslist').DataTable( {
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            data: {fetchUsers: 'true'},
            "ajax":{
                url :"../REST/manage-users.php", 
                type: "post",  
                data: {fetchUsers:'true'},
                error: function(){  // error handling
                        $("#userslist-error").html("");
                        $("#userslist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#userslist_processing").css("display","none");

                }
            }
        } );
        
    }
    var currentStatus;
    
    $(document).on('click', '.activate-user', function() {
        currentStatus = 'Activate'; if(parseInt($(this).attr('data-status')) == 1) currentStatus = "De-activate";
        if(confirm("Are you sure you want to "+currentStatus+" this user? User Name: '"+$(this).attr('data-name')+"'")) activateUser($(this).attr('data-id'),$(this).attr('data-status'));
    });
    $(document).on('click', '.delete-user', function() {
        if(confirm("Are you sure you want to delete this user ["+$(this).attr('data-name')+"]? User picture ['"+$(this).attr('data-picture')+"'] will be deleted too.")) deleteUser($(this).attr('data-id'),$(this).attr('data-picture'));
    });
    $(document).on('click', '.edit-user', function() {
        if(confirm("Are you sure you want to edit this user ["+$(this).attr('data-name')+"] details?")) editUser($(this).attr('data-id'), $(this).attr('data-name'), $(this).attr('data-short-name'), $(this).attr('data-category'), $(this).attr('data-start-date'), $(this).attr('data-code'), $(this).attr('data-description'), $(this).attr('data-media'), $(this).attr('data-amount'));
    });
    
    function deleteUser(id, picture){
        $.ajax({
            url: "../REST/manage-users.php",
            type: 'POST',
            data: {deleteThisUser: 'true', id:id, picture: picture},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+' <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Re-loading...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else {
                    $("#messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                }
            }
        });
    }
    
    function activateUser(id, status){
        $.ajax({
            url: "../REST/manage-users.php",
            type: 'GET',
            data: {activateUser: 'true', id:id, status:status},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>User Successfully '+currentStatus+'d! <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Reloading ...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else {
                    $("#messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>User Activation Failed. '+data.msg+'</div>');
                }
            }
        });
    }
    
    function editUser(id, name, shortName, category, startDate, code, description, media, amount){//,
        var formVar = {id:id, name:name, shortName:shortName, category:category, startDate:startDate, code:code, description:description, media:media, amount:amount };
        $.each(formVar, function(key, value) { 
            if(key == 'media') { $('form #oldFile').val(value); $('form #oldFileComment').text(value).css('color','red');} 
            else $('form #'+key).val(value);  
        });
        $('#hiddenUpdateForm').removeClass('hidden');
        CKEDITOR.instances['description'].setData(description);
        $("form#UpdateUser").submit(function(e){ 
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
                $("#hiddenUpdateForm").addClass('hidden');
                if(data.status === 1) {
                    $("#messageBox").html('<div class="alert alert-'+alertType[data.status]+'"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+' <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Reloading ...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else if(data.status === 2 || data.status === 3 || data.status ===0 ) $("#messageBox").html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                else $("#messageBox").html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
            },
            error : function(xhr, status) {
                erroMsg = '';
                if(xhr.status===0){ erroMsg = 'There is a problem connecting to internet. Please review your internet connection.'; }
                else if(xhr.status===404){ erroMsg = 'Requested page not found.'; }
                else if(xhr.status===500){ erroMsg = 'Internal Server Error.';}
                else if(status==='parsererror'){ erroMsg = 'Error. Parsing JSON Request failed.'; }
                else if(status==='timeout'){  erroMsg = 'Request Time out.';}
                else { erroMsg = 'Unknow Error.\n'+xhr.responseText;}          
                $("#messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Failed. '+erroMsg+'</div>');
            },
            processData: false
        });
            return false;
        });
        $('#cancelEdit').click(function(){ $("#hiddenUpdateForm").addClass('hidden'); });
    }
});