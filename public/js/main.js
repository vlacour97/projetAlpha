/**
 * Created by valentinlacour on 25/11/16.
 */


$(function(){

    var theme = 'air';
    var classes = 'messenger-fixed messenger-on-top';

    var datas_page;
    var flag = false;

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

    $('#searchBar').on('input',function(){
            $('.loader-wrap').removeClass('hide').removeClass('hiding');
            var value = $(this).val();
            if(!flag){
                datas_page = $('.content-wrap').html();
                flag = true;
            }
            if($(this).val() == ""){
                $('.content-wrap').html(datas_page);
                $('.loader-wrap').addClass('hide').addClass('hiding');
                return false;
            }
            var url = 'private/controller/search.php?q=' + value;
            $.get(url)
                .done(function(data){
                    $('.content-wrap').html(data);
                    $('.loader-wrap').addClass('hide').addClass('hiding');
                })
                .fail(function(){
                    $('.loader-wrap').addClass('hide').addClass('hiding');
                })

        });
    $('#searchForm').submit(function(e){
        e.preventDefault();
    });

    function get_notification(){
        var url = 'private/controller/main.php?action=get_notifications';
        $.get(url)
            .done(function(data){
                data = jQuery.parseJSON(data);
                $('#notifications-list').html(data.notifications);
                $('.nbNotifications').html(data.nb_notification);
            })
    }

    function get_nb_message(){
        var url = 'private/controller/main.php?action=get_unviewed_message_number';
        $.get(url)
            .done(function(data){
                $('.nbMessage').html(data);
            })
    }

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    var notification_timer = setInterval(get_notification,1000);
    var message_timer = setInterval(get_nb_message,1000);

});