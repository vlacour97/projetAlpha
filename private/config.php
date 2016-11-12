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
define('HOST',$_SERVER['HTTP_HOST']);
define('TEMP_PATH',$_SERVER['DOCUMENT_ROOT'].'/private/datas/temp/');
define('AVATAR_IMG',$_SERVER['DOCUMENT_ROOT'].'/private/datas/users/');
define('POST_CONTENT',$_SERVER['DOCUMENT_ROOT'].'/private/datas/posts/');
define('PATH_CONTROLLER',$_SERVER['DOCUMENT_ROOT'].'/private/controller/');

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
\general\PDOQueries::init();

//TODO à retirer
\app\Log::login('vlacour97@icloud.com','azerty');