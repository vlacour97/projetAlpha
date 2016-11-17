<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 11/11/16
 * Time: 17:14
 */

include_once '../../../private/config.php';

//var_dump(\app\Navigation::get_page_id());
//var_dump(\app\Navigation::isAutorised(\app\Navigation::get_page_id()));
var_dump(\app\Navigation::get_title());
\app\Navigation::get_pages();

$navbar = \app\Navigation::get_navbar();


echo '<ul>';
foreach($navbar as $navbarLine)
{
    echo '<a href="'.$navbarLine->link.'"><li>'.$navbarLine->name.'</li></a>';
    $toggle = is_array($navbarLine->navPage);
    if($toggle)
        echo '<ul>';
    foreach($navbarLine->navPage as $toggleNavbarLine)
        echo '<a href="'.$toggleNavbarLine->link.'"><li>'.$toggleNavbarLine->name.'</li></a>';
    if($toggle)
        echo '</ul>';
}

echo '</ul>';