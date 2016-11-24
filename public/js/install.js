/**
 * Created by valentinlacour on 16/11/16.
 */

//bootstrap application wizard demo functions

$(function(){
    function pageLoad(){

        $('.widget').widgster();
        var theme = 'air';
        var classes = 'messenger-fixed messenger-on-top';

        $.globalMessenger({ extraClasses: classes,theme: theme });
        Messenger.options = { extraClasses: classes,theme: theme  };


        var wizard = $('#wizard').bootstrapWizard({
            onTabShow: function($activeTab, $navigation, index) {
                var $total = $navigation.find('li').length;
                var $current = index + 1;
                var $percent = ($current/$total) * 100;
                var $wizard = $("#wizard");
                $wizard.find('.progress-bar').css({width: $percent + '%'});

                if($current >= $total) {
                    $wizard.find('.pager .next').hide();
                    $wizard.find('.pager .finish').show();
                    $wizard.find('.pager .finish').removeClass('disabled');
                } else {
                    $wizard.find('.pager .next').show();
                    $wizard.find('.pager .finish').hide();
                }

                //setting done class
                $navigation.find('li').removeClass('done');
                $activeTab.prevAll().addClass('done');
            },

            // validate on tab change
            onNext: function($activeTab, $navigation, nextIndex){
                var $activeTabPane = $($activeTab.find('a[data-toggle=tab]').attr('href')),
                    $form = $activeTabPane.find('form');

                // validate form in casa there is form
                if ($form.length){
                    if($form.parsley().validate())
                    {
                        var url = "private/controller/install.php?step=" + nextIndex;
                        var datas = $('#step'+ nextIndex +' form').serializeArray();
                        $('.loader-wrap').removeClass('hide').removeClass('hiding');
                        $.post(url,datas)
                            .done(function (datas) {
                                datas = jQuery.parseJSON(datas);
                                if(datas.response){
                                    $('#wizard').bootstrapWizard('show',nextIndex);
                                }else{
                                    Messenger().post({
                                        message: datas.exception,
                                        type: 'error',
                                        showCloseButton: true
                                    });
                                }
                                $('.loader-wrap').addClass('hide').addClass('hiding');
                            });

                    }
                    return false;
                }
            },
            onPrevious: function(){
                return false;
            },
            //diable tab clicking
            onTabClick: function($activeTab, $navigation, currentIndex, clickedIndex){
                return false;
            }
        });

    }
    $('#config_deadline').datetimepicker({
        pickTime: false
    });
    $('#testBDD').on('click', function(e) {
        e.preventDefault();
        var url = "private/controller/install.php?action=testBDConnection";
        var datas = $('#step1 form').serializeArray();
        $.post(url,datas)
            .done(function(datas){
                datas = jQuery.parseJSON(datas);
                if(datas.response)
                    Messenger().post({
                        message: DB_connect.success,
                        type: 'success',
                        showCloseButton: true
                    });
                else{
                    var error;
                    switch (datas.code){
                        case 1 :
                            error = 'info';
                            break;
                        default :
                            error = 'error';
                    }
                    Messenger().post({
                        message: '<b>'+DB_connect.fail+'</b><br>'+datas.exception,
                        type: error,
                        showCloseButton: true
                    });
                }

            });
    });
    pageLoad();
    $('#wizard').bootstrapWizard('show',Step.value);
    SingApp.onPageLoad(pageLoad);

    $('.finish').click(function(){
        var url = "private/controller/install.php?step=4";
        $.get(url)
            .done(function(datas){
                datas = jQuery.parseJSON(datas);
                if(datas.response)
                    document.location.href="index.php";
                else{
                    var error;
                    switch (datas.code){
                        case 1 :
                            error = 'info';
                            break;
                        default :
                            error = 'error';
                    }
                    Messenger().post({
                        message: '<b>'+DB_connect.fail+'</b><br>'+datas.exception,
                        type: error,
                        showCloseButton: true
                    });
                }

            });
    });

});