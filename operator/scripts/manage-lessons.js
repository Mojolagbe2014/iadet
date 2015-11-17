$(document).ready(function(){
    //Date Picker
    $( "#startDate" ).datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });
    $( "#endDate" ).datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });
    
    loadAllRegisteredLessons();
    function loadAllRegisteredLessons(){
        var dataTable = $('#lessonslist').DataTable( {
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                url :"../REST/manage-lessons.php", //employee-grid-data.php",// json datasource
                type: "post",  // method  , by default get
                data: {fetchLessons:'true'},
                error: function(){  // error handling
                        $("#lessonslist-error").html("");
                        $("#lessonslist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#lessonslist_processing").css("display","none");

                }
            }
        } );
        
    }
    var currentStatus;
    
    /** fetchTutors fetches course limited by totalNo 
     * @param {int} totalNo Total fetchable items/courses
     * @param {int} offset Offset
     * @param {string} selector The selector/element to append the result to
     */
    function fetchTutors(totalNo, offset, selector){
        $.ajax({
            url: "../REST/fetch-tutors.php",
            type: 'POST',
            cache: false,
            data: {totalNo:totalNo, offset:offset},
            success : function(data, status) {
                $(selector).empty();
                if(data.status === 0 ){ 
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Tutor loading error. '+data.msg+'</div>');
                }
                if(data.status === 2 ){ 
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>No tutor available</div>');
                     $(selector).append('<option value=""> -- Select a tutor --</option>');
                }
                else if(data.status ===1 && data.info.length > 0){
                    $(selector).append('<option value=""> -- Select a tutor. --</option>');
                    $.each(data.info, function(i, item) {
                        $(selector).append('<option value="'+item.id+'">'+item.name+'</option>');
                    });
                } 

            }
        });
    }
    
    //Fetch all tutors
    fetchTutors(1000, 0, '#tutor');
       
    
    $(document).on('click', '.activate-lesson', function() {
        currentStatus = 'Activate'; if(parseInt($(this).attr('data-status')) === 1) currentStatus = "De-activate";
        if(confirm("Are you sure you want to "+currentStatus+" this lesson? Lesson Title: '"+$(this).attr('data-title')+"'")) activateLesson($(this).attr('data-id'),$(this).attr('data-status'));
    });
    $(document).on('click', '.delete-lesson', function() {
        if(confirm("Are you sure you want to delete this lesson ["+$(this).attr('data-title')+"]? Lesson material ['"+$(this).attr('data-material')+"'] will be deleted too.")) deleteLesson($(this).attr('data-id'),$(this).attr('data-material'));
    });
    $(document).on('click', '.edit-lesson', function() {
        if(confirm("Are you sure you want to edit this lesson ["+$(this).attr('data-title')+"] details?")) editLesson($(this).attr('data-id'), $(this).attr('data-title'),  $(this).find('span#JQDTbodyholder').html(), $(this).attr('data-start-date'), $(this).attr('data-end-date'), $(this).attr('data-material'), $(this).attr('data-tutor'));
    });
    
    function deleteLesson(id, material){
        $.ajax({
            url: "../REST/manage-lessons.php",
            type: 'POST',
            data: {deleteThisLesson: 'true', id:id, material: material},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+' <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Re-loading...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else if(data.status === 0 || data.status === 2 || data.status === 3 || data.status === 4){
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                }
            }
        });
    }
    
    function activateLesson(id, status){
        $.ajax({
            url: "../REST/manage-lessons.php",
            type: 'GET',
            data: {activateLesson: 'true', id:id, status:status},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Lesson Successfully '+currentStatus+'d! <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Reloading ...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else if(data.status === 0 || data.status === 2 || data.status === 3 || data.status === 4){
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Lesson Activation Failed. '+data.msg+'</div>');
                }
                else {
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Lesson Activation Failed. '+data+'</div>');
                }
            }
        });
    }
    
    function editLesson(id, title, body, startDate, endDate, material, tutor){//,
        var formVar = {id:id, title:title, body:body, startDate:startDate, endDate:endDate, material:material, tutor:tutor};
        $.each(formVar, function(key, value) { 
            if(key == 'material') { $('form #oldMaterial').val(value); $('form #oldMaterialComment').text(value).css('color','red');} 
            else $('form #'+key).val(value);  
        });
        $('#hiddenUpdateForm').removeClass('hidden');
        CKEDITOR.instances['body'].setData(body);
        $("form#UpdateLesson").submit(function(e){ 
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
                    $("#messageBox, .messageBox").html('<div class="alert alert-'+alertType[data.status]+'"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+' <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Reloading ...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else if(data.status === 2 || data.status === 3 || data.status ===0 ) $("#messageBox").html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
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
        $('#cancelEdit').click(function(){ $("#hiddenUpdateForm").addClass('hidden'); });
    }
});