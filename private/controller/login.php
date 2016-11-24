<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 23/11/16
 * Time: 00:09
 */


if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../config.php";

    try{
        \app\Log::login($_POST['email'],$_POST['pwd'],boolval($_POST['stayConnected']));
        echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
    }catch (Exception $e){
        echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
    }
    die();
}



$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/login');
$script_vendor = array(
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js'
);

//TODO insere link
$gabarit = str_replace('{forgottenPwdLink}','LINK',$gabarit);

$html->open();
echo $gabarit;
$html->close($script_vendor,['login.js']);
