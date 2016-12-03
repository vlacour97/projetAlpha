<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 03/12/16
 * Time: 21:25
 */


$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/403');

$html->open();
echo $gabarit;
$html->close();