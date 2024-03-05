$(document).ready(function(){
    $('.ui.dropdown')
        .dropdown()
    ;

    $(document).ready(function(){
        $('.demo.menu .item').tab({history:false});
    });

    $('.message .close')
        .on('click', function() {
            $(this)
                .closest('.message')
                .transition('fade')
            ;
        })
    ;

    $(".del-btn").click(function(){
        var id= $(this).attr('data-id');
        $("#del-"+id).modal('show');
    });

    var vals={};

    $($('.ui.form').serializeArray()).each(function(index, value){
        if ($("#"+value['name']).data("required")===1){
            vals[value['name']]="empty";
        }

    });

    vals['username']="empty";
    vals['password']="empty";

    $('.ui.form')
        .form({
            fields: vals
        })
    ;
});