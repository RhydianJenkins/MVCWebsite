$(window).on('load', function() {
    if($().scrollTop() > 0) {
        $('#navigationbar').removeClass('opaque');
    } else {
        $('#navigationbar').addClass('opaque');
    }
});

$(document).ready(function(){
    $(window).scroll(function(){
        if($(this).scrollTop() > 0) {
            $('#navigationbar').removeClass('opaque');
        } else {
            $('#navigationbar').addClass('opaque');
        }
    });
});