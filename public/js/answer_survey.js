/**
 * Created by valentinlacour on 03/12/16.
 */

$(function(){

    var url = 'private/controller/answer_survey.php';

    function pageLoad(){
        $('.widget').widgster();
        var theme = 'air';
        var classes = 'messenger-fixed messenger-on-top';

        $.globalMessenger({ extraClasses: classes,theme: theme });
        Messenger.options = { extraClasses: classes,theme: theme  };
        events();
    }

    pageLoad();
    SingApp.onPageLoad(pageLoad);


    function events(){
        $('body')
            .on('click','.addComment',function(e){
                e.preventDefault();
                $(this).parent().find('.hidden').removeClass('hidden');
                $(this).addClass('hidden');
            })
            .on('click','.closeComment',function(e){
                e.preventDefault();
                $(this).parent().parent().parent().find('.hidden').removeClass('hidden');
                $(this).parent().parent().addClass('hidden').find('textarea').val('');
            })
            .on('click','.btnSave',function(e){
                e.preventDefault();
                var id = $('.table').data('id');
                var urlTmp = url + '?action=save_survey&id=' + id;
                var form = $('.table form').serializeArray();
                $.post(urlTmp,form)
                    .done(function(data){
                        data = jQuery.parseJSON(data);
                        if(data.response){
                            Messenger().post({
                                message: message.saveSuccess,
                                type: 'success',
                                showCloseButton: true
                            });
                        }else{
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
            .on('click','.btnSend',function(e){
                e.preventDefault();
                if($('.table textarea').length != $('.table input[type=radio]:checked').length){
                    Messenger().post({
                        message: message.completeSurvey,
                        type: 'error',
                        showCloseButton: true
                    });
                    return false;
                }
                $('#sendConfirm').modal();
            })
            .on('click','#sendSurvey',function(e){
                var id = $('.table').data('id');
                var urlTmp = url + '?action=send_survey&id=' + id;
                var form = $('.table form').serializeArray();
                $.post(urlTmp,form)
                    .done(function(data){
                        data = jQuery.parseJSON(data);
                        if(data.response){
                            document.location.href=message.returnPath;
                        }else{
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




});