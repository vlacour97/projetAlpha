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
//var_dump(\app\Message::get_new_messages(9));
//var_dump(\app\Message::get_all_messages(7));
//var_dump(\app\Message::get_sended_messages(7));
//var_dump(\app\Message::get_deleted_messages(7));
//var_dump(\general\PDOQueries::get_maxID_post_attachment());
$var = \general\PDOQueries::show_message(12);

foreach($var as $key=>$content)
    if(is_string($key))
echo 'public $'.$key.';<br>';

/*try{
    var_dump(\app\Message::send_message(7,9,'coucou','huehuehuehue on rigole bien par ici',$_FILES,['remi' => 'Coucou'],9));
}catch (\Exception $e){
    echo $e->getMessage();
    //var_dump($e->getItems());
}*/

/*try{
    var_dump(\app\Message::delete_message_attachments(48));
}catch(Exception $e){
    echo $e->getMessage();
}*/

/*try{
    var_dump(\app\Message::delete_message(48));
}catch(Exception $e){
    echo $e->getMessage();
}*/
/*
try{
    var_dump(\app\Message::save_message_attachment(9,$_FILES['remi'],'Coucou Test'));
}catch(Exception $e){
    echo $e->getMessage();
}*/

//foreach($var as $content)
    /** @var $content \app\MessageAttachmentDatas */
    //echo $content->link.'<br>';

?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="remi">
    <button type="submit">Envoyer</button>
</form>
