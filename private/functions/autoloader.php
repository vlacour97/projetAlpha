<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 08/10/16
 * Time: 14:41
 */

//Auto-chargement des classes PHP
function __autoload($class){
    $class = str_replace('\\', '/', $class);
    $path = $_SERVER['DOCUMENT_ROOT']."/private/library/{$class}.php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
}