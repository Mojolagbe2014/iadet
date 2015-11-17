jQuery.noConflict();

jQuery(document).ready(function($){
    $('.contact-frm').submit(function (e) {
        e.stopPropagation(); 
        e.preventDefault();
        var formDatas = $(this).serialize();
        var alertType = ["danger", "success", "danger", "error"];
        $.ajax({
            url:  $(this).attr("action"),
            type: 'POST',
            data: formDatas,
            cache: false,
            success : function(data, status) {
                if(data.status != null && data.status !=1) { 
                    swal({
                        title: "Message Not Sent !!!",
                        text: "Please enter: "+data.msg,
                        confirmButtonText: "Okay",
                        customClass: 'twitter',
                        type: 'warning'
                    });
                }
                else if(data.status != null && data.status == 1) { 
                    swal({
                        title: "Message Sent !!!",
                        type: 'success',
                        text: data.msg,
                        confirmButtonText: "Okay",
                        customClass: 'twitter'
                    });
                }
                else {
                    swal({
                        title: "Message Not Sent !!!",
                        text: data,
                        type: 'error',
                        confirmButtonText: "Okay",
                        customClass: 'twitter'
                    });
                }
            },
            error : function(xhr, status) {
                erroMsg = '';
                if(xhr.status===0){ erroMsg = 'There is a problem connecting to internet. Please review your internet connection.'; }
                else if(xhr.status===404){ erroMsg = 'Requested page not found.'; }
                else if(xhr.status===500){ erroMsg = 'Internal Server Error.';}
                else if(status==='parsererror'){ erroMsg = 'Error. Parsing JSON Request failed.'; }
                else if(status==='timeout'){  erroMsg = 'Request Time out.';}
                else { erroMsg = 'Unknow Error.\n'+xhr.responseText;}          
                swal({
                        title: "Message Not Sent !!!",
                        text: erroMsg,
                        type: 'error',
                        confirmButtonText: "Okay",
                        customClass: 'twitter'
                });
            }
        });
        return false;
    });
});