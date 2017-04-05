<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 05/04/17
 * Time: 22:35
 */

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/about');

//Integration des fichiers
$script_vendor = array(
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js'
);
$script = array('create_account.js');

$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($scripts_vendor,$scripts);