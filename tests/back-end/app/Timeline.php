<?php
/**
 * Created by PhpStorm.
 * User: remi
 * Date: 28/10/2016
 * Time: 15:18
 */

include_once '../../../private/config.php';
try{
    var_dump(\app\Timeline::save_post_attachments(6,$_FILES['remi']));
}
catch(Exception $e){
    echo $e->getMessage();
}
/*
if(\app\Timeline::add_comment(6,7,"testAddComment"))
echo 'ok';*/
/*
if(\app\Timeline::delete_comment(28))
echo 'ok';
*/
/*
$path_file = POST_CONTENT.'/'.$_FILES['remi']['name'];

echo $path_file;

if(is_file($path_file))
echo "ouiiiii";
*/
?>

<form method="post"  action="#" enctype="multipart/form-data">
    <input type="file" name="remi">
    <input type="submit">
</form>

