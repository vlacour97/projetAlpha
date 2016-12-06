<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 29/11/16
 * Time: 00:27
 */


if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../../config.php";

    switch($_GET['action']){
        case 'get_survey_form':
            $survey_gabarit = \general\Language::translate_gabarit('components/add_survey');
            $answers_gabarit = \general\Language::translate_gabarit('components/answer_survey');

            $answers = "";
            for($i=1;$i<=2;$i++){
                $answers .= str_replace(['{ID_answer}','{response_content}','{value_content}'],[$i,'',0],$answers_gabarit);
            }

            $replace = array('{answers}','{ID}','{question-name-value}');
            $by = array($answers,$_GET['id'],'');
            echo  str_replace($replace,$by,$survey_gabarit);
            break;
        case 'get_answer_form':
            $answers_gabarit = \general\Language::translate_gabarit('components/answer_survey');
            echo str_replace(['{ID_answer}','{ID}','{response_content}','{value_content}'],[$_GET['id_answer'],$_GET['id_survey'],'',0],$answers_gabarit);
            break;
        case 'get_answer_form_with_args':
            $answers_gabarit = \general\Language::translate_gabarit('components/answer_survey');
            echo str_replace(['{ID_answer}','{ID}','{response_content}','{value_content}'],[$_GET['id_answer'],$_GET['id_survey'],$_GET['response'],$_GET['value']],$answers_gabarit);
            break;
        case 'get_survey_form_with_args':
            $survey_gabarit = \general\Language::translate_gabarit('components/add_survey');
            $answers_gabarit = \general\Language::translate_gabarit('components/answer_survey');

            $answers = "";
            for($i=1;$i<=2;$i++){
                $answers .= str_replace(['{ID_answer}','{response_content}','{value_content}'],[$i,'',0],$answers_gabarit);
            }

            $replace = array('{answers}','{ID}','{question-name-value}');
            $by = array($answers,$_GET['id'],$_GET['name']);
            echo  str_replace($replace,$by,$survey_gabarit);
            break;
        case 'save_survey':
            $datas = array();
            $iterator = 1;
            while(isset($_POST['question-name-'.$iterator]))
            {
                $tmp = array();
                $tmp['questionLbl'] = $_POST['question-name-'.$iterator];
                $iterator_answer = 1;
                while(isset($_POST['response-'.$iterator.'-'.$iterator_answer]))
                {
                    $tmp[$iterator_answer] = array(
                        "lbl" => $_POST['response-'.$iterator.'-'.$iterator_answer],
                        "nb_point" => intval($_POST['value-'.$iterator.'-'.$iterator_answer])
                    );
                    $iterator_answer++;
                }
                $datas[] = $tmp;
                $iterator++;
            }
            if(isset($_GET['name'])){
                \app\Answer::set_survey($datas,$_GET['name']);
            }elseif(isset($_GET['id'])){
                $id = \general\crypt::decrypt($_GET['id']);

                if(!\app\Answer::isset_survey($id))
                    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

                \app\Answer::set_survey($datas,\app\Answer::getSurveyName($id),$id);
            }else{
                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            }
            break;
    }

    die();
}

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/admin_create_survey');

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
$script = array('survey_create.js');


$survey_gabarit = \general\Language::translate_gabarit('components/add_survey');
$answers_gabarit = \general\Language::translate_gabarit('components/answer_survey');

if(isset($_GET['id'])){
    $id = \general\crypt::decrypt($_GET['id']);

    if(!\app\Answer::isset_survey($id))
        header('Location: index.php?nav=error/404');

    /*




        $answers = "";
        for($i=1;$i<=2;$i++){
            $answers .= str_replace(['{ID_answer}','{response_content}','{value_content}'],[$i,'',0],$answers_gabarit);
        }
        $replace = array('{answers}','{ID}','{question-name-value}');
        $by = array($answers,1,$answer->questionLbl);
        $survey .= str_replace($replace,$by,$survey_gabarit);

    }

    $replace = array('{add_answer_content}');
    $by = array($survey);
    $gabarit = str_replace($replace,$by,$survey);*/
    //die();

    $survey_datas = \app\Answer::get_survey($id);
    $survey = "";

    foreach($survey_datas->questions as $key=>$answer) {
        $answers = "";
        $iterator = 1;
        while(isset($answer->$iterator)) {
            $answers .= str_replace(['{ID_answer}', '{response_content}', '{value_content}'], [$iterator, $answer->$iterator->lbl, $answer->$iterator->nb_point], $answers_gabarit);
            $iterator++;
        }

        $replace = array('{answers}', '{ID}', '{question-name-value}');
        $by = array($answers, $key+1, $answer->questionLbl);
        $survey .= str_replace($replace, $by, $survey_gabarit);
    }

    $replace = array('{add_answer_content}');
    $by = array($survey);
    $gabarit = str_replace($replace,$by,$gabarit);


}else{

    $answers = "";
    for($i=1;$i<=2;$i++){
        $answers .= str_replace(['{ID_answer}','{response_content}','{value_content}'],[$i,'',0],$answers_gabarit);
    }

    $replace = array('{add_answer_content}','{answers}','{ID}','{question-name-value}');
    $by = array($survey_gabarit,$answers,1,'');
    $gabarit = str_replace($replace,$by,$gabarit);
}

$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);