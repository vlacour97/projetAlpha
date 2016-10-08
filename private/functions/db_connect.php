<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 08/10/16
 * Time: 14:50
 */

//Fonction de connexion à la base de données
function db_connect(){
    include_once $_SERVER['DOCUMENT_ROOT']."/private/functions/linker.php";
    $datas = link_parameters("app/db_datas");

    $dsn = 'mysql:dbname='.$datas['db_name'].';host='.$datas['host'];
    $user = $datas['login'];
    $password = $datas['password'];

    try {
        return new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        die('Connexion échouée : ' . $e->getMessage());
    }
}