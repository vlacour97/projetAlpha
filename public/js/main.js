/**
 * Created by valentinlacour on 25/11/16.
 */


$(function(){

    var theme = 'air';
    var classes = 'messenger-fixed messenger-on-top';

    $.globalMessenger({ extraClasses: classes,theme: theme });
    Messenger.options = { extraClasses: classes,theme: theme  };

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

    $('#sendFeedBack').on('click',function(){
        var url = 'private/controller/main.php?action=send_feedback';
        var form = $('#feedBackModal form').serializeArray();
        $.post(url,form)
            .done(function(){
                Messenger().post({
                    message: feedbackMessage,
                    type: 'success',
                    showCloseButton: true
                });
                $('#feedBackModal').modal('hide');
                $('#feedBackModal input').val('');
                $('#feedBackModal textarea').val('');
            });
    });

    //TODO Màj des données

});