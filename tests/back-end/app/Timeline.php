<?php
/**
 * Created by PhpStorm.
 * User: remi
 * Date: 28/10/2016
 * Time: 15:18
 */

include_once '../../../private/config.php';

echo '<pre>';

/*
try{
    if(\app\Timeline::save_post_attachments(6,$_FILES['remi']))
    echo 'piece jointe sauvegardee<br>';
}
catch(Exception $e){
    echo $e->getMessage();
}


/*if(\app\Timeline::add_comment(6,7,"testAddComment"))
echo 'commentaire ajoute<br>';
*/


/*if(\app\Timeline::delete_comment(45))
echo 'commentaire supprime<br>';
*/
/*
if(\app\Timeline::like(6,52));
    echo 'like ajoute<br>';

if(\app\Timeline::unlike(6,9))
   echo 'like enleve<br>';




$path_file = POST_CONTENT.$_FILES['remi']['name'];
var_dump($_FILES);

echo $path_file.'<br>';
if(is_file($path_file))
echo "c'est bien un fichier t'as vu<br>";

/*echo "test du get_all_posts()<br>";
echo "<pre>";
\app\Timeline::init();
$comment = new \app\TimelineDatas();


/*foreach($var as $key=>$content){
    if(is_string($key))
        echo 'public $'.$key.';<br>';

}


$var = \app\Timeline::get_all_posts();
//\app\Timeline::format_datas($var,$comment);
var_dump($var);
*/


var_dump(\app\Timeline::get_all_posts());




?>
<form method="post" enctype="multipart/form-data">
    <input  type="file" name="remi">
    <button type="submit">Envoyer</button>
</form>





