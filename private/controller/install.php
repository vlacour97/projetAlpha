<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 22/11/16
 * Time: 23:50
 */


if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../config.php";

    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'testBDConnection':
                try{
                    \app\Install::PDO_connect($_POST['host'],$_POST['bdname'],$_POST['username'],$_POST['password']);
                    echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
                }catch (Exception $e){
                    echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
                }
                break;
        }
        die();
    }
    if(!isset($_GET['step']))
        die();
    switch($_GET['step']){
        case 1:
            try{
                \app\Install::PDO_install($_POST['host'],$_POST['bdname'],$_POST['username'],$_POST['password'],$_POST['prefix']);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>true,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
        case 2:
            try{
                $date = new \general\Date($_POST['config_deadline']);
                \app\Install::Config_install($_POST['config_name'],$_POST['config_description'],$_POST['config_keyword'],$_POST['config_author'],$_POST['config_admin_mail'],$date->format('yyyy-mm-dd'),$_POST['config_author']);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>true,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
        case 3:
            try{
                \app\Install::Admin_install($_POST['admin_email'],$_POST['admin_name'],$_POST['admin_fname'],$_POST['admin_password'],$_POST['admin_password_confirmation'],$_POST['admin_phone'],$_POST['admin_address'],$_POST['admin_zip_code'],$_POST['admin_city'],$_POST['admin_country'],$_POST['admin_language']);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>true,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
        case 4:
            try{
                \app\Install::Survey_install();
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>true,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
    }
    die();
}

$html = new \general\HTML();


$scripts_vendor = array('parsleyjs/dist/parsley.min.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/tab.js',
    'twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js',
    'select2/select2.js',
    'moment/min/moment.min.js',
    'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    'jasny-bootstrap/js/inputmask.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/modal.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/popover.js',
    'bootstrap-application-wizard/src/bootstrap-wizard.js',
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js'
);
$scripts = array('install.js');
$gabarit = \general\Language::translate_gabarit('pages/install');
$gabarit = str_replace('{script/step}',\app\Install::get_step(),$gabarit);
$gabarit = str_replace(['{select/countries}','{select/language}'],[$html->select()->country(),$html->select()->language()],$gabarit);



$html->open();
echo $gabarit;
$html->close($scripts_vendor,$scripts);