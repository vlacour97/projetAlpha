<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 02/12/16
 * Time: 21:00
 */

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../config.php";

    switch($_GET['action']){
        case 'get_table_datas':
            switch(\app\Log::get_type()){
                case 2:
                    $students = \app\User::get_all_students(\app\Log::get_id());
                    $data = array();

                    foreach($students as $student){
                        /** @var $student \app\StudentDatas */

                        if($student->answered){
                            if($student->answers_is_valided)
                                $status = 'fa-check';
                            else
                                $status = 'fa-clock-o';
                            $action = \general\Language::translate_gabarit('components/parts/see_survey');
                            $action = str_replace('{link}','?nav=see_survey&id='.\general\crypt::encrypt($student->ID),$action);
                        }
                        else{
                            $status = 'fa-times';
                            $action = \general\Language::translate_gabarit('components/parts/answer_survey');
                            $action = str_replace('{link}','?nav=answer_survey&id='.\general\crypt::encrypt($student->ID),$action);
                        }


                        $data[] = array(
                            sprintf('%04d',$student->ID),
                            '<span class="fw-semi-bold"><a class="student" data-id="'.\general\crypt::encrypt($student->ID).'" >'.htmlentities($student->name.' '.$student->fname).'</a></span>',
                            '<span class="fw-semi-bold"><a class="user" data-id="'.\general\crypt::encrypt($student->ID_TI).'">'.htmlentities($student->name_TI).'</a></span>',
                            "<p class='text-center'><i class='fa $status'></i></p>",
                            htmlentities($student->deadline_date->format('d MM yyyy')),
                            $action
                        );
                    }
                    echo json_encode(["data"=>$data]);
                    break;
                case 3:
                    $students = \app\User::get_all_students(\app\Log::get_id());
                    $data = array();

                    foreach($students as $student){
                        /** @var $student \app\StudentDatas */

                        if($student->answered){
                            if($student->answers_is_valided)
                                $status = 'fa-check';
                            else
                                $status = 'fa-clock-o';
                            $action = \general\Language::translate_gabarit('components/parts/see_survey');
                            $action = str_replace('{link}','?nav=see_survey&id='.\general\crypt::encrypt($student->ID),$action);
                        }
                        else{
                            $status = 'fa-times';
                            $action = \general\Language::translate_gabarit('components/parts/refresh_te');
                            $action = str_replace(['{ID_user}','{ID_student}'],[\general\crypt::encrypt($student->ID_TE),\general\crypt::encrypt($student->ID)],$action);
                        }


                        $data[] = array(
                            sprintf('%04d',$student->ID),
                            '<span class="fw-semi-bold"><a class="student" data-id="'.\general\crypt::encrypt($student->ID).'" >'.htmlentities($student->name.' '.$student->fname).'</a></span>',
                            '<span class="fw-semi-bold"><a class="user" data-id="'.\general\crypt::encrypt($student->ID_TE).'">'.htmlentities($student->name_TE).'</a></span>',
                            "<p class='text-center'><i class='fa $status'></i></p>",
                            htmlentities($student->deadline_date->format('d MM yyyy')),
                            $action
                        );
                    }
                    echo json_encode(["data"=>$data]);
                    break;
                    break;
            }

            break;
        case 'get_student_infos':
            $student = \app\User::get_student(intval(\general\crypt::decrypt($_GET['id'])));
            $gabarit = \general\Language::translate_gabarit('components/student_infos');

            $replace = array('{student-profile-img}','{student-name}','{student-group}','{student-mail}','{student-phone}','{student-address}','{student-city}','{student-country}','{student-zip-code}','{deadline}');
            $by = array(\app\User::get_profile_photo(0),$student->fname.' '.$student->name,$student->group,$student->email,$student->phone,$student->address,$student->city,$student->country,$student->zip_code,$student->deadline_date->format('WW d MM yyyy'));
            $gabarit = str_replace($replace,$by,$gabarit);
            echo $gabarit;
            break;
        case 'get_user_infos':
            $user = \app\User::get_user(intval(\general\crypt::decrypt($_GET['id'])));
            $gabarit = \general\Language::translate_gabarit('components/user_infos');

            $replace = array('{student-profile-img}','{student-name}','{student-mail}','{student-phone}','{student-address}','{student-city}','{student-country}','{student-zip-code}');
            $by = array(\app\User::get_profile_photo(0),$user->fname.' '.$user->name,$user->email,$user->phone,$user->address,$user->city,$user->country,$user->zip_code);
            $gabarit = str_replace($replace,$by,$gabarit);
            echo $gabarit;
            break;
        case 'refresh_user':
            try{
                $id_student = intval(\general\crypt::decrypt($_GET['idStudent']));
                $id_user = intval(\general\crypt::decrypt($_GET['idUser']));
                \app\Notifications::wait_survey($id_student);
                \general\mail::send_answer_email($id_user);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
    }
    die();
}

$html = new \general\HTML();
if(\app\Log::get_type() == 3)
    $gabarit = \general\Language::translate_gabarit('pages/ti_studentList');
else
    $gabarit = \general\Language::translate_gabarit('pages/te_studentList');

$script_vendor = array(
    'underscore/underscore-min.js',
    'backbone/backbone.js',
    'backbone.paginator/lib/backbone.paginator.min.js',
    'backgrid/lib/backgrid.js',
    'backgrid-paginator/backgrid-paginator.js',
    'datatables/media/js/jquery.dataTables.js',
    'bootstrap-select/bootstrap-select.min.js',
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js'
);
$script = "student_list_te.js";


$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);