$("form#login-form").submit(function(e){ 
        e.stopPropagation();
        e.preventDefault();
        var formDatas = $(this).serialize();
        //$("#messageBox").html(formDatas);
        $.ajax({
            url: $(this).attr("action"),
            type: 'POST',
            data: formDatas,
            cache: false,
            success : function(data, status) {
                if(data.status == "1"){
                    $.each(data.info, function(i, item) {
                        if (typeof localStorage !== "undefined") {
                            sessionStorage.IADETLoggedInAdmin = true;
                            sessionStorage.IADETAdminName = item.userName;
                            sessionStorage.IADETAdminFullName = item.name;
                            sessionStorage.IADETAdminRole = item.role;
                            sessionStorage.IADETadminId = item.id;
                            sessionStorage.IADETadminEmail = item.email;
                        }
                    });
                    $("#messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Login Successful! Welcome '+sessionStorage.IADETAdminName+', redirecting... please wait ...</div>');
                    setInterval(function(){ window.location = 'index'; }, 2000);
                }
                else {
                    $("#messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                }
            }
        });
        return false;
    });