/**
 * Created by valentinlacour on 04/12/16.
 */


$(function(){
    function pageLoad() {
        $('.widget').widgster();
    }

    $('#config_deadline').datetimepicker({
        pickTime: false
    });

    pageLoad();
    SingApp.onPageLoad(pageLoad);


    $('.validForm').click(function(e){
        e.preventDefault();
        var url = "private/controller/manage_API.php?action=update_data";
        var form = $('#configForm').serializeArray();
        $.post(url,form)
            .done(function(datas){
                datas = jQuery.parseJSON(datas);
                if(datas.response)
                    Messenger().post({
                        message: message.success,
                        type: 'success',
                        showCloseButton: true
                    });
                else{
                    var error;
                    switch (Math.floor(datas.code/1000)){
                        case 1 :
                            error = 'info';
                            break;
                        default :
                            error = 'error';
                    }
                    Messenger().post({
                        message: datas.exception,
                        type: error,
                        showCloseButton: true
                    });
                }

            });
    });

});