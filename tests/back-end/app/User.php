<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 31/10/16
 * Time: 17:11
 */

include_once '../../../private/config.php';

echo '<pre>';
/*
try
{
    var_dump(\app\User::registration_by_admin('val_97@live.fr',2,true,'Valentin','Lacour','','','','','',''));
}catch (Exception $e)
{
    echo $e->getMessage();
}*/
/*
try
{
    echo (json_encode(\app\User::upload_and_analyses_csv($_FILES['csv'],1)));
}catch (Exception $e)
{
    echo $e->getMessage();
}

$response_upload_and_analyses_csv = array(
    0 => "student/name",
    1 => "student/fname",
    2 => "ti/name",
    3 => "ti/email",
    4 => "te/email",
);


try
{
    var_dump(\app\User::save_csv_datas($response_upload_and_analyses_csv,1));
}catch (\app\AddCSVDataException $e)
{
    if($e->getCode() == 2)
        echo '<p style="color:red">'.$e->getMessage().'</p>';
    if($e->getCode() == 1)
    {
        echo '<p style="color:orange">'.$e->getMessage().'</p>';
        var_dump($e->getItems());
    }
}
*/
//var_dump(\app\User::delete_student(271));
/*
try{
    var_dump(\app\User::delete_user(9));
}catch(Exception $e){
    echo $e->getMessage();
}
*/

//var_dump(\app\User::get_student(271));
//var_dump(\app\User::get_user(9));
//var_dump(\app\User::get_all_students());
//var_dump(\app\User::get_all_users());
/*
try{
    var_dump(\app\User::set_student(271,45,null,'Rocroy'));
}catch (Exception $e){
    echo $e->getMessage();
}*/
/*
try{
    var_dump(\app\User::set_user(9,'azerty','Test'));
}catch (Exception $e){
    echo $e->getMessage();
}*/
//var_dump(\app\User::get_TI());
//var_dump(\app\User::get_TE());
//var_dump(\app\User::get_deleted_users());
/*try{
    var_dump(\app\User::get_deleted_students());
}catch (Exception $e){
    echo $e->getMessage();
}*/
//var_dump(\app\User::change_password(7,'test'));
//var_dump(\app\User::autorised_to_publish(7));
/*
try{
    var_dump(\app\User::set_profile_photo($_FILES['csv'],9)->crop());
}catch (Exception $e){
    echo $e->getMessage().'<br>';
}

var_dump(\app\User::get_profile_photo(9));

echo '</pre>';
*/


$students = \app\User::get_all_students();
echo '<ul>';
foreach($students as $content)
    /* @var $content \app\StudentDatas*/
    echo '<li>'.$content->ID.'-'.$content->fname.' '.$content->name.' // '.$content->creation_date->format('dd MM yyyy').'</li>';
echo '</ul>';


$users = \app\User::get_all_users();
echo '<ul>';
foreach($users as $content)
    /* @var $content \app\UserDatas*/
    echo '<li>'.$content->ID.'-'.$content->fname.' '.$content->name.' --- '.$content->email.' // '.$content->registration_date->format('dd M yyyy').'</li>';
echo '</ul>';


?>

<form method="post" action="#" enctype="multipart/form-data">
    <input type="file" name="csv">
    <button type="submit">Envoyer</button>
</form>