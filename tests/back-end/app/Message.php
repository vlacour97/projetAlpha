<?php
/**
 * Created by PhpStorm.
 * User: PAUL
 * Date: 04/11/2016
 * Time: 11:07
 */

include_once '../../../private/config.php';

echo '<pre>';


//var_dump(\app\Message::get_message(3));
//var_dump(\app\Message::get_new_messages(7));
//var_dump(\app\Message::get_all_messages(7));
//var_dump(\app\Message::get_sended_messages(7));
var_dump(\app\Message::get_deleted_messages(7));

//foreach($var as $content)
    /** @var $content \app\MessageAttachmentDatas */
    //echo $content->link.'<br>';