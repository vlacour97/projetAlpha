<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 26/10/16
 * Time: 13:25
 */



class mainClass {

    static $lang;
    static $form_date = "d MM yyyy {at} hh{h}mn";

    static function init(){
        require_once $_SERVER['DOCUMENT_ROOT'].'/private/config.php';
        self::$lang = \app\Config::getDefaultLanguage();
    }

} 