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

}

