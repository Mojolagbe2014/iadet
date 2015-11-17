$(document).ready(function(){
    $('#name, #amount, #name2, #promotionAmount').val('');
    loadAllRegisteredCategories();
    function loadAllRegisteredCategories(){
        var dataTable = $('#categorieslist').DataTable( {
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                url :"../REST/manage-categories.php", //employee-grid-data.php",// json datasource
                type: "post",  // method  , by default get
                data: {fetchCategories:'true'},
                error: function(data, test){  // error handling
                        $("#categorieslist-error").html("");
                        $("#categorieslist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#categorieslist_processing").css("display","none");
                }
            }
        } );
        
    }
    
    $(document).on('click', '.edit-category', function() {
        if(confirm("Are you sure you want to edit this category ["+$(this).attr('data-name')+"] details?")) editCategory($(this).attr('data-name'), $(this).attr('data-amount'), $(this).attr('data-promotion-amount'), $(this).attr('data-image'), $(this).attr('data-first-installment'), $(this).attr('data-other-installment'));
    });
    $(document).on('click', '.delete-category', function() {
        if(confirm("Are you sure you want to DELETE this category ["+$(this).attr('data-name')+"] details?")) deleteCategory($(this).attr('data-name'), $(this).attr('data-image'));
    });
    var currentStatus, installmentStatus;
    $(document).on('click', '.activate-category', function() {
        currentStatus = 'Activate Promotional Offer'; if(parseInt($(this).attr('data-status')) == 1) currentStatus = "De-activate promotional offer";
        if(confirm("Are you sure you want to "+currentStatus+" this category? Category Name: '"+$(this).attr('data-name')+"'")) activateCategory($(this).attr('data-name'),$(this).attr('data-status'));
    });
    $(document).on('click', '.activate-installment', function() {
        installmentStatus = 'Activate Installment Payment'; if(parseInt($(this).attr('data-installment')) == 1) installmentStatus = "De-activate Installment Payment";
        if(confirm("Are you sure you want to "+installmentStatus+" for this category ["+$(this).attr('data-name')+"]?")) activateInstallment($(this).attr('data-name'), $(this).attr('data-installment'));
    });
    
    function activateCategory(name, status){
        $.ajax({
            url: "../REST/manage-categories.php",
            type: 'GET',
            data: {activateCategory: 'true', name:name, status:status},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Done, Successfully '+currentStatus+'! <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Reloading ...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else if(data.status != 1 && data.status != null) {
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Category Activation Failed. '+data.msg+'</div>');
                } else{
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Category Activation Failed. '+data+'</div>');
                }
            }
        });
    }
    
    function activateInstallment(name, installment){
        $.ajax({
            url: "../REST/manage-categories.php",
            type: 'GET',
            data: {activateInstallment: 'true', name:name, installment:installment},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Done, Successfully '+installmentStatus+'! <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Reloading ...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else if(data.status != 1 && data.status != null) {
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>ERROR: '+data.msg+'</div>');
                } else{
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>ERROR: '+data+'</div>');
                }
            }
        });
    }
    
    $("form#UpdateCategory").submit(function(e){ 
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
    
    function editCategory(name, amount, promotionAmount, image, firstInstallment, otherInstallment){//,
        $('#updateThisCategory').val('updateThisCategory');
        var formVar = {name:name, amount:amount, name2:name, promotionAmount:promotionAmount, image:image, firstInstallment:firstInstallment, otherInstallment:otherInstallment };
        $.each(formVar, function(key, value) { 
            if(key == 'image') { $('form #oldImage').val(value); $('form #oldImageComment').text(value).css('color','red');} 
            else $('form #'+key).val(value);  
        });
        $('#name2').attr('disabled');
        $('#submitUpdateCategory').text('Update Category');
    }
    
    function deleteCategory(name, image){
        $.ajax({
            url: "../REST/manage-categories.php",
            type: 'POST',
            data: {deleteThisCategory: 'true', name:name, image:image},
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