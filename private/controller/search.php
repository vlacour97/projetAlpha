<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 04/12/16
 * Time: 20:37
 */

include '../config.php';

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/search');

$user_result = "";
$student_result = "";
$message_result = "";
$post_result = "";

try{
    $users = \app\Search::searching_users($_GET['q']);
    $user_card = \general\Language::translate_gabarit('components/search/user_card');
    foreach($users as $user){
        /** @var $user \app\UserDatas */
        $replace = array('{profile_img}','{fname}','{name}','{status}','{phone}','{email}','{city}','{country}','{message_link}');
        $by = array(\app\User::get_profile_photo($user->ID),$user->fname,$user->name,\general\Language::get_user_type_text()[$user->type-1],$user->phone,$user->email,$user->city,$user->country,'#');//TODO Lien messagerie
        $user_result .= str_replace($replace,$by,$user_card);
    }
    if(count($users) == 0)
        $message_result = \general\Language::translate_gabarit('components/search/no_result');
}catch(Exception $e){
    $user_result = \general\Language::translate_gabarit('components/search/no_result');
}

try{
    $students = \app\Search::searching_students($_GET['q']);
    $student_card = \general\Language::translate_gabarit('components/search/student_card');
    foreach($students as $student){
        /** @var $student \app\StudentDatas */
        $replace = array('{profile_img}','{fname}','{name}','{group}','{phone}','{email}','{city}','{country}','{message_link}');
        $by = array(\app\User::get_profile_photo(0),$student->fname,$student->name,$student->group,$student->phone,$student->email,$student->city,$student->country);
        $student_result .= str_replace($replace,$by,$student_card);
    }
    if(count($students) == 0)
        $message_result = \general\Language::translate_gabarit('components/search/no_result');
}catch(Exception $e){
    $student_result = \general\Language::translate_gabarit('components/search/no_result');
}

try{
    $messages = \app\Search::searching_messages($_GET['q']);
    $message_card = \general\Language::translate_gabarit('components/search/message_card');
    foreach($messages as $message){
        /** @var $message \app\MessageDatas */
        $user = \app\User::get_user($message->id_sender);
        $replace = array('{profile_img}','{fname}','{name}','{time}','{object}','{content}');
        $by = array(\app\User::get_profile_photo($message->id_sender),$user->fname,$user->name,$message->send_date->format('d MM yyyy'),$message->object,\general\Text::cutString(\general\Text::automatic_emo($message->content),0,50,'...'));
        $message_result .= str_replace($replace,$by,$message_card);
    }
    if(count($messages) == 0)
        $message_result = \general\Language::translate_gabarit('components/search/no_result');
}catch(Exception $e){
    $message_result = \general\Language::translate_gabarit('components/search/no_result');
}

//TODO Recherche d'un post
$post_result = \general\Language::translate_gabarit('components/search/no_result');

$replace = array('{search_query}','{user_result}','{student_result}','{message_result}','{post_result}');
$by = array($_GET['q'],$user_result,$student_result,$message_result,$post_result);
$gabarit = str_replace($replace,$by,$gabarit);

echo $gabarit;