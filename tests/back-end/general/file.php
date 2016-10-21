<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 09/10/16
 * Time: 11:50
 */


include_once '../../../private/config.php';

var_dump($dd = general\file::file_infos($_FILES['file']));
echo "<br>";
var_dump($dd = general\file::file_infos('crypt.php'));
echo "<br><br>";


try{
    general\file::upload('.',$_FILES['file'],null,'photo.jpg',true,'png',['jpeg','png']);
}catch(Exception $e)
{
    echo $e->getMessage();
}

?>

<form method="post" action="#" enctype="multipart/form-data">
    <input name="file" type="file" multiple>
    <button type="submit">Envoyer</button>
</form>