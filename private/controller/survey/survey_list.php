<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 02/12/16
 * Time: 15:05
 */

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../../config.php";
    switch($_GET['action']){
        case 'check_availability':
            echo json_encode(['response'=>\general\PDOQueries::isset_answers()]);
            break;
        case 'delete_answer':
            $teList = \general\PDOQueries::show_te_was_answered();
            echo json_encode(['response'=>\general\PDOQueries::delete_all_answer_for_all_students() && \general\mail::send_update_survey_notification($teList) && \app\Notifications::update_survey()]);
            break;
        case 'change_survey':
            $id = \general\crypt::decrypt($_GET['id']);
            echo json_encode(['response'=>\app\Answer::set_able_survey_id($id)]);
            break;
    }
    die();
}

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
    $status = $survey->able ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>";
    $hidden_option = $survey->able ? 'hidden' : '';
    $replace = array('{ID}','{name}','{CreationDate}','{ModificationDate}','{status}','{ID_crypt}','{hidden-option}');
    $by = array($key+1,$survey->name,$survey->creation_date,$survey->modification_date,$status,\general\crypt::encrypt($key+1),$hidden_option);
    $surveys .= str_replace($replace,$by,$survey_gabarit);
}

$gabarit = str_replace('{survey_list}',$surveys,$gabarit);

$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);