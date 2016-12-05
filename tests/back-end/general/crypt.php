<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 08/10/16
 * Time: 15:17
 */

include_once '../../../private/config.php';

$crypt = general\crypt::encrypt(54);
echo $crypt."<br>";
echo general\crypt::decrypt($crypt);