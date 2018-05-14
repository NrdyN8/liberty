$(function(){

    $('body').on('click', '#editUser', function(e){
        e.preventDefault();
        $('.disabled').removeClass('disabled').attr("disabled", false);
        $('.disabled-hidden').removeClass('disabled-hidden').attr("disabled", false);
        $('#editUser').addClass('disabled-hidden').attr("disabled", true);
    });

});