$(document).ready(function(){
    //Date Picker
    $( "#submissionDate" ).datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });
    
    loadAllRegisteredAssessments();
    function loadAllRegisteredAssessments(){
        var dataTable = $('#assessmentslist').DataTable( {
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                url :"../REST/manage-assessments.php", //employee-grid-data.php",// json datasource
                type: "post",  // method  , by default get
                data: {fetchAssessments:'true'},
                error: function(){  // error handling
                        $("#assessmentslist-error").html("");
                        $("#assessmentslist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#assessmentslist_processing").css("display","none");

                }
            }
        } );
        
    }
    var currentStatus;
    
    /** fetchLessons fetches lesson limited by totalNo 
     * @param {int} totalNo Total fetchable items/courses
     * @param {int} offset Offset
     * @param {string} selector The selector/element to append the result to
     */
    function fetchLessons(totalNo, offset, selector){
        $.ajax({
            url: "../REST/fetch-lessons.php",
            type: 'POST',
            cache: false,
            data: {totalNo:totalNo, offset:offset},
            success : function(data, status) {
                $(selector).empty(); 
                if(data.status === 0 ){ 
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Lesson loading error. '+data.msg+'</div>');
                }
                if(data.status === 2 ){ 
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>No lesson available</div>');
                     $(selector).append('<option value=""> -- Select a lesson.. --</option>');
                }
                else if(data.status ===1 && data.info.length > 0){
                    $(selector).append('<option value=""> -- Select a lesson --</option>');
                    $.each(data.info, function(i, item) {
                        $(selector).append('<option value="'+item.id+'">'+item.title+'</option>');
                    });
                } 

            }
        });
    }
    
    //Fetch all tutors
    fetchLessons(1000, 0, '#lesson');
       
    
    $(document).on('click', '.activate-assessment', function() {
        currentStatus = 'Activate'; if(parseInt($(this).attr('data-status')) === 1) currentStatus = "De-activate";
        if(confirm("Are you sure you want to "+currentStatus+" this assessment? Assessment Title: '"+$(this).attr('data-title')+"'")) activateAssessment($(this).attr('data-id'),$(this).attr('data-status'));
    });
    $(document).on('click', '.delete-assessment', function() {
        if(confirm("Are you sure you want to delete this assessment ["+$(this).attr('data-title')+"]? Assessment attachment ['"+$(this).attr('data-attachment')+"'] will be deleted too.")) deleteAssessment($(this).attr('data-id'),$(this).attr('data-attachment'));
    });
    $(document).on('click', '.edit-assessment', function() {
        if(confirm("Are you sure you want to edit this assessment ["+$(this).attr('data-title')+"] details?")) editAssessment($(this).attr('data-id'), $(this).attr('data-lesson'), $(this).attr('data-title'),  $(this).find('span#JQDTquestionholder').html(), $(this).attr('data-submission-date'), $(this).attr('data-mark'), $(this).attr('data-attachment'));
    });
    
    function deleteAssessment(id, attachment){
        $.ajax({
            url: "../REST/manage-assessments.php",
            type: 'POST',
            data: {deleteThisAssessment: 'true', id:id, attachment: attachment},
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
    
    function activateAssessment(id, status){
        $.ajax({
            url: "../REST/manage-assessments.php",
            type: 'GET',
            data: {activateAssessment: 'true', id:id, status:status},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Assessment Successfully '+currentStatus+'d! <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Reloading ...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else if(data.status === 0 || data.status === 2 || data.status === 3 || data.status === 4){
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Assessment Activation Failed. '+data.msg+'</div>');
                }
                else {
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Assessment Activation Failed. '+data+'</div>');
                }
            }
        });
    }
    
    function editAssessment(id, lesson, title, question, submissionDate, mark, attachment){//,
        var formVar = {id:id, lesson:lesson, title:title, question:question, submissionDate:submissionDate, mark:mark, attachment:attachment};
        $.each(formVar, function(key, value) { 
            if(key == 'attachment') { $('form #oldAttachment').val(value); $('form #oldAttachmentComment').text(value).css('color','red');} 
            else $('form #'+key).val(value);  
        });
        $('#hiddenUpdateForm').removeClass('hidden');
        CKEDITOR.instances['question'].setData(question);
        $("form#UpdateAssessment").submit(function(e){ 
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