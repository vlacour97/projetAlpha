/**
 * Created by valentinlacour on 03/12/16.
 */

$(function(){

    var url = 'private/controller/profile.php';


    function pageLoad(){
        $('.widget').widgster();
        var theme = 'air';
        var classes = 'messenger-fixed messenger-on-top';

        $.globalMessenger({ extraClasses: classes,theme: theme });
        Messenger.options = { extraClasses: classes,theme: theme  };
        $('.select2').select2();
        events();
    }

    function events(){
        $("body")
            .on('click','.btnPassword',function(e){
                e.preventDefault();
                var urlTmp = url + '?action=change_password';
                var form = $('#passwordForm').serializeArray();
                $.post(urlTmp,form)
                    .done(function(data){
                        data = jQuery.parseJSON(data);
                        if(data.response){
                            Messenger().post({
                                message: message.changePassword,
                                type: 'success',
                                showCloseButton: true
                            });
                            $('#passwordForm input').val('');
                        }
                        else
                        {
                            switch (Math.floor(data.code/1000)){
                                case 2 :
                                    error = 'info';
                                    break;
                                default :
                                    error = 'error';
                            }
                            Messenger().post({
                                message: data.exception,
                                type: error,
                                showCloseButton: true
                            });
                        }
                    })
            })
            .on('click','.btnChange',function(e){
                e.preventDefault();
                var urlTmp = url + '?action=change_user_data';
                var form = $('#otherForm').serializeArray();
                $.post(urlTmp,form)
                    .done(function(data){
                        data = jQuery.parseJSON(data);
                        if(data.response)
                        {
                            Messenger().post({
                                message: message.changeDatas,
                                type: 'success',
                                showCloseButton: true
                            });
                            get_user_card();
                        }
                        else
                        {
                            switch (Math.floor(data.code/1000)){
                                case 2 :
                                    error = 'info';
                                    break;
                                default :
                                    error = 'error';
                            }
                            Messenger().post({
                                message: data.exception,
                                type: error,
                                showCloseButton: true
                            });
                        }
                    })
            })

    }


    function get_user_card(){
        var urlTmp = url + '?action=get_user_card';
        $.get(urlTmp)
            .done(function(data){
                $("#userCard").html(data);
            })
    }

    pageLoad();
    SingApp.onPageLoad(pageLoad);

});