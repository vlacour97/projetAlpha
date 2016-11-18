<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 16/11/16
 * Time: 21:40
 */


include '../../../private/library/other/html2pdf.php';

$html2pdf = new HTML2PDF();
$html2pdf->writeHTML('<h1>Salut</h1>');
$datas = $html2pdf->Output('test.pdf','D');