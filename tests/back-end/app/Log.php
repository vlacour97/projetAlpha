<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 29/10/16
 * Time: 21:18
 */

include_once '../../../private/config.php';

//var_dump($_SESSION);

/*
try{
    \app\Log::login('vlacour97@icloud.com','azerty');
}catch(Exception $e){
    echo $e->getMessage();
}
*/
//var_dump(\app\Log::logout());
//var_dump(\app\Log::isLogged());
//unset($_SESSION['id']);
//var_dump(\app\Log::need_to_lockscreen());
//var_dump(\app\Log::get_lang());
//var_dump(\app\Log::set_lang('fr_FR'));
//var_dump(\app\Log::update_status());
//var_dump(\app\Log::get_OS());
//var_dump(\app\Log::get_browser());
//var_dump(\app\Log::get_platform());
//var_dump(\app\Log::get_ip());
//var_dump(\app\Log::get_country('82.127.213.222'));
//var_dump(\app\Log::set_stat());
//unset($_SESSION['id']);
//\app\Log::stay_connected('azerty');
/*try{
    var_dump(\app\Log::get_id());
}catch (Exception $e)
{
    echo $e->getMessage();
}*/
//var_dump($_SESSION);
/*
try
{
    var_dump(\app\Log::registration_by_admin('val_97@live.fr',2,true,'Valentin','Lacour','','','','','',''));
}catch (Exception $e)
{
    echo $e->getMessage();
}*/
try{
    var_dump(\app\Log::registration_by_user(11,'azertyui','azertyui','Valentin','Lacour'));
}catch (Exception $e)
{
    echo $e->getMessage();
}

