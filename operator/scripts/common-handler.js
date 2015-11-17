function logout(){
    if (typeof localStorage !== "undefined") {
        $('.container').animate({ scrollTop:0 }, 800, 'easeInOutQuad');
        $("#messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Login out .. ! Please wait ... </div>');
        $(".messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Login out .. ! Please wait ... </div>');
        $.ajax({
            url: "../REST/admin-logout.php",
            success : function(data, status) {
                if(data.status == "1"){
                    sessionStorage.clear();
                    $("#messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> '+data.msg+' Redirecting...</div>');
                    setInterval(function(){ window.location = 'login'; }, 2000);
                }
                else {
                    $("#messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                }
            }
        });
    }
}



$(document).ready(function(){
    //Login Verification
    if (typeof localStorage !== "undefined") {
        if(sessionStorage.IADETadminId == "" || sessionStorage.IADETadminId == null || sessionStorage.IADETadminEmail == "" || sessionStorage.IADETadminEmail == null)
        window.location = "login";
    }
    //Logout Handler
    $(".logout").click(function(){
        if (typeof localStorage !== "undefined") {
            $('.container').animate({ scrollTop:0 }, 800, 'easeInOutQuad');
            $("#messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> <img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> Login out .. ! Please wait ... </div>');
            $.ajax({
                url: "../REST/admin-logout.php",
                success : function(data, status) {
                    if(data.status == "1"){
                        sessionStorage.clear();
                        $("#messageBox").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><img src="images/cycling.GIF" width="30" height="30" alt="Ajax Loading"> '+data.msg+' Redirecting...</div>');
                        setInterval(function(){ window.location = 'login'; }, 2000);
                    }
                    else {
                        $("#messageBox").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                    }
                }
            });
        }
    });
    
    $('.adminName').text(sessionStorage.IADETAdminName);
    
});


