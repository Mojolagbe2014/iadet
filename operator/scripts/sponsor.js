$(document).ready(function(){
    $("form#CreateSponsor").submit(function(e){ 
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
    
    loadAllSponsors();
    function loadAllSponsors(){
        var dataTable = $('#sponsorlist').DataTable( {
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                url :"../REST/manage-sponsors.php", 
                type: "post",  
                data: {fetchSponsors:'true'},
                error: function(){  // error handling
                        $("#sponsorlist-error").html("");
                        $("#sponsorlist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#sponsorlist_processing").css("display","none");

                }
            }
        } );
    }
    
    var currentStatus ="";
    
    $(document).on('click', '.activate-sponsor', function() {
        currentStatus = 'Activate'; if(parseInt($(this).attr('data-status')) === 1) currentStatus = "De-activate";
        if(confirm("Are you sure you want to "+currentStatus+" this sponsor? Sponsor Name: '"+$(this).attr('data-name')+"'")) activateSponsor($(this).attr('data-id'),$(this).attr('data-status'));
    });
    $(document).on('click', '.delete-sponsor', function() {
        if(confirm("Are you sure you want to delete this sponsor? ("+$(this).attr('data-name')+")")) deleteSponsor($(this).attr('data-id'), $(this).attr('data-logo'), $(this).attr('data-image'));
    });
    $(document).on('click', '.edit-sponsor', function() {
        if(confirm("Are you sure you want to edit this sponsor?")) editSponsor($(this).attr('data-id'), $(this).attr('data-name'), $(this).attr('data-logo'), $(this).attr('data-website'), $(this).attr('data-product'), $(this).find('span#JQDTdescriptionholder').html(), $(this).attr('data-image'));
    });
    
    function activateSponsor(id, status){
        $.ajax({
            url: "../REST/manage-sponsors.php",
            type: 'GET',
            data: {activateSponsor: 'true', id:id, status:status},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Sponsor Successfully '+currentStatus+'d! <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Reloading ...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else if(data.status === 0 || data.status === 2 || data.status === 3 || data.status === 4){
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Sponsor Activation Failed. '+data.msg+'</div>');
                }
                else {
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Sponsor Activation Failed. '+data+'</div>');
                }
            }
        });
    }
    
    function deleteSponsor(id, logo, image){
        $.ajax({
            url: "../REST/manage-sponsors.php",
            type: 'POST',
            data: {deleteThisSponsor: 'true', id:id, logo:logo, image:image},
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
    
    function editSponsor(id, name, logo, website, product, description, image){//,
        $('form #addNewSponsor').val('editSponsor');
        $('form #multi-action-sponsorAddEdit').text('Update Sponsor');
        $('#multiHeader').html('Edit "<i style="font-weight:normal;">'+name+'</i>"');
        $('form #oldLogoLabel').removeClass('hidden');
        var formVar = {id:id, name:name, logo:logo, website:website, product:product, image:image};
        $.each(formVar, function(key, value) { 
            if(key === 'logo') { $('form #oldLogo').val(value); $('form #oldLogoSource').html('<img src="../media/sponsor/'+value+'" style="width:80px;height:60px;" />'); $('form #oldLogoComment').text(value).css('color','red');} 
            else if(key === 'image') { $('form #oldImage').val(value); $('form #oldImageSource').html('<img src="../media/sponsor-image/'+value+'" style="width:80px;height:60px;" />'); $('form #oldImageComment').text(value).css('color','red');} 
            else $('form #'+key).val(value);   
        });
        CKEDITOR.instances['description'].setData(description);
        $("form#CreateSponsor").submit(function(e){  
            e.stopPropagation(); 
            e.preventDefault();
            var formDatas = new FormData($(this)[0]);
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
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+erroMsg+'</div>');
                }
            });
            return false;
        });
    }
});