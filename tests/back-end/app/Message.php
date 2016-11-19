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
//var_dump(\app\Message::get_deleted_messages(7));
//var_dump(\app\Message::save_message_attachments(6,$_FILES['remi']))
var_dump(\general\PDOQueries::get_max_message_attachment_id());
try{
    var_dump(\app\Message::send_message(7,9,'coucou','huehuehuehue on rigole bien par ici',$_FILES));
}catch (\app\MessageException $e){
    echo $e->getMessage();
    var_dump($e->getItems());
}

//foreach($var as $content)
    /** @var $content \app\MessageAttachmentDatas */
    //echo $content->link.'<br>';

?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="remi">
    <button type="submit">Envoyer</button>
</form>
