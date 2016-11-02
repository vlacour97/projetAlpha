<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 08/10/16
 * Time: 14:56
 */

session_start();

/**
 * Inclusion des function génériques
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/private/functions/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/private/functions/autoloader.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/private/functions/linker.php';

/**
 * Définition des variables globales
 */

//Paths
define('ROOT',$_SERVER['DOCUMENT_ROOT']);
define('AVATAR_IMG',$_SERVER['DOCUMENT_ROOT'].'/private/datas/users/');
define('POST_CONTENT',$_SERVER['DOCUMENT_ROOT'].'/private/datas/posts/');

//Autres
define('CRYPT_KEY','alpha');


/**
 * Lancement des tâches d'initialisation
 */

\mainClass::init();
\general\PDOQueries::init();

//TODO à retirer
\app\Log::login('vlacour97@icloud.com','azerty');