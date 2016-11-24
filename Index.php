<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 06/10/16
 * Time: 09:45
 */

include "private/config.php";

//Si l'API n'est pas installé
if(!\app\Install::APP_is_installed()){
    include "private/controller/install.php";
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

\app\Navigation::get_pages();

echo 'ok';