<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 24/11/16
 * Time: 19:38
 */


if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../config.php";

    if(!$_POST['conditions'])
    {
        $e = new PersonalizeException(2040);
        echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
        die();
    }

    try{
        \app\Log::registration_by_user(\general\crypt::decrypt($_POST[\app\User::$user_marker]),$_POST['pwd'],$_POST['pwdVerif'],$_POST['fname'],$_POST['name'],$_POST['phone'],$_POST['address'],$_POST['zip_code'],$_POST['city'],$_POST['country'],$_POST['language']);
        echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
    }catch (Exception $e){
        echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
    }
    die();
}


$id = \general\crypt::decrypt($_GET[\app\User::$user_marker]);

//Si mauvais mot de passe ou compte déjà activé on redirige
if(!\app\Log::userExist($id) || \general\PDOQueries::is_activated($id))
    header('Location: index.php');


$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/active_account');

//Integration des fichiers
$script_vendor = array(
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js'
);
$script = array('create_account.js');

//Insertion de données
$users = \app\User::get_user($id);
$replace = array('{name_user}','{fname_user}','{email_user}','{phone_user}','{address_user}','{city_user}','{zip_code_user}','{id_name}','{id_value}');
$by = array($users->name,$users->fname,$users->email,$users->phone,$users->address,$users->city,$users->zip_code,\app\User::$user_marker,$_GET[\app\User::$user_marker]);
$gabarit = str_replace($replace,$by,$gabarit);
$gabarit = str_replace(['{select/countries}','{select/language}'],[$html->select()->country($users->country),$html->select()->language($users->language)],$gabarit);

$html->open();
echo $gabarit;
$html->close($script_vendor,$script);