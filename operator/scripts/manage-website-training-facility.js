$(document).ready(function(){
    $('form#ManageWebsiteTrainingFacility input, form#ManageWebsiteTrainingFacility textarea').attr('disabled', 'disabled');
    $('form#ManageWebsiteTrainingFacility #updateContent').attr('disabled', 'disabled');
    $('#cancelEdit').text('Edit Details');
    
    $.ajax({
        url: "../REST/manage-website-training-facility.php",
        type: 'POST',
        cache: false,
        data: {fetchWebsiteTrainingFacility: 'true'},
        success : function(data, status) {
            if(data.status === 0 || data.status === 2 || data.status === 3 ){ 
                $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
            }
            else if(data.status === 1){
                var formVar;
                $.each(data.info, function(i, item) { 
                    formVar = {id:item.id, title:item.title, description:item.description, keywords:item.keywords, topBackGround:item.topBackGround, topHeader:item.topHeader, topText:item.topText};
                    $.each(formVar, function(key, value) { 
                        if(key == 'topBackGround') { $('form #oldTopBackGround').val(value); $('form #oldTopBackGroundSource').html('<img src="../media/web-page/training-facility/'+value+'" width="320" height="240" />'); $('form #oldTopBackGroundComment').text(value).css('color','red');} 
                        else $('form #'+key).val(value);  
                    });
                });
                
            } 
            else{ 
                $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data+'</div>');
            }

        }
    });
    $('#cancelEdit').click(function(){ 
        if($(this).text() == 'Edit Details'){
            $(this).text('Cancel');
            $('form#ManageWebsiteTrainingFacility #updateContent').removeProp('disabled', 'disabled');
            $('form#ManageWebsiteTrainingFacility input, form#ManageWebsiteTrainingFacility textarea').removeProp('disabled');  
        }
        else{
            $(this).text('Edit Details');
            $('form#ManageWebsiteTrainingFacilityt input, form#ManageWebsiteTrainingFacility textarea').attr('disabled', 'disabled');  
            $('form#ManageWebsiteTrainingFacility #updateContent').attr('disabled', 'disabled');
        }
    });
    
    $("form#ManageWebsiteTrainingFacility").submit(function(e){ 
        e.stopPropagation(); //alert($('form#ManageWebsiteTrainingFacility #bottomH2').text());
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
});