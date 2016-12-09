<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 02/12/16
 * Time: 15:05
 */

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/admin_surveyList');

$script_vendor = array(
    'underscore/underscore-min.js',
    'backbone/backbone.js',
    'backbone.paginator/lib/backbone.paginator.min.js',
    'backgrid/lib/backgrid.js',
    'backgrid-paginator/backgrid-paginator.js',
    'datatables/media/js/jquery.dataTables.js',
    'bootstrap-select/bootstrap-select.min.js',
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js'
);
$script = array('SurveyList.js');

$surveys = "";
$survey_list = \app\Answer::get_all_survey();
$survey_gabarit = \general\Language::translate_gabarit('components/survey_list_element');

foreach($survey_list as $key=>$survey){
    if($survey->able)
        $status = "<i class='fa fa-check'></i>";
    else
        $status = "<i class='fa fa-times'></i>";
    $replace = array('{ID}','{name}','{date}','{status}','{ID_crypt}');
    $by = array($key+1,$survey->name,$survey->modification_date,$status,\general\crypt::encrypt($key+1));
    $surveys .= str_replace($replace,$by,$survey_gabarit);
}

$gabarit = str_replace('{survey_list}',$surveys,$gabarit);

$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);