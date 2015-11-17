$(document).ready(function(){
    $('#dateTime').datetimepicker({
    dayOfWeekStart : 1,
    lang:'en'
    });
    
    $("form#CreateEvent").submit(function(e){ 
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
    
    loadAllEvents();
    function loadAllEvents(){
        var dataTable = $('#eventlist').DataTable( {
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax":{
                url :"../REST/manage-events.php", 
                type: "post",  
                data: {fetchEvents:'true'},
                error: function(){  // error handling
                        $("#eventlist-error").html("");
                        $("#eventlist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#eventlist_processing").css("display","none");

                }
            }
        } );
    }
    
    var currentStatus ="";
    
    $(document).on('click', '.activate-event', function() {
        currentStatus = 'Activate'; if(parseInt($(this).attr('data-status')) === 1) currentStatus = "De-activate";
        if(confirm("Are you sure you want to "+currentStatus+" this event? Event Name: '"+$(this).attr('data-name')+"'")) activateEvent($(this).attr('data-id'),$(this).attr('data-status'));
    });
    $(document).on('click', '.delete-event', function() {
        if(confirm("Are you sure you want to delete this event? ("+$(this).attr('data-name')+")")) deleteEvent($(this).attr('data-id'), $(this).attr('data-image'));
    });
    $(document).on('click', '.edit-event', function() {
        if(confirm("Are you sure you want to edit this event?")) editEvent($(this).attr('data-id'), $(this).attr('data-name'), $(this).find('span#JQDTdescriptionholder').html(), $(this).attr('data-location'), $(this).attr('data-image'), $(this).attr('data-date-time'));
    });
    
    function activateEvent(id, status){
        $.ajax({
            url: "../REST/manage-events.php",
            type: 'GET',
            data: {activateEvent: 'true', id:id, status:status},
            cache: false,
            success : function(data, status) {
                if(data.status === 1){
                    $("#messageBox, .messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Event Successfully '+currentStatus+'d! <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Reloading ...</div>');
                    setInterval(function(){ window.location = "";}, 2000);
                }
                else if(data.status === 0 || data.status === 2 || data.status === 3 || data.status === 4){
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Event Activation Failed. '+data.msg+'</div>');
                }
                else {
                    $("#messageBox, .messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Event Activation Failed. '+data+'</div>');
                }
            }
        });
    }
    
    function deleteEvent(id, image){
        $.ajax({
            url: "../REST/manage-events.php",
            type: 'POST',
            data: {deleteThisEvent: 'true', id:id, image:image},
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
    
    function editEvent(id, name, description, location, image, dateTime){//,
        $('form #addNewEvent').val('editEvent');
        $('form #multi-action-eventAddEdit').text('Update Event');
        $('#multiHeader').html('Edit "<i style="font-weight:normal;">'+name+'</i>"');
        var formVar = {id:id, name:name, location:location, dateTime:dateTime, image:image};
        $.each(formVar, function(key, value) { 
            if(key == 'image') { $('form #oldImage').val(value); $('form #oldImageSource').html('<img src="../media/event/'+value+'" style="width:80px;height:60px;" />'); $('form #oldImageComment').text(value).css('color','red');} 
            else $('form #'+key).val(value);   
        });
        CKEDITOR.instances['description'].setData(description);
        $("form#CreateEvent").submit(function(e){  
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