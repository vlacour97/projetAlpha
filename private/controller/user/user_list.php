<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 02/12/16
 * Time: 16:32
 */

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../../config.php";

    switch($_GET['action']){
        case 'get_add_user_form_hand':
            $html = new \general\HTML();
            $select = $html->select();
            $gabarit = \general\Language::translate_gabarit('components/add_user');
            $gabarit = str_replace(['{type_list}','{country_list}','{language_list}','{boolChose_list}'],[$select->type(),$select->country(),$select->language(),$select->boolChose(0)],$gabarit);
            echo $gabarit;
            break;
        case 'add_user_form_hand':
            try{
                \app\User::registration_by_admin($_POST['add_user_email'],intval($_POST['add_user_type']),boolval($_POST['add_user_publication']),$_POST['add_user_name'],$_POST['add_user_fname'],$_POST['add_user_phone'],$_POST['add_user_address'],$_POST['add_user_zip_code'],$_POST['add_user_city'],$_POST['add_user_country'],$_POST['add_user_language']);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
        case 'upload_csv_file' :
            try{
                $content = \app\User::upload_and_analyses_csv($_FILES[0],$_POST['nb_row'],$_POST['nb_col']);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null,'data' => $content,'attr' => \general\Language::get_csv_attributes()));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
        case 'save_csv_list':
            try{
                $data = explode(',',$_POST['data']);
                \app\User::save_csv_datas($data,$_POST['nb_row'],$_POST['nb_col']);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (\app\AddCSVDataException $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode(),'items' => $e->getItems()));
            }
            break;
        case 'delete_user':
            try{
                if(\app\User::delete_user(intval(\general\crypt::decrypt($_GET['id']))))
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
        case 'get_table_datas':
            $users = \app\User::get_all_users();
            $data = array();
            foreach($users as $user){
                /** @var $user \app\UserDatas */

                $action = \general\Language::translate_gabarit('components/parts/user_actions');
                $action = str_replace(['{ID}','{link_contact}'],[\general\crypt::encrypt($user->ID),'?'.\app\Navigation::$navigation_marker.'=message&action=send&id='.\general\crypt::encrypt($user->ID)],$action);

                $data[] = array(
                    sprintf('%04d',$user->ID),
                    '<div class="checkbox"><input data-id="'.\general\crypt::encrypt($user->ID).'" type="checkbox" id="inlineCheckbox'.\general\crypt::encrypt($user->ID).'"><label for="inlineCheckbox'.\general\crypt::encrypt($user->ID).'"></label></div>',
                    '<span class="fw-semi-bold"><a data-id="'.\general\crypt::encrypt($user->ID).'" class="user">'.htmlentities($user->fname).' '.htmlentities($user->name).'</a></span>',
                    htmlentities(\general\Language::get_user_type_text()[$user->type-1]),
                    $action
                );
            }
            echo json_encode(["data"=>$data]);
            break;
        case 'get_user_infos':
            $user = \app\User::get_user(intval(\general\crypt::decrypt($_GET['id'])));
            $gabarit = \general\Language::translate_gabarit('components/user_infos');

            $replace = array('{user-profile-img}','{user-name}','{user-status}','{user-mail}','{user-phone}','{user-address}','{user-city}','{user-country}','{user-zip-code}');
            $by = array(\app\User::get_profile_photo($user->ID),$user->fname.' '.$user->name,\general\Language::get_user_type_text()[$user->type-1],$user->email,$user->phone,$user->address,$user->city,$user->country,$user->zip_code);
            $gabarit = str_replace($replace,$by,$gabarit);
            echo $gabarit;
            break;
        case 'get_edit_user_form':
            $gabarit = \general\Language::translate_gabarit('components/edit_user');
            $user = \app\User::get_user(intval(\general\crypt::decrypt($_GET['id'])));
            $html = new \general\HTML();

            $replace = array('{name}','{fname}','{email}','{phone}','{address}','{zip-code}','{city}','{country_list}','{language_list}','{type_list}','{boolChose_list}');
            $by = array($user->name,$user->fname,$user->email,$user->phone,$user->address,$user->zip_code,$user->city,$html->select()->country($user->country),$html->select()->language($user->language),$html->select()->type($user->type),$html->select()->boolChose($user->publication_entitled));
            $gabarit = str_replace($replace,$by,$gabarit);
            echo $gabarit;
            break;
        case 'change_user':
            try{
                $id = \general\crypt::decrypt($_GET['id']);
                \app\User::set_user($id,$_POST['edit_user_name'],$_POST['edit_user_fname'],intval($_POST['edit_user_type']),$_POST['edit_user_email'],$_POST['edit_user_phone'],$_POST['edit_user_editress'],$_POST['edit_user_zip_code'],$_POST['edit_user_city'],$_POST['edit_user_country'],$_POST['edit_user_language'],boolval($_POST['edit_user_publication']));
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
    }

    die();
}

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/admin_userList');

$script_vendor = array(
    'underscore/underscore-min.js',
    'backbone/backbone.js',
    'backbone.paginator/lib/backbone.paginator.min.js',
    'backgrid/lib/backgrid.js',
    'backgrid-paginator/backgrid-paginator.js',
    'datatables/media/js/jquery.dataTables.js',
    'bootstrap-select/bootstrap-select.min.js',
    'parsleyjs/dist/parsley.min.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/tab.js',
    'twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js',
    'select2/select2.js',
    'moment/min/moment.min.js',
    'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    'jasny-bootstrap/js/inputmask.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/popover.js',
    'bootstrap-application-wizard/src/bootstrap-wizard.js',
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js',
    'jasny-bootstrap/js/fileinput.js'
);
$script = array('UserList.js');


$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);