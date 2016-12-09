<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 23/11/16
 * Time: 00:07
 */

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../config.php";

    try{
        \app\Log::stay_connected($_POST['password']);
        echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
    }catch (Exception $e){
        echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
    }
    die();
}


$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/lockscreen');

$id = \app\Log::get_id();
$user = \app\User::get_user($id);


//Traitement de données
$replace = array('{username}','{img-user}');
$by = array($user->fname.' '.$user->name,\app\User::get_profile_photo($id));
$gabarit = str_replace($replace,$by,$gabarit);

//Integration des fichiers
$script_vendor = array(
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js'
);
$script = array('lockscreen.js');

$html->open();
echo $gabarit;
$html->close($script_vendor,$script);


//TODO vous n'etes pas déconnexion