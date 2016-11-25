/**
 * Created by valentinlacour on 25/11/16.
 */


$(function(){

    $('.language_switcher').click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var url = 'private/controller/main.php?action=language_switch&lang=' + id;

        $.get(url)
            .done(function(){
                window.location.reload();
            });
    });

    $('#notifications-dropdown-toggle').click(function () {
        var url = 'private/controller/main.php?action=viewed_notifications';

        $.get(url)
            .done(function(){
                $('#notifications-dropdown-toggle').find('.nb-notifications').fadeOut();
            });
    });

    //TODO Màj des données

});