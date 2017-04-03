<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 12/11/16
 * Time: 22:31
 */

include_once '../../../private/config.php';

//var_dump(\app\Notifications::add_post(6));
/*
try{
    var_dump(\app\Notifications::comment_post(56));
}catch (Exception $e){
    echo $e->getMessage();
}*/

//var_dump(\app\Notifications::like_post(6,9));
//var_dump(\app\Notifications::wait_survey(269));
//var_dump(\app\Notifications::complete_survey(269));
//var_dump(\app\Notifications::validate_survey(269));
//var_dump(\app\Notifications::autorised_publication(9));
var_dump(\app\Notifications::update_survey());
$notifications = \app\Notifications::get_notifications();

echo '<ul>';
foreach ($notifications as $content) {
    /* @var $content \app\NotificationsForm */
    echo '<a href="'.$content->link.'"><li>'.$content->text.'</li></a>';

}
echo '</ul>';