//var fileextension = Array('.jpg','.gif','.bmp','.png');
//    $.ajax({
//        url: "../REST/fetch-gallery-images.php",
//        dataType: "json",
//        success: function (data) {
//            $.each(data, function(i,filename) {
//                $.each(fileextension, function(j, ext){
//                    if(filename.indexOf(ext)>=0)
//                        $('table').append('<tr><td><img width="40px" height="40px" src="'+ filename +'"></td><td>'+ filename.replace('../media/','') +'</td><td class="td-actions"><a href="delete-images?file='+ filename.replace('../media/gallery/','') +'" class="btn btn-danger btn-small"><i class="btn-icon-only icon-trash"> </i></a></td></tr>');
//                });
//            });
//        }
//    });

$(document).ready(function(){
    var dataTable = $('#gallerylist').DataTable( {
        "processing": true,
        "scrollX": true,
        "ajax":{
            url :"../REST/fetch-gallery-images.php",
            type: "post",  
            error: function(){  // error handling
                    $("#gallerylist-error").html("");
                    $("#gallerylist").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#gallerylist_processing").css("display","none");

            }
        }
    } );


    $(document).on('click', '.delete-image', function() {
        if(confirm("Are you sure you want to delete this image ["+$(this).attr('data-image')+"]? ")) deleteImage($(this).attr('data-image'));
    });
    function deleteImage(image){
        $.ajax({
            url: "../REST/delete-gallery-image.php",
            type: 'POST',
            data: {image: image},
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

});