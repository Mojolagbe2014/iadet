$(document).ready(function(){
    $("form#CreateFaq").submit(function(e){ 
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
    
    loadAllFaqs();
    function loadAllFaqs(){
        var dataTable = $('#faqlist').DataTable( {
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                url :"../REST/manage-faq.php", 
                type: "post",  
                data: {fetchFaqs:'true'},
                error: function(){  // error handling
                        $("#faqlist-error").html("");
                        $("#faqlist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#faqlist_processing").css("display","none");

                }
            }
        } );
    }
    
    $(document).on('click', '.delete-faq', function() {
        if(confirm("Are you sure you want to delete this faq? ("+$(this).find('span#JQDTquestionholder2').html()+")")) deleteFaq($(this).attr('data-id'));
    });
    $(document).on('click', '.edit-faq', function() {
        if(confirm("Are you sure you want to edit this faq?")) editFaq($(this).attr('data-id'),  $(this).find('span#JQDTquestionholder').html(),  $(this).find('span#JQDTanswerholder').html());
    });
    
    function deleteFaq(id){
        $.ajax({
            url: "../REST/manage-faq.php",
            type: 'POST',
            data: {deleteThisFaq: 'true', id:id},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+' <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Re-loading...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else if(data.status === 0 || data.status === 2 || data.status === 3 || data.status === 4){
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                }
                else {
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data+'</div>');
                }
            }
        });
    }
    
    function editFaq(id, question, answer){//,
        $('form #addNewFaq').val('editFaq');
        $('form #multi-action-faqAddEdit').text('Update Faq');
        $('#multiHeader').html('Edit "<i style="font-weight:normal;">'+question+'</i>"');
        var formVar = {id:id, question:question, answer:answer};
        $.each(formVar, function(key, value) { 
            $('form #'+key).val(value); 
        });
        
        $("form#CreateFaq").submit(function(e){ 
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
                    else if(data.status != null && data.status == 1) { $("#messageBox, .messageBox").html('<div class="alert alert-'+alertType[data.status]+'"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'  <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Re-loading...</div>'); $('#multiHeader').text('Add Frequently Asked Question'); setInterval(function(){ window.location = "";}, 2000);}
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
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+erroMsg+'</div>');
                }
            });
            return false;
        });
    }
});