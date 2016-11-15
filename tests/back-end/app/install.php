<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 14/11/16
 * Time: 18:36
 */

include "../../../private/config.php";

echo '<pre>';

/*
try{
    var_dump(\app\Install::PDO_connect('109.31.179.110','projetIUT','projetiut','projetiut'));
}catch (Exception $e){
    echo $e->getMessage().' -- '.$e->getCode();
}*/
try{
    //var_dump(\app\Install::PDO_install('localhost','projetIUT','root','root','site2_'));
    //var_dump(\app\Install::create_db_datas_file('localhost','projetIUT','root','root','site3_'));
    var_dump(\app\Install::get_step());
    var_dump(\app\Install::APP_is_installed());
}catch (Exception $e){
    echo $e->getMessage().' -- '.$e->getCode();
}