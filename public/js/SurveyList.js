/**
 * Created by antoine on 05/11/2016.
 */
$(function(){

    var url = 'private/controller/survey/survey_list.php';
    var currentLineId;
    var table;

    function initDataTables(){
        /* Set the defaults for DataTables initialisation */
        $.extend( true, $.fn.dataTable.defaults, {
            "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ enregistrements par page",
                "sEmptyTable" : "Aucune donnée dans ce tableau",
                "sSearch" :"Rechercher",
                "oPaginate": {
                    "sPrevious": "Précédent",
                    "sNext": "Suivant"
                }
            }
        } );


        /* Default class modification */
        $.extend( $.fn.dataTableExt.oStdClasses, {
            "sWrapper": "dataTables_wrapper form-inline"
        } );


        /* API method to get paging information */
        $.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
        {
            return {
                "iStart":         oSettings._iDisplayStart,
                "iEnd":           oSettings.fnDisplayEnd(),
                "iLength":        oSettings._iDisplayLength,
                "iTotal":         oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage":          oSettings._iDisplayLength === -1 ?
                    0 : Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
                "iTotalPages":    oSettings._iDisplayLength === -1 ?
                    0 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
            };
        };


        /* Bootstrap style pagination control */
        $.extend( $.fn.dataTableExt.oPagination, {
            "bootstrap": {
                "fnInit": function( oSettings, nPaging, fnDraw ) {
                    var oLang = oSettings.oLanguage.oPaginate;
                    var fnClickHandler = function ( e ) {
                        e.preventDefault();
                        if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
                            fnDraw( oSettings );
                        }
                    };

                    $(nPaging).append(
                        '<ul class="pagination no-margin">'+
                        '<li class="prev disabled"><a href="#">'+oLang.sPrevious+'</a></li>'+
                        '<li class="next disabled"><a href="#">'+oLang.sNext+'</a></li>'+
                        '</ul>'
                    );
                    var els = $('a', nPaging);
                    $(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
                    $(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
                },

                "fnUpdate": function ( oSettings, fnDraw ) {
                    var iListLength = 5;
                    var oPaging = oSettings.oInstance.fnPagingInfo();
                    var an = oSettings.aanFeatures.p;
                    var i, ien, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

                    if ( oPaging.iTotalPages < iListLength) {
                        iStart = 1;
                        iEnd = oPaging.iTotalPages;
                    }
                    else if ( oPaging.iPage <= iHalf ) {
                        iStart = 1;
                        iEnd = iListLength;
                    } else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
                        iStart = oPaging.iTotalPages - iListLength + 1;
                        iEnd = oPaging.iTotalPages;
                    } else {
                        iStart = oPaging.iPage - iHalf + 1;
                        iEnd = iStart + iListLength - 1;
                    }

                    for ( i=0, ien=an.length ; i<ien ; i++ ) {
                        // Remove the middle elements
                        $('li:gt(0)', an[i]).filter(':not(:last)').remove();

                        // Add the new list items and their event handlers
                        for ( j=iStart ; j<=iEnd ; j++ ) {
                            sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
                            $('<li '+sClass+'><a href="#">'+j+'</a></li>')
                                .insertBefore( $('li:last', an[i])[0] )
                                .bind('click', function (e) {
                                    e.preventDefault();
                                    oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
                                    fnDraw( oSettings );
                                } );
                        }

                        // Add / remove disabled classes from the static elements
                        if ( oPaging.iPage === 0 ) {
                            $('li:first', an[i]).addClass('disabled');
                        } else {
                            $('li:first', an[i]).removeClass('disabled');
                        }

                        if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
                            $('li:last', an[i]).addClass('disabled');
                        } else {
                            $('li:last', an[i]).removeClass('disabled');
                        }
                    }
                }
            }
        } );

        var unsortableColumns = [];
        $('#survey-table').find('thead th').each(function(){
            if ($(this).hasClass( 'no-sort')){
                unsortableColumns.push({"bSortable": false});
            } else {
                unsortableColumns.push(null);
            }
        });

        table = $("#survey-table").DataTable({
            "sDom": "<'row'<'col-md-6 hidden-xs'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "oLanguage": {
                "sLengthMenu": "_MENU_",
                "sInfo": "Affichage de <strong>_START_ à _END_</strong> sur _TOTAL_ entrées"
            },
            "oClasses": {
                "sFilter": "pull-right",
                "sFilterInput": "form-control input-rounded ml-sm"
            },
            "aoColumns": unsortableColumns
        });

        $(".dataTables_length select").selectpicker({
            width: 'auto'
        });
    }

    function pageLoad(){
        $('.widget').widgster();
        initDataTables();
    }

    pageLoad();
    SingApp.onPageLoad(pageLoad);
    $('[data-toggle="tooltip"]').tooltip();

    $('.activate').on('click',function(){
        currentLineId = $(this).attr('data-id');
        $.getJSON(url + '?action=check_availability&id=' + currentLineId)
            .done(function(data){
                if(data.response){
                    $('#activateChoise').modal();
                }else
                    change_survey(currentLineId);
            })
            .fail(function(){
                Messenger().post({
                    message: message.errorCheckAvailability,
                    type: 'error',
                    showCloseButton: true
                });
            })
    });

    $('#activateChoise .btnNext').on('click',function(){
        change_survey(currentLineId);
        $('#activateChoise').modal('toggle');
    });
    $('#activateChoise .btnDelete').on('click',function(){
        delete_answers();
        $('#activateChoise').modal('toggle');
    });

    function delete_answers(){
        $.getJSON(url + '?action=delete_answer')
            .done(function(data){
                if(data.response){
                    change_survey(currentLineId);
                }else{
                    Messenger().post({
                        message: message.errorDeleteAnswer,
                        type: 'error',
                        showCloseButton: true
                    });
                }
            })
            .fail(function(data){
                Messenger().post({
                    message: message.errorDeleteAnswer,
                    type: 'error',
                    showCloseButton: true
                });
            });
    }

    function change_survey(survey_id){
        $.getJSON(url + '?action=change_survey&id=' + survey_id)
            .done(function(data){
                if(data.response){
                    update_change(survey_id);
                }else{
                    Messenger().post({
                        message: message.errorUpdateSurvey,
                        type: 'error',
                        showCloseButton: true
                    });
                }
            })
            .fail(function(data){
                Messenger().post({
                    message: message.errorUpdateSurvey,
                    type: 'error',
                    showCloseButton: true
                });
            });
    }

    function update_change(id){
        $(':not(.activate[data-id="' + id + '"])').removeAttr('hidden').parent().parent().find('.status .fa-check').removeClass('fa-check').addClass('fa-times');
        $('.activate[data-id="' + id + '"]').attr('hidden',true).parent().parent().find('.status .fa-times').removeClass('fa-times').addClass('fa-check');
    }

});