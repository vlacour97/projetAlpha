<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 24/11/16
 * Time: 16:53
 */

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../config.php";

    if(isset($_POST[\app\User::$user_marker])){
        try{
            \app\Log::change_password(\general\crypt::decrypt($_POST[\app\User::$user_marker]),$_POST['pwd'],$_POST['pwdVerif']);
            echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
        }catch (Exception $e){
            echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
        }
        die();
    }

    try{
        \app\Log::forgottenPwd($_POST['email']);
        echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
    }catch (Exception $e){
        echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
    }
    die();
}



$html = new \general\HTML();
$script_vendor = array(
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js'
);
$script = array('forbPassword.js');

if(isset($_GET[\app\User::$user_marker]))
    if(\app\Log::userExist(\general\crypt::decrypt($_GET[\app\User::$user_marker]))){
        $gabarit = \general\Language::translate_gabarit('pages/forbPassword_part2');
        $gabarit = str_replace(['{id_val}','{id_name}'],[$_GET[\app\User::$user_marker],\app\User::$user_marker],$gabarit);
    }
    else
        header('Location: index.php');
else
    $gabarit = \general\Language::translate_gabarit('pages/forbPassword');



$html->open();
echo $gabarit;
$html->close($script_vendor,$script);