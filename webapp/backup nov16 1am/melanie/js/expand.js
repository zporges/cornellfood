$(document).ready(function(){
    $('.wrapper div').click(function() {
        $(this).toggleClass('active');
        $(this).siblings().not(this).toggleClass('hide');
    });
});