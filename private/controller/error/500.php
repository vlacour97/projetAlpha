<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 03/12/16
 * Time: 21:39
 */

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/500');

$html->open();
echo $gabarit;
$html->close();