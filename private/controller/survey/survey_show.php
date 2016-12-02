<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 02/12/16
 * Time: 14:24
 */

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/admin_survey_show');
$id = \general\crypt::decrypt($_GET['id']);

if(!\app\Answer::isset_survey($id))
    header('Location: index.php');

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

$survey_datas = \app\Answer::get_survey($id);
$survey_gabarit = \general\Language::translate_gabarit('components/survey_read2');
$survey = "";

foreach($survey_datas->questions as $key=>$question){
    $reponses = "";
    foreach($question as $key2=>$reponse){
        if(is_a($reponse,'StdClass')){
            $reponses .= '<div class="radio radio-primary display-inline-block ml-n mr-n"><input type="radio" name="radio2" id="'.$key.$key2.'" value="option1" disabled="disabled"><label for="'.$key.$key2.'">'.$reponse->lbl.'</label></div>';
        }
    }
    $replace = array('{id-survey}','{survey-lbl}','{responses}');
    $by = array($key+1,$question->questionLbl,$reponses);
    $survey .= str_replace($replace,$by,$survey_gabarit);
}

$replace = array('{question_list}','{name-survey}');
$by = array($survey,$survey_datas->name);
$gabarit = str_replace($replace,$by,$gabarit);

$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor);