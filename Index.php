<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 06/10/16
 * Time: 09:45
 */

include "private/config.php";

$global_pages = array('forbiden_password','active_user');
/*
//Si l'API n'est pas installé
if(!\app\Install::APP_is_installed()){
    include "private/controller/install.php";
    die();
}

//Si déconnexion demandé
if($_GET[\app\Navigation::$navigation_marker] == \app\Log::$logout_marker){
    \app\Log::logout();
    header('Location: index.php');
}


//Si une page globale est demandé
if(in_array($_GET[\app\Navigation::$navigation_marker],$global_pages)){
    include "private/controller/".$_GET[\app\Navigation::$navigation_marker].".php";
    die();
}

//Si l'utilisateur n'est pas connecté
if(!\app\Log::isLogged()){

    //S'il peut acceder au lockscreen
    if(app\Log::need_to_lockscreen()){
        include "private/controller/lockscreen.php";
        die();
    }

    include "private/controller/login.php";
    die();
}

\app\Log::set_stat();*/

\app\Navigation::get_pages();


