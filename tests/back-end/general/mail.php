<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 08/10/16
 * Time: 15:59
 */

include_once '../../../private/config.php';

//general\mail::send_email("vlacour97@icloud.com","Hey","<h1>Hey</h1>");
/*if(general\mail::send_receive_message_email(4))
    echo "ok";
else
    echo "echec";

*/

var_dump(\general\mail::feedback_bug('Bug sur la page 1','Je n\'arrive pas à faire ça :/','Moi'));