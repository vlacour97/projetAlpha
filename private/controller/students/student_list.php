<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 25/11/16
 * Time: 23:24
 */




if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../../config.php";

    switch($_GET['action']){
        case 'get_add_user_form_hand':
            $html = new \general\HTML();
            $deathdate = new \general\Date(\app\Config::getDeadlineDate());
            $select = $html->select();
            $gabarit = \general\Language::translate_gabarit('components/add_student');
            $gabarit = str_replace(['{te_list}','{ti_list}','{country_list}','{deathdate}'],[$select->TE(),$select->TI(),$select->country(),$deathdate->format('mm/dd/yyyy')],$gabarit);
            echo $gabarit;
            break;
        case 'add_user_form_hand':
            try{
                \app\User::add_student(intval($_POST['add_student_te']),intval($_POST['add_student_ti']),$_POST['add_student_name'],$_POST['add_student_fname'],$_POST['add_student_group'],$_POST['add_student_email'],$_POST['add_student_phone'],$_POST['add_student_address'],$_POST['add_student_zip_code'],$_POST['add_student_city'],$_POST['add_student_country'],$_POST['add_student_informations'],$_POST['add_student_birthdate'],$_POST['add_student_deathdate']);
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
        case 'delete_student':
            try{
                \app\User::delete_student(intval($_GET['id']));
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
        case 'get_table_datas':
            $students = \app\User::get_all_students();
            $data = array();
            foreach($students as $student){
                /** @var $student \app\StudentDatas */

                $show_survey = '<a data-toggle="tooltip" data-placement="bottom" title="Voir le questionnaire" href="?nav=students/survey&id='.\general\crypt::encrypt($student->ID).'" target="_blank"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';
                if(!$student->answered)
                    $show_survey = "";

                $data[] = array(
                    sprintf('%04d',$student->ID),
                    '<div class="checkbox"><input data-id="'.$student->ID.'" type="checkbox" id="inlineCheckbox'.$student->ID.'"><label for="inlineCheckbox'.$student->ID.'"></label></div>',
                    '<span class="fw-semi-bold"><a data-id="'.$student->ID.'" class="student">'.htmlentities($student->fname).' '.htmlentities($student->name).'</a></span>',
                    htmlentities($student->name_TI),
                    htmlentities($student->name_TE),
                    '<p class="text-center">'.$show_survey.'<a class="change" data-toggle="tooltip" data-id="'.$student->ID.'" data-placement="bottom" title="Modifier"><i class="fa fa-wrench"></i></a>&nbsp;&nbsp;<a class="delete" data-id="'.$student->ID.'" data-toggle="tooltip" data-placement="bottom" title="Supprimer"><i class="fa fa-trash-o" aria-hidden="true"></i></a></p>' //TODO textes de langues
                );
            }
            echo json_encode(["data"=>$data]);
            break;
        case 'get_student_infos':
            $student = \app\User::get_student(intval($_GET['id']));
            $gabarit = \general\Language::translate_gabarit('components/student_infos');

            $replace = array('{student-profile-img}','{student-name}','{student-group}','{student-mail}','{student-phone}','{student-address}','{student-city}','{student-country}','{student-zip-code}','{deadline}');
            $by = array(\app\User::get_profile_photo(0),$student->fname.' '.$student->name,$student->group,$student->email,$student->phone,$student->address,$student->city,$student->country,$student->zip_code,$student->deadline_date->format('WW d MM yyyy'));
            $gabarit = str_replace($replace,$by,$gabarit);
            echo $gabarit;
            break;
        case 'get_edit_student_form':
            $gabarit = \general\Language::translate_gabarit('components/edit_student');
            $student = \app\User::get_student(intval($_GET['id']));
            $html = new \general\HTML();

            $replace = array('{name}','{fname}','{email}','{group}','{birth-date}','{phone}','{address}','{zip-code}','{city}','{country_list}','{informations}','{deathdate}','{te_list}','{ti_list}');
            $by = array($student->name,$student->fname,$student->email,$student->group,$birthDate,$student->phone,$student->address,$student->zip_code,$student->city,$html->select()->country($student->country),$student->informations,$student->deadline_date->format('mm/dd/yyyy'),$html->select()->TE($student->ID_TE),$html->select()->TI($student->ID_TI));
            $gabarit = str_replace($replace,$by,$gabarit);

            echo $gabarit;
            break;
        case 'change_student':
            try{
                \app\User::set_student(intval($_GET['id']),intval($_POST['edit_student_te']),intval($_POST['edit_student_ti']),$_POST['edit_student_name'],$_POST['edit_student_fname'],$_POST['edit_student_group'],$_POST['edit_student_email'],$_POST['edit_student_phone'],$_POST['edit_student_address'],$_POST['edit_student_zip_code'],$_POST['edit_student_city'],$_POST['edit_student_country'],$_POST['edit_student_informations'],$_POST['edit_student_birthdate'],$_POST['edit_student_deathdate']);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
            break;
    }

    die();
}

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/admin_studentList');

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
$script = "student_list.js";


$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);