<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 04/12/16
 * Time: 19:51
 */


if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../config.php";

    try{
        $date = new \general\Date($_POST['config_deadline']);
        \app\Config::create_config_file($_POST['config_name'],$_POST['config_description'],$_POST['config_keyword'],$_POST['config_author'],$_POST['config_admin_mail'],$date->format('yyyy-mm-dd'),$_POST['config_author']);
        echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
    }catch (Exception $e){
        echo json_encode(array('response'=>true,'exception'=>$e->getMessage(),'code' => $e->getCode()));
    }
    die();
}

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/manage_API');


$scripts_vendor = array(
    'select2/select2.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/modal.js',
    'bootstrap3-wysihtml5/lib/js/wysihtml5-0.3.0.min.js',
    'bootstrap3-wysihtml5/src/bootstrap3-wysihtml5.js',
    'moment/min/moment.min.js',
    'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    'jasny-bootstrap/js/inputmask.js',
    'underscore/underscore-min.js',
    'backbone/backbone.js',
    'jasny-bootstrap/js/fileinput.js',
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js'
);
$scripts = ['manage_APi.js'];

$deadlineDate = new \general\Date(\app\Config::getDeadlineDate());

$replace = array('{sitename}','{describe}','{keywords}','{organisationName}','{managerEmail}','{deathdate}','{APIKey}');
$by = array(\app\Config::getName(),\app\Config::getDescription(),\app\Config::getKeywords(),\app\Config::getAuthor(),\app\Config::getAdminMail(),$deadlineDate->format('mm/dd/yyyy'),\app\Config::getWeatherAPIKey());
$gabarit = str_replace($replace,$by,$gabarit);

$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($scripts_vendor,$scripts);