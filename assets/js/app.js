$(document).ready(function(){
    $(".del-btn").click(function(){
        var id= $(this).attr('data-id');
        $("#del-"+id).modal('show');
    });
});