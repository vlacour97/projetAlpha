<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 08/10/16
 * Time: 14:56
 */

session_start();

/**
 * Définition des variables globales
 */

//Paths
define('ROOT',$_SERVER['DOCUMENT_ROOT']);
define('HOST','http://'.$_SERVER['HTTP_HOST']);
define('TEMP_PATH',$_SERVER['DOCUMENT_ROOT'].'/private/datas/temp/');
define('AVATAR_IMG','/private/datas/users/');
define('POST_CONTENT',$_SERVER['DOCUMENT_ROOT'].'/private/datas/posts/');
define('PATH_CONTROLLER',$_SERVER['DOCUMENT_ROOT'].'/private/controller/');
define('MESSAGE_ATTACHMENT_PATH','/private/datas/messages/');
define('CURRENT_LINK',(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

//Autres
define('CRYPT_KEY','alpha');

/**
 * Inclusion des function génériques
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/private/functions/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/private/functions/autoloader.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/private/functions/linker.php';



/**
 * Lancement des tâches d'initialisation
 */

\mainClass::init();

if(\app\Install::APP_is_installed())
    \general\PDOQueries::init();