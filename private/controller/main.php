<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 25/11/16
 * Time: 22:27
 */

include '../config.php';

switch($_GET['action']){
    case 'language_switch':
        if(!isset($_GET['lang']))
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

        \app\Log::set_lang($_GET['lang']);
        break;
    case 'viewed_notifications' :
        if(!\general\PDOQueries::viewed_all_notification(\app\Log::get_id()))
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        break;
    case 'send_feedback':
        $user = \app\User::get_user(\app\Log::get_id());
        $sign = $user->fname.' '.$user->name.' ('.$user->email.')';
        if(!\general\mail::feedback_bug($_POST['feedBack-object'],$_POST['feedBack-message'],$sign))
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        break;
    case 'get_notifications' :
        $html = new \general\HTML();
        $notification = $html->notifications();
        $nb_notifications = "";
        if(($tmp = \app\Notifications::countNotifications()) != 0)
            $nb_notifications = "<span class=\"circle bg-warning fw-bold nb-notifications\">$tmp</span>";
        echo json_encode(array('notifications'=>$notification,'nb_notification' => $nb_notifications));
        break;
    case 'get_unviewed_message_number':
        $nb_messages = "";
        if(($tmp = \app\Message::count_message(\app\Log::get_id())) != 0)
            $nb_messages = $tmp;
        echo $nb_messages;
        break;
}

