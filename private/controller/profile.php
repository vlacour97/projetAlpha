<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 03/12/16
 * Time: 21:52
 */


if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../config.php";

    switch($_GET['action']){
        case 'change_password':
            try{
                \app\Log::change_password(\app\Log::get_id(),$_POST['admin_password'],$_POST['admin_password_confirmation']);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
        case 'change_user_data':
            try{
                \app\User::set_user(\app\Log::get_id(),$_POST['admin_name'],$_POST['admin_fname'],\app\Log::get_type(),$_POST['admin_email'],$_POST['admin_phone'],$_POST['admin_address'],$_POST['admin_zip_code'],$_POST['admin_city'],$_POST['admin_country'],$_POST['admin_language']);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
        case 'get_user_card' :
            $user = \app\User::get_user(\app\Log::get_id());
            $gabarit = \general\Language::translate_gabarit('components/user_card');

            $replace = array('{user-fname}','{user-name}','{user-status}','{user-phone}','{user-email}','{user-city}','{user-country}','{profile-img}');
            $by = array($user->fname,$user->name,\general\Language::get_user_type_text()[intval($user->type)-1],$user->phone,$user->email,$user->city,$user->country,\app\User::get_profile_photo(\app\Log::get_id()));
            $gabarit = str_replace($replace,$by,$gabarit);

            echo $gabarit;
            break;
    }

    die();
}

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/profile');


$scripts_vendor = array(
    'select2/select2.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/modal.js',
    'bootstrap3-wysihtml5/lib/js/wysihtml5-0.3.0.min.js',
    'bootstrap3-wysihtml5/src/bootstrap3-wysihtml5.js',
    'underscore/underscore-min.js',
    'backbone/backbone.js',
    'jasny-bootstrap/js/fileinput.js',
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js'
);
$scripts = ['profile.js'];

$user = \app\User::get_user(\app\Log::get_id());
$gabarit = str_replace('{user_card}',\general\Language::translate_gabarit('components/user_card'),$gabarit);
$gabarit = str_replace(['{select/countries}','{select/language}'],[$html->select()->country($user->country),$html->select()->language($user->language)],$gabarit);

$replace = array('{user-fname}','{user-name}','{user-status}','{user-phone}','{user-email}','{user-address}','{user-zip}','{user-city}','{user-country}','{profile-img}');
$by = array($user->fname,$user->name,\general\Language::get_user_type_text()[intval($user->type)-1],$user->phone,$user->email,$user->address,$user->zip_code,$user->city,$user->country,\app\User::get_profile_photo(\app\Log::get_id()));
$gabarit = str_replace($replace,$by,$gabarit);

$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($scripts_vendor,$scripts);