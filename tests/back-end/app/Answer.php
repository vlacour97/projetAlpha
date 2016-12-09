<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 27/10/16
 * Time: 21:08
 */

include_once '../../../private/config.php';

$survey = array(
    0 => array(
        "questionLbl" => "{fname_student} Question 11",
        1 => array(
            "lbl" => "Choix A",
            "nb_point" => 2
        ),
        2 => array(
            "lbl" => "Choix B",
            "nb_point" => 3
        ),
        3 => array(
            "lbl" => "Choix C",
            "nb_point" => 1
        ),
    ),
    1 => array(
        "questionLbl" => "Question 2",
        1 => array(
            "lbl" => "Choix A",
            "nb_point" => 1
        ),
        2 => array(
            "lbl" => "Choix B",
            "nb_point" => 2
        ),
        3 => array(
            "lbl" => "Choix C",
            "nb_point" => 3
        ),
    )
);


$answer = array(
    array('response' => 1, 'comment' => 'Oui oui'),
    array('response' => 3, 'comment' => '')
);

//\app\Answer::set_survey($survey,'Test1');
/*

if(\app\Answer::survey_is_completed($answer,5))
    echo "ok";
else
    echo "unok";

*/
/*
try{
    //var_dump($response = \app\Answer::get_survey(null,271));
    $response = \app\Answer::get_survey(null,271);
    foreach($response->questions as $key=>$content)
        echo $content->questionLbl.'<br>';
}catch (Exception $e){
    echo $e->getMessage();
}
*/
/*
if(\app\Answer::set_answer($answer,5,11,true))
    echo "ok";
else
    echo "unok";*/

//var_dump(\app\Answer::get_answers(11));

//var_dump(\app\Answer::delete_all_answer());
//var_dump(\app\Answer::have_answered(11));
//var_dump(\app\Answer::get_deadline(11)->format());
//var_dump(\app\Answer::set_deadline(11,new \general\Date('now')));
//var_dump(\app\Answer::set_static_deadline(new \general\Date('now')));
//var_dump(\app\Answer::can_complete_survey(11));
//var_dump(\app\Answer::validate_survey(11));
//var_dump(\app\Answer::is_validated(11));
//var_dump(\app\Answer::set_able_survey_id(1));


//var_dump($response);

//var_dump(\app\Answer::generateSurveyPDF(268));
var_dump(\app\Answer::generateStudentListPDF('Liste des étudiants'));



