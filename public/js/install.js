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


        $('#wizard').bootstrapWizard({
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
                    return $form.parsley().validate();
                }
            },
            //diable tab clicking
            onTabClick: function($activeTab, $navigation, currentIndex, clickedIndex){
                return $navigation.find('li:eq(' + clickedIndex + ')').is('.done');
            }
        });
    }
    $('#config_deadline').datetimepicker({
        pickTime: false
    });
    $('#testBDD').on('click', function(e) {
        e.preventDefault();
        Messenger().post({
            message: 'Showing success message was successful!',
            type: 'success',
            showCloseButton: true
        });
    });
    pageLoad();
    SingApp.onPageLoad(pageLoad);
});