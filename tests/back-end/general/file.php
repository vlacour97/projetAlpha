<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 09/10/16
 * Time: 11:50
 */


include_once '../../../private/config.php';

if(isset($_FILES['file'])) var_dump($dd = general\file::file_infos($_FILES['file']));
echo "<br>";
var_dump($dd = general\file::file_infos('crypt.php'));
echo "<br><br>";


try{
    if(isset($_FILES['file'])) general\file::upload('.',$_FILES['file'],null,'photo.jpg',true);
}catch(Exception $e)
{
    if($e->getCode() == 1)
        echo "Warning: ".$e->getMessage();
    if($e->getCode() == 2)
        echo "Danger: ".$e->getMessage();
}

?>

<form method="post" action="#" enctype="multipart/form-data">
    <input name="file" type="file" multiple>
    <button type="submit">Envoyer</button>
</form>