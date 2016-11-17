<?php
/**
 * Created by PhpStorm.
 * User: remi
 * Date: 28/10/2016
 * Time: 15:18
 */

include_once '../../../private/config.php';
/*try{
    if(\app\Timeline::save_post_attachments(6,$_FILES['remi']))
    echo 'ok';
}
catch(Exception $e){
    echo $e->getMessage();
}

if(\app\Timeline::add_comment(6,7,"testAddComment"))
echo 'ok';

if(\app\Timeline::delete_comment(28))
echo 'ok';


$path_file = POST_CONTENT.'/'.$_FILES['remi']['name'];

echo $path_file;

if(is_file($path_file))
echo "ouiiiii";

?>

<form method="post"  action="#" enctype="multipart/form-data">
    <input type="file" name="remi">
    <input type="submit">
</form>
*/

echo "<pre>";
\app\Timeline::init();
//$comment = new \app\LikesDatas();
$var=\general\PDOQueries::show_posts(6)[0];
foreach($var as $key=>$content){
    if(is_string($key))
        echo 'public $'.$key.';<br>';

}
//\app\Timeline::format_datas($var,$comment);
//var_dump($comment);

