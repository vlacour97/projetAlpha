<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 02/12/16
 * Time: 16:32
 */

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/admin_userList');

$script_vendor = array(
    'underscore/underscore-min.js',
    'backbone/backbone.js',
    'backbone.paginator/lib/backbone.paginator.min.js',
    'backgrid/lib/backgrid.js',
    'backgrid-paginator/backgrid-paginator.js',
    'datatables/media/js/jquery.dataTables.js',
    'bootstrap-select/bootstrap-select.min.js',
    'parsleyjs/dist/parsley.min.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/tab.js',
    'twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js',
    'select2/select2.js',
    'moment/min/moment.min.js',
    'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    'jasny-bootstrap/js/inputmask.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/popover.js',
    'bootstrap-application-wizard/src/bootstrap-wizard.js',
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js',
    'jasny-bootstrap/js/fileinput.js'
);
$script = array('UserList.js');


$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);