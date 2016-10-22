<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 08/10/16
 * Time: 14:56
 */


/**
 * Inclusion des function génériques
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/private/functions/db_connect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/private/functions/autoloader.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/private/functions/linker.php';

/**
 * Définition des variables globales
 */

//Paths
define('AVATAR_IMG',$_SERVER['DOCUMENT_ROOT'].'/private/datas/users/');
define('POST_CONTENT',$_SERVER['DOCUMENT_ROOT'].'/private/datas/posts/');

//Autres
define('CRYPT_KEY','alpha');


/**
 * Lancement des tâches d'initialisation
 */

\general\PDOQueries::init();