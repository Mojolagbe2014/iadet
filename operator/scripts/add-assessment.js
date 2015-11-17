$(document).ready(function(){   
    //Date Picker
    $( "#submissionDate" ).datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });
 
    
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
    
    
    $("form#CreateAssessment").submit(function(e){ 
        e.stopPropagation();
        e.preventDefault();
        //var formData = $(this).serialize();
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
                if(data.status === 1  || data.status === 2 || data.status === 3 || data.status === 0 )  $("#messageBox, .messageBox").html('<div class="alert alert-'+alertType[data.status]+'"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
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
});