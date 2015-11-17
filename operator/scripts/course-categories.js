$(document).ready(function(){
    $("form#CreateCategory").submit(function(e){ 
        e.stopPropagation();
        e.preventDefault();
        //var formDatas = $(this).serialize();
        var formDatas = new FormData($(this)[0]);
        var alertType = ["danger", "success", "danger", "error"];
        $.ajax({
            url: $(this).attr("action"),
            type: 'POST',
            data: formDatas,
            cache: false,
            contentType: false,
            async: false,
            success : function(data, status) {
                if(data.status != null && data.status !=1) { 
                    $("#messageBox, .messageBox").html('<div class="alert alert-'+alertType[data.status]+'"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+' </div>');
                }
                else if(data.status != null && data.status == 1) { 
                    $("#messageBox, .messageBox").html('<div class="alert alert-'+alertType[data.status]+'"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'  <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Re-loading...</div>'); setInterval(function(){ window.location = "";}, 2000);
                }
                else $("#messageBox, .messageBox").html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data+'</div>');
                 
            },
            processData: false
        });
        return false;
    });
    
    loadAllCoursesCategories();
    function loadAllCoursesCategories(){
        var dataTable = $('#coursecategorylist').DataTable( {
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                url :"../REST/manage-course-categories.php", //employee-grid-data.php",// json datasource
                type: "post",  // method  , by default get
                data: {fetchCategories:'true'},
                error: function(){  // error handling
                        $("#coursecategorylist-error").html("");
                        $("#coursecategorylist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#coursecategorylist_processing").css("display","none");

                }
            }
        } );
    }
    
    $(document).on('click', '.delete-category', function() {
        if(confirm("Are you sure you want to delete this category? Category Name: '"+$(this).attr('data-name')+"'")) deleteCourseCategory($(this).attr('data-id'),$(this).attr('data-image'));
    });
    $(document).on('click', '.edit-category', function() {
        if(confirm("Are you sure you want to edit this category? Category Name: '"+$(this).attr('data-name')+"'")) editCourseCategory($(this).attr('data-id'), $(this).attr('data-name'), $(this).attr('data-description'), $(this).attr('data-image'));
    });
    
    function deleteCourseCategory(id,image){
        $.ajax({
            url: "../REST/manage-course-categories.php",
            type: 'POST',
            data: {deleteThisCategory: 'true', id:id, image:image},
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
    
    function editCourseCategory(id, name, description, image){//,
        $('form #addNewCategory').val('editCourseCategory');
        $('form #multi-action-catAddEdit').text('Update Category');
        var formVar = {id:id, name:name, description:description, image:image};
        $.each(formVar, function(key, value) { 
            if(key == 'image') { $('form #oldFile').val(value); $('form #oldFileComment').text(value).css('color','red');} 
            $('form #'+key).val(value); 
        });
        
        
        $("form#CreateCategory").submit(function(e){ 
            e.stopPropagation(); 
            e.preventDefault();
            var formDatas = $(this).serialize();
            var alertType = ["danger", "success", "danger", "error"];
            $.ajax({
                url: $(this).attr("action"),
                type: 'POST',
                data: formDatas,
                cache: false,
                success : function(data, status) {
                    if(data.status != null && data.status !=1) { $("#messageBox, .messageBox").html('<div class="alert alert-'+alertType[data.status]+'"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+' </div>'); }
                    else if(data.status != null && data.status == 1) { $("#messageBox, .messageBox").html('<div class="alert alert-'+alertType[data.status]+'"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'  <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Re-loading...</div>'); setInterval(function(){ window.location = "";}, 2000);}
                    else $("#messageBox, .messageBox").html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button> '+data+' </div>');
                },
                error : function(xhr, status) {
                    erroMsg = '';
                    if(xhr.status===0){ erroMsg = 'There is a problem connecting to internet. Please review your internet connection.'; }
                    else if(xhr.status===404){ erroMsg = 'Requested page not found.'; }
                    else if(xhr.status===500){ erroMsg = 'Internal Server Error.';}
                    else if(status==='parsererror'){ erroMsg = 'Error. Parsing JSON Request failed.'; }
                    else if(status==='timeout'){  erroMsg = 'Request Time out.';}
                    else { erroMsg = 'Unknow Error.\n'+xhr.responseText;}          
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Admin details update failed. '+erroMsg+'</div>');
                }
            });
            return false;
        });
    }
});