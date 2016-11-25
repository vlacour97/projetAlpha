<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 22/10/16
 * Time: 10:15
 */

namespace general;


class PDOQueries extends \mainClass{

    /**
     * @var \PDO
     */
    private static $PDO;
    private static $prefix;

    static function init(){
        parent::init();
        self::$PDO = db_connect();
        self::$prefix = link_parameters("app/db_datas")['prefix'];
    }

    //Views
    static function show_action_report(){
        return self::$PDO->query('SELECT * FROM '.self::$prefix.'show_action_report')->fetchAll();
    }

    static function show_all_students(){
        return self::$PDO->query('SELECT * FROM '.self::$prefix.'show_all_students')->fetchAll();
    }

    static function show_all_users(){
        return self::$PDO->query('SELECT * FROM '.self::$prefix.'show_all_users')->fetchAll();
    }

    static function show_answered_students(){
        return self::$PDO->query('SELECT * FROM '.self::$prefix.'show_answered_students')->fetchAll();
    }

    static function show_deleted_students(){
        return self::$PDO->query('SELECT * FROM '.self::$prefix.'show_deleted_students')->fetchAll();
    }

    static function show_deleted_users(){
        return self::$PDO->query('SELECT * FROM '.self::$prefix.'show_deleted_users')->fetchAll();
    }

    static function show_last_stats_by_user(){
        return self::$PDO->query('SELECT * FROM '.self::$prefix.'show_last_stats_by_user')->fetchAll();
    }

    static function show_all_posts(){
        return self::$PDO->query('SELECT * FROM '.self::$prefix.'show_posts')->fetchAll();
    }

    static function show_te_users(){
        return self::$PDO->query('SELECT * FROM '.self::$prefix.'show_te_users')->fetchAll();
    }

    static function show_ti_users(){
        return self::$PDO->query('SELECT * FROM '.self::$prefix.'show_ti_users')->fetchAll();
    }

    static function show_unactivated_users(){
        return self::$PDO->query('SELECT * FROM '.self::$prefix.'show_unactivated_users')->fetchAll();
    }

    //Procedure
    /**
     * Active un utilisateur
     * @param int $id_user
     * @return bool
     */
    static function activate_user($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'activate_user(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Ajoute un réponse
     * @param int $id_student
     * @param int $id_survey
     * @param int $id_question
     * @param int $id_answer
     * @param string $comments
     * @return bool
     */
    static function add_answer($id_student,$id_survey,$id_question,$id_answer,$comments){
        if(!is_int($id_student) || !is_int($id_survey) || !is_int($id_question) || !is_int($id_answer) || !is_string($comments))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'add_answer(:id_student,:id_survey,:id_question,:id_answer,:comments)')->execute(array(':id_student'=>$id_student,':id_survey'=>$id_survey,':id_question' => $id_question,':id_answer' => $id_answer,':comments' => $comments));
    }

    /**
     * Ajoute un commentaire à une publication
     * @param int $id_post
     * @param int $id_user
     * @param string $content
     * @return bool
     */
    static function add_comment($id_post,$id_user,$content){
        if(!is_int($id_post) OR !is_int($id_user) OR !is_string($content))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'add_comment(:id_post,:id_user,:content)')->execute(array(':id_post' => $id_post,':id_user' => $id_user,':content' => $content));
    }

    /**
     * Ajoute une piéce jointe à un message
     * @param int $id_message
     * @param string $link
     * @param string $description
     * @param string $type_file
     * @return bool
     */
    static function add_message_attachment($id_message, $link, $description, $type_file){
        if(!is_int($id_message) OR !is_string($link) OR !is_string($description) OR !is_string($type_file))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'add_message_attachment(:id_message,:link,:description,:type_file)')->execute(array(':id_message' => $id_message,':link' => $link,':description' => $description,':type_file' => $type_file));
    }

    /**
     * Ajoute un notification
     * @param int $id_user
     * @param string $content
     * @param string $link
     * @return bool
     */
    static function add_notification($id_user,$content,$link){
        if(!is_int($id_user) OR !is_string($content) OR !is_string($link))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'add_notification(:id_user,:content,:link)')->execute(array(':id_user' => $id_user,':content' => $content,':link' => $link));
    }

    /**
     * Ajoute une publication
     * @param int $id_user
     * @param string $content
     * @return bool
     */
    static function add_post($id_user,$content){
        if(!is_int($id_user) OR !is_string($content))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'add_notification(:id_user,:content)')->execute(array(':id_user' => $id_user,':content' => $content));
    }

    /**
     * Ajoute une piece jointe à une publication
     * @param int $id_post
     * @param string $link
     * @param string $description
     * @param string $type_file
     * @return bool
     */
    static function add_post_attachement($id_post, $link, $description, $type_file){
        if(!is_int($id_post) OR !is_string($link) OR !is_string($description) OR !is_string($type_file))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'add_post_attachement(:id_post, :link, :description, :type_file)')->execute(array(':id_post' => $id_post,':link' => $link,':description' => $description,':type_file' => $type_file));
    }

    /**
     * Ajoute une statistique
     * @param int $id_user
     * @param string $page_viewed
     * @param string $ip_viewer
     * @param string $country_viewer
     * @param string $platform_viewer
     * @param string $os_viewer
     * @param string $browser_viewer
     * @return bool
     */
    static function add_statistic($id_user,$page_viewed,$ip_viewer,$country_viewer,$platform_viewer,$os_viewer,$browser_viewer){
        if(!is_int($id_user) OR !is_string($page_viewed) OR !is_string($ip_viewer) OR !is_string($country_viewer) OR !is_string($platform_viewer) OR !is_string($os_viewer) OR !is_string($browser_viewer))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'add_statistic(:id_user,:page_viewed,:ip_viewer,:country_viewer,:platform_viewer,:os_viewer,:browser_viewer)')->execute(array(':id_user' => $id_user,':page_viewed' => $page_viewed,':ip_viewer' => $ip_viewer,':country_viewer' => $country_viewer,':platform_viewer' => $platform_viewer,':os_viewer' => $os_viewer,':browser_viewer' => $browser_viewer));
    }

    /**
     * Ajoute un étudiant
     * @param int $id_te
     * @param int $id_ti
     * @param string $name
     * @param string $fname
     * @param string $group
     * @param string $email
     * @param string $phone
     * @param string $address
     * @param string $zip_code
     * @param string $city
     * @param string $country
     * @param string $birth_date
     * @param string $information
     * @param string $deadline_date
     * @return bool
     */
    static function add_student($id_te,$id_ti,$name,$fname,$group,$email,$phone,$address,$zip_code,$city,$country,$information,$deadline_date,$birth_date = "0000-00-00"){
        if(!is_int($id_te) OR !is_int($id_ti) OR !is_string($name) OR !is_string($fname) OR !is_string($group) OR !is_string($email) OR !is_string($phone) OR !is_string($address) OR !is_string($zip_code) OR !is_string($city) OR !is_string($country) OR !is_string($birth_date) OR !is_string($information) OR !is_string($deadline_date))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'add_student(:id_te,:id_ti,:name,:fname,:group,:email,:phone,:address,:zip_code,:city,:country,:birth_date,:information,:deadline_date)')->execute(array(':id_te' => $id_te,':id_ti' => $id_ti,':name' => $name,':fname' => $fname,':group' => $group,':email' => $email,':phone' => $phone,':address' => $address,':zip_code' => $zip_code,':city' => $city,':country' => $country,':birth_date' => $birth_date,':information' => $information,':deadline_date' => $deadline_date));
    }

    /**
     * Ajoute un utilisateur
     * @param string $name
     * @param string $fname
     * @param string $type
     * @param string $email
     * @param string $pwd
     * @param string $phone
     * @param string $address
     * @param string $zip_code
     * @param string $city
     * @param string $country
     * @param string $language
     * @param bool $publication_entitled
     * @return bool
     */
    static function add_user($name,$fname,$type,$email,$phone,$address,$zip_code,$city,$country,$language,$publication_entitled){
        if(!is_string($name) OR !is_string($fname) OR !is_int($type) OR !is_string($email)   OR !is_string($phone) OR !is_string($address) OR !is_string($zip_code) OR !is_string($city) OR !is_string($country) OR !is_string($language) OR !is_bool($publication_entitled))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'add_user(:name,:fname,:type,:email,:phone,:address,:zip_code,:city,:country,:language,:publication_entitled)')->execute(array(':name' => $name,':fname' => $fname,':type' => $type,':email' => $email,':phone' => $phone,':address' => $address,':zip_code' => $zip_code,':city' => $city,':country' => $country,':language' => $language,':publication_entitled' => $publication_entitled));
    }

    /**
     * Autorise un utilisateur à publier
     * @param int $id_user
     * @return bool
     */
    static function autorize_to_publish($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'autorize_to_publish(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Change le mot de passe d'un utilisateur
     * @param int $id_user
     * @param string $password
     * @return bool
     */
    static function change_password($id_user,$password){
        if(!is_int($id_user) && !is_string($password))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'change_password(:id_user,:password)')->execute(array(':id_user'=>$id_user,':password' => $password));
    }

    /**
     * Supprime toute les questions d'un étudiant
     * @param int $id_student
     * @return bool
     */
    static function delete_all_answer($id_student){
        if(!is_int($id_student))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_all_answer(:id_student)')->execute(array(':id_student'=>$id_student));
    }

    /**
     * Supprime toute les questions de tous les étudiants
     * @return bool
     */
    static function delete_all_answer_for_all_students(){
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_all_answer_for_all_students()')->execute();
    }

    /**
     * Supprime tous les messages d'un utilisateur
     * @param int $id_user
     * @return bool
     */
    static function delete_all_message($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_all_message(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Supprime tout les étudiants
     * @return mixed
     */
    static function delete_all_students(){
        return self::$PDO->query('CALL '.self::$prefix.'delete_all_students()');
    }

    /**
     * Supprime tout les utilisateur
     * @return mixed
     */
    static function delete_all_user(){
        return self::$PDO->query('CALL '.self::$prefix.'delete_all_user()');
    }

    /**
     * Supprime une réponse
     * @param int $id_answer
     * @return bool
     */
    static function delete_answer($id_answer){
        if(!is_int($id_answer))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_answer(:id_answer)')->execute(array(':id_answer'=>$id_answer));
    }

    /**
     * Supprime un commentaire
     * @param int $id_post_comment
     * @return bool
     */
    static function delete_comment($id_post_comment){
        if(!is_int($id_post_comment))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_comment(:id_post_comment)')->execute(array(':id_post_comment'=>$id_post_comment));
    }

    /**
     * Supprime les messages entre deux utilisateur
     * @param int $id_sender
     * @param int $id_recipient
     * @return bool
     */
    static function delete_group_message($id_sender,$id_recipient){
        if(!is_int($id_sender) OR !is_int($id_recipient))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_comment(:id_sender,:id_recipient)')->execute(array(':id_sender'=>$id_sender,':id_recipient' => $id_recipient));
    }

    /**
     * Supprime un message
     * @param int $id_message
     * @return bool
     */
    static function delete_message($id_message){
        if(!is_int($id_message))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_message(:id_message)')->execute(array(':id_message'=>$id_message));
    }

    /**
     * Supprime une notification
     * @param $id_notification
     * @return bool
     */
    static function delete_notification($id_notification){
        if(!is_int($id_notification))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_notification(:id_notification)')->execute(array(':id_notification'=>$id_notification));
    }

    /**
     * Supprime une piece jointe de publication
     * @param int $id_message_attachment
     * @return bool
     */
    static function delete_message_attachments($id_message_attachment){
        if(!is_int($id_message_attachment))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_message_attachment(:id_message_attachment)')->execute(array(':id_message_attachment'=>$id_message_attachment));
    }

    /**
     * Supprime une publication
     * @param int $id_post
     * @return bool
     */
    static function delete_post($id_post){
        if(!is_int($id_post))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_post(:id_post)')->execute(array(':id_post'=>$id_post));
    }

    /**
     * Supprime une piece jointe de publication
     * @param int $id_post_attachment
     * @return bool
     */
    static function delete_post_attachments($id_post_attachment){
        if(!is_int($id_post_attachment))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_post(:id_post_attachment)')->execute(array(':id_post_attachment'=>$id_post_attachment));
    }

    /**
     * Supprime une statistique
     * @param int $id_stat
     * @return bool
     */
    static function delete_statistic($id_stat){
        if(!is_int($id_stat))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_statistic(:id_stat)')->execute(array(':id_stat'=>$id_stat));
    }

    /**
     * Supprime un étudiant
     * @param int $id_student
     * @return bool
     */
    static function delete_student($id_student){
        if(!is_int($id_student))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_student(:id_student)')->execute(array(':id_student'=>$id_student));
    }

    /**
     * Supprime un utilisateur
     * @param int $id_user
     * @return bool
     */
    static function delete_user($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'delete_user(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Modifie un commentaire
     * @param int $id_comment
     * @param string $content
     * @return bool
     */
    static function edit_comment($id_comment,$content){
        if(!is_int($id_comment) && !is_string($content))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'edit_comment(:id_comment,:content)')->execute(array(':id_comment'=>$id_comment,':content' => $content));
    }

    /**
     * Modifie une date butoir pour un étudiant
     * @param int $id_student
     * @param string $deadline_date
     * @return bool
     */
    static function edit_deadline_date($id_student,$deadline_date){
        if(!is_int($id_student) && !is_string($deadline_date))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'edit_deadline_date(:id_student,:deadline_date)')->execute(array(':id_student'=>$id_student,':deadline_date' => $deadline_date));
    }

    /**
     * Modifie un étudiant
     * @param int $id_student
     * @param int $id_te
     * @param int $id_ti
     * @param string $name
     * @param $fname
     * @param string $group
     * @param string $email
     * @param string $phone
     * @param string $address
     * @param string $zip_code
     * @param string $city
     * @param string $country
     * @param string $birth_date
     * @param string $information
     * @param string $deadline_date
     * @return bool
     */
    static function edit_student($id_student,$id_te,$id_ti,$name,$fname,$group,$email,$phone,$address,$zip_code,$city,$country,$birth_date,$information,$deadline_date){
        if(!is_int($id_student) OR !is_int($id_te) OR !is_int($id_ti) OR !is_string($name) OR !is_string($fname) OR !is_string($group) OR !is_string($email) OR !is_string($phone) OR !is_string($address) OR !is_string($zip_code) OR !is_string($city) OR !is_string($country) OR !is_string($birth_date) OR !is_string($information) OR !is_string($deadline_date))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'edit_student(:id_student,:id_te,:id_ti,:name,:fname,:group,:email,:phone,:address,:zip_code,:city,:country,:birth_date,:information,:deadline_date)')->execute(array(':id_student' => $id_student,':id_te' => $id_te,':id_ti' => $id_ti,':name' => $name,':fname' => $fname,':group' => $group,':email' => $email,':phone' => $phone,':address' => $address,':zip_code' => $zip_code,':city' => $city,':country' => $country,':birth_date' => $birth_date,':information' => $information,':deadline_date' => $deadline_date));
    }

    /**
     * Modifie un utilisateur
     * @param int $id_user
     * @param string $name
     * @param string $fname
     * @param string $email
     * @param string $phone
     * @param string $address
     * @param string $zip_code
     * @param string $city
     * @param string $country
     * @param string $language
     * @return bool
     */
    static function edit_user($id_user,$name,$fname,$email,$phone,$address,$zip_code,$city,$country,$language){
        if(!is_int($id_user) OR !is_string($name) OR !is_string($fname) OR !is_string($email) OR !is_string($phone) OR !is_string($address) OR !is_string($zip_code) OR !is_string($city) OR !is_string($country) OR !is_string($language))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'edit_user(:id_user,:name,:fname,:email,:phone,:address,:zip_code,:city,:country,:language)')->execute(array(':id_user' => $id_user,':name' => $name,':fname' => $fname,':email' => $email,':phone' => $phone,':address' => $address,':zip_code' => $zip_code,':city' => $city,':country' => $country,':language' => $language));
    }

    /**
     * Ajoute un like à un commentaire
     * @param int $id_post
     * @param int $id_user
     * @return bool
     */
    static function like_post($id_post,$id_user){
        if(!is_int($id_post) OR !is_int($id_user))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'like_post(:id_post,:id_user)')->execute(array(':id_post'=>$id_post,':id_user' => $id_user));
    }

    /**
     * Permet l'envoi d'un message privé
     * @param int $id_sender
     * @param int $id_recipient
     * @param string $object
     * @param string $content
     * @param int|null $id_respond
     * @return bool
     */
    static function publish_message($id_sender,$id_recipient,$object,$content,$id_respond = null){
        if(!is_int($id_sender) OR !is_int($id_recipient) OR !is_string($object) OR !is_string($content) OR !(is_int($id_respond) OR is_null($id_respond)))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'publish_message(:id_sender,:id_recipient,:object,:content,:id_respond)')->execute(array(':id_sender' => $id_sender,':id_recipient' => $id_recipient,':object' => $object,':content' => $content,':id_respond' => $id_respond));
    }

    /**
     * Modifie la langue d'un utilisateur
     * @param int $id_user
     * @param int $lang
     * @return bool
     */
    static function set_user_language($id_user,$lang){
        if(!is_int($id_user) && !is_string($lang))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'set_user_language(:id_user,:lang)')->execute(array(':id_user'=>$id_user,':lang'=>$lang));
    }

    /**
     * Supprime le droit de publication pour un utilisateur
     * @param int $id_user
     * @return bool
     */
    static function unable_to_publish($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'unable_to_publish(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Remets en service un étudiant
     * @param int $id_student
     * @return bool
     */
    static function undelete_student($id_student){
        if(!is_int($id_student))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'undelete_student(:id_student)')->execute(array(':id_student'=>$id_student));
    }

    /**
     * Remets en service un utilisateur
     * @param int $id_user
     * @return bool
     */
    static function undelete_user($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'undelete_user(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Retire un like à une publication
     * @param int $id_post
     * @param int $id_user
     * @return bool
     */
    static function unlike_post($id_post,$id_user){
        if(!is_int($id_post) OR !is_int($id_user))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'unlike_post(:id_post,:id_user)')->execute(array(':id_post'=>$id_post,':id_user' => $id_user));
    }

    /**
     * Mis à jour le statut de réponse au questionnaire pour un étudiant
     * @param int $id_student
     * @param bool $answered
     * @return bool
     */
    static function update_answer_status($id_student,$answered){
        if(!is_int($id_student) OR !is_bool($answered))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'update_answer_status(:id_student,:answered)')->execute(array(':id_student'=>$id_student,':answered' => $answered));
    }

    /**
     * Mets à jour la derniere date de connexion d'un utilisateur
     * @param int $id_user
     * @return bool
     */
    static function update_last_login_user($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'update_last_login_user(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Valide le questionnaire d'un étudiant
     * @param int $id_student
     * @return bool
     */
    static function validate_survey($id_student){
        if(!is_int($id_student))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'validate_survey(:id_student)')->execute(array(':id_student'=>$id_student));
    }

    /**
     * Considére toute les notifications comme vus
     * @param int $id_user
     * @return bool
     */
    static function viewed_all_notification($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'viewed_all_notification(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Considére une notification comme vu
     * @param int $id_notification
     * @return bool
     */
    static function viewed_notification($id_notification){
        if(!is_int($id_notification))
            return false;
        return self::$PDO->prepare('CALL '.self::$prefix.'viewed_notification(:id_notification)')->execute(array(':id_notification'=>$id_notification));
    }


    //Functions
    /**
     * Vérifie si un utilisateur à le droit de publier
     * @param int $id_user
     * @return bool
     */
    static function can_publish($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('SELECT '.self::$prefix.'can_publish(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Compte le nombre d'Administrateurs
     * @return mixed
     */
    static function count_admin(){
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'count_admin()');
        $query->execute(array());
        return intval($query->fetchAll()[0][0]);
    }

    /**
     * Compte le nombre de messages supprimer
     * @param int $id_user
     * @return bool|int
     */
    static function count_deleted_messages($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('SELECT '.self::$prefix.'count_deleted_messages(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Compte le nombre d'étudiant supprimés
     * @return bool|int
     */
    static function count_deleted_students(){
        return self::$PDO->prepare('SELECT '.self::$prefix.'count_deleted_students()')->execute(array());
    }

    /**
     * Compte le nombre d'utilisateur supprimés
     * @return bool|int
     */
    static function count_deleted_users(){
        return self::$PDO->prepare('SELECT '.self::$prefix.'count_deleted_users()')->execute(array());
    }

    /**
     * Compte le nombre de like d'une publication
     * @param int $id_post
     * @return bool|int
     */
    static function count_like($id_post){
        if(!is_int($id_post))
            return false;
        return self::$PDO->prepare('SELECT '.self::$prefix.'count_like(:id_post)')->execute(array(':id_post'=>$id_post));
    }

    /**
     * Compte le nombre de nouveau messages
     * @param int $id_user
     * @return bool|int
     */
    static function count_new_messages($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('SELECT '.self::$prefix.'count_new_messages(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Compte le nombre de notifications d'un utilisateur
     * @param $id_user
     * @return bool|int
     */
    static function count_notifications($id_user){
        if(!is_int($id_user))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'count_notifications(:id_user)');
        $query->execute(array(':id_user'=>$id_user));
        return intval($query->fetchAll()[0][0]);

    }

    /**
     * Compte le nombre de publication sur le timeline
     * @return bool|int
     */
    static function count_post(){
        return self::$PDO->prepare('SELECT '.self::$prefix.'count_post()')->execute(array());
    }

    /**
     * Compte le nombre de messages reçu
     * @param int $id_user
     * @return bool|int
     */
    static function count_received_messages($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('SELECT '.self::$prefix.'count_received_messages(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Compte le nombre de messages envoyé
     * @param int $id_user
     * @return bool|int
     */
    static function count_sended_messages($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('SELECT '.self::$prefix.'count_sended_messages(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Compte le nombre de connexions
     * @return int
     */
    static function count_stats(){
        $datas = self::$PDO->prepare('SELECT '.self::$prefix.'count_stats()');
        $datas->execute(array());
        return intval($datas->fetchAll()[0][0]);
    }

    /**
     * Compte le nombre de connexions par jour
     * @return bool|array
     */
    static function count_stats_by_day($nb_day){
        if(!is_int($nb_day))
            return false;
        $datas = self::$PDO->prepare('SELECT COUNT(ID) as nbConnections, DATE(viewing_date) as day FROM '.self::$prefix.'stats WHERE viewing_date BETWEEN DATE_SUB(NOW(), INTERVAL :nbDay DAY) AND NOW() GROUP BY DAY(viewing_date) ORDER BY viewing_date DESC');
        $datas->execute(array(':nbDay' => $nb_day));
        return $datas->fetchAll();
    }

    /**
     * Compte le nombre de connexions par pays
     * @return bool|array
     */
    static function count_stats_by_country(){
        $datas = self::$PDO->prepare('SELECT COUNT(ID) as nbConnections, country_viewer as country FROM '.self::$prefix.'stats WHERE country_viewer != "" GROUP BY country_viewer');
        $datas->execute(array());
        return $datas->fetchAll();
    }

    /**
     * Compte le nombre de connexions par pays
     * @return bool|array
     */
    static function count_responses_for_admin(){
        $datas = self::$PDO->prepare('SELECT (SELECT count(ID) FROM '.self::$prefix.'students WHERE answered = 0) as count_not_respond,(SELECT count(ID) FROM '.self::$prefix.'students WHERE answered = 1 and answers_is_valided = 0) as count_respond,(SELECT count(ID) FROM '.self::$prefix.'students WHERE answered = 1 and answers_is_valided) as count_valided');
        $datas->execute(array());
        return $datas->fetchAll()[0];
    }

    /**
     * Compte le nombre de connexions par pays
     * @param int $id_user
     * @return bool|array
     */
    static function count_responses_for_users($id_user){
        if(!is_int($id_user))
            return false;
        $datas = self::$PDO->prepare('SELECT (SELECT count(ID) FROM '.self::$prefix.'students WHERE answered = 0 and (ID_TI = :id_user OR ID_TE = :id_user)) as count_not_respond,(SELECT count(ID) FROM '.self::$prefix.'students WHERE answered = 1 and answers_is_valided = 0 and (ID_TI = :id_user OR ID_TE = :id_user)) as count_respond,(SELECT count(ID) FROM '.self::$prefix.'students WHERE answered = 1 and answers_is_valided and (ID_TI = :id_user OR ID_TE = :id_user)) as count_valided');
        $datas->execute(array(':id_user' => $id_user));
        return $datas->fetchAll()[0];
    }

    /**
     * Compte le nombre d'étudiants
     * @return bool|int
     */
    static function count_students(){
        return self::$PDO->prepare('SELECT '.self::$prefix.'count_students()')->execute(array());
    }

    /**
     * Compte le nombre d'utilisateurs
     * @return mixed
     */
    static function count_users(){
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'count_users()');
        $query->execute(array());
        return intval($query->fetchAll()[0][0]);
    }

    /**
     * Vérifie si un compte utilisateur est activé
     * @param int $id_user
     * @return bool
     */
    static function is_activated($id_user){
        if(!is_int($id_user))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'is_activated(:id_user)');
        $query->execute(array(':id_user'=>$id_user));
        return boolval($query->fetchAll()[0][0]);
    }

    /**
     * Vérifie si un utilisateur est connecté
     * @param int $id_user
     * @return bool
     */
    static function is_connected($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('SELECT '.self::$prefix.'is_connected(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Vérifie si un utilisateur est supprimé
     * @param int $id_user
     * @return bool
     */
    static function is_deleted($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->prepare('SELECT '.self::$prefix.'is_deleted(:id_user)')->execute(array(':id_user'=>$id_user));
    }

    /**
     * Vérifie si un etudiant existe
     * @param int $id_student
     * @return bool
     */
    static function isset_student($id_student){
        if(!is_int($id_student))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'isset_student(:id_student)');
        $query->execute(array(':id_student'=>$id_student));
        return $query->fetchAll()[0][0];
    }

    /**
     * Vérifie si l'utilisateur est un Tuteur Entreprise
     * @param int $id_user
     * @return bool
     */
    static function isTE($id_user){
        if(!is_int($id_user))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'isTE(:id_user)');
        $query->execute(array(':id_user'=>$id_user));
        return boolval($query->fetchAll()[0][0]);
    }

    /**
     * Vérifie si l'utilisateur est un Tuteur IUT
     * @param int $id_user
     * @return bool
     */
    static function isTI($id_user){
        if(!is_int($id_user))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'isTI(:id_user)');
        $query->execute(array(':id_user'=>$id_user));
        return boolval($query->fetchAll()[0][0]);
    }

    /**
     * Renvoi la date butoire d'un étudiant
     * @param int $id_student
     * @return bool
     */
    static function get_deadline_date($id_student){
        if(!is_int($id_student))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'get_deadline_date(:id_student)');
        $query->execute(array(':id_student'=>$id_student));
        return $query->fetchAll()[0][0];
    }

    /**
     * Récupere le plus grand id de piece jointe de message
     * @return int|bool
     */
    static function get_maxID_message_attachment(){
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'get_maxID_message_attachment()');
        $query->execute();
        return intval($query->fetchAll()[0][0]);
    }

    /**
     * Récupere le plus grand id de message
     * @return int|bool
     */
    static function get_max_message_id(){
        $datas = self::$PDO->query('SELECT max(ID) as maxID FROM messages')->fetchAll()[0];
        return intval($datas['maxID']);
    }

    /**
     * Récupere le plus grand id de piece jointe de post
     * @return int|bool
     */
    static function get_maxID_post_attachment(){
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'get_maxID_post_attachment()');
        $query->execute();
        return intval($query->fetchAll()[0][0]);
    }

    /**
     * Récupere le plus grand id de post
     * @return int|bool
     */
    static function get_max_post_id(){
        $datas = self::$PDO->query('SELECT max(ID) as maxID FROM posts')->fetchAll()[0];
        return $datas['maxID'];
    }

    /**
     * Récupére l'identifiant du post d'un commentaire
     * @param int $id_comment
     * @return bool
     */
    static function get_post_id_by_comment($id_comment){
        if(!is_int($id_comment))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'get_post_by_comment(:id_comment)');
        $query->execute(array(':id_comment'=>$id_comment));
        return intval($query->fetchAll()[0][0]);
    }

    /**
     * Récupére l'identifiant de l'auteur d'un commentaire
     * @param int $id_comment
     * @return bool
     */
    static function get_post_publisher_id_by_comment($id_comment){
        if(!is_int($id_comment))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'get_post_publisher_id_by_comment(:id_comment)');
        $query->execute(array(':id_comment'=>$id_comment));
        return intval($query->fetchAll()[0][0]);
    }

    /**
     * Récupére l'identifiant de l'auteur d'un post
     * @param int $id_post
     * @return bool
     */
    static function get_publisher_id($id_post){
        if(!is_int($id_post))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'get_publisher_id(:id_post)');
        $query->execute(array(':id_post'=>$id_post));
        return intval($query->fetchAll()[0][0]);
    }

    /**
     * Récupére l'identifiant du tuteur entreprise d'un étudiant
     * @param int $id_student
     * @return bool
     */
    static function get_TE_ID_of_student($id_student){
        if(!is_int($id_student))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'get_TE_ID_of_student(:id_student)');
        $query->execute(array(':id_student'=>$id_student));
        return intval($query->fetchAll()[0][0]);
    }

    /**
     * Récupére l'identifiant du tuteur IUT d'un étudiant
     * @param int $id_student
     * @return bool
     */
    static function get_TI_ID_of_student($id_student){
        if(!is_int($id_student))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'get_TI_ID_of_student(:id_student)');
        $query->execute(array(':id_student'=>$id_student));
        return intval($query->fetchAll()[0][0]);
    }

    /**
     * Recupére l'identifiant d'un utilisateur grâce au mail
     * @param int $email_user
     * @return int
     */
    static function get_UserID_with_email($email_user){
        if(!is_string($email_user))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'get_UserID_with_email(:email_user)');
        $query->execute(array(':email_user'=>$email_user));
        return intval($query->fetchAll()[0][0]);
    }

    /**
     * Recupére la language d'un utilisateur
     * @param int $id_user
     * @return string
     */
    static function get_User_language($id_user){
        if(!is_int($id_user))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'get_User_language(:id_user)');
        $query->execute(array(':id_user'=>$id_user));
        return $query->fetchAll()[0][0];
    }

    /**
     * Recupére la type d'un utilisateur
     * @param int $id_user
     * @return string
     */
    static function get_User_type($id_user){
        if(!is_int($id_user))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'get_User_type(:id_user)');
        $query->execute(array(':id_user'=>$id_user));
        return $query->fetchAll()[0][0];
    }

    /**
     * Determine si un le questionnaire d'un étudiant est envoyé
     * @param int $id_student
     * @return bool
     */
    static function have_answered($id_student){
        if(!is_int($id_student))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'have_answered(:id_student)');
        $query->execute(array(':id_student'=>$id_student));
        return boolval($query->fetchAll()[0][0]);
    }

    /**
     * Affiche un message privé
     * @return bool|array
     */
    static function search_messages($item){
        if(!is_string($item))
            return false;
        $query = self::$PDO->prepare("SELECT t1.*,concat(t2.fname,' ',t2.name) as recipient_name,concat(t3.fname,' ',t3.name) as sender_name from ".self::$prefix."messages t1,".self::$prefix."users t2, ".self::$prefix."users t3 where t1.id_recipient = t2.ID AND t1.id_sender = t3.ID  and (t1.object LIKE :item OR t1.content LIKE :item OR concat(t2.fname,' ',t2.name) LIKE :item OR concat(t3.fname,' ',t3.name) LIKE :item)");
        $query->execute(array(':item' => '%'.$item.'%'));
        return $query->fetchAll();
    }

    /**
     * Recherches des publication
     * @return bool|array
     */
    static function search_posts($item){
        if(!is_string($item))
            return false;
        $query = self::$PDO->prepare("SELECT t1.*,CONCAT(t2.fname,' ',t2.name) AS post_name from ".self::$prefix."posts t1,".self::$prefix."users t2 WHERE deleted IS NULL AND t1.ID_USER = t2.ID AND (CONCAT(t2.fname,' ',t2.name) LIKE :item OR t1.content LIKE :item)");
        $query->execute(array(':item'=>'%'.$item.'%'));
        return $query->fetchAll();
    }


    /**
     * Effectue une recherche dans la liste des étudiants
     * @param String $item
     * @return mixed
     */
    static function search_students($item){
        if(!is_string($item))
            return false;
        $query = self::$PDO->prepare("SELECT * FROM ".self::$prefix."show_all_students WHERE (name LIKE :item OR fname LIKE :item OR email LIKE :item OR name_TE LIKE :item OR name_TI LIKE :item OR ".self::$prefix."show_all_students.group LIKE :item  OR address  LIKE :item OR city  LIKE :item OR country  LIKE :item)");
        $query->execute(array(':item'=>'%'.$item.'%'));
        return $query->fetchAll();
    }

    /**
     * Effectue une recherche dans la liste des étudiants liés à un Tuteur IUT
     * @param String $item
     * @return mixed
     */
    static function search_students_of_TI($item,$id_TI){
        if(!is_string($item))
            return false;
        $query = self::$PDO->prepare("SELECT * FROM ".self::$prefix."show_all_students WHERE (name LIKE :item OR fname LIKE :item OR email LIKE :item OR name_TE LIKE :item OR name_TI LIKE :item OR ".self::$prefix."show_all_students.group LIKE :item  OR address  LIKE :item OR city  LIKE :item OR country  LIKE :item) AND ID_TI = :id_ti");
        $query->execute(array(':item'=>'%'.$item.'%',':id_ti'=>$id_TI));
        return $query->fetchAll();
    }

    /**
     * Effectue une recherche dans la liste des étudiants liés à un Tuteur Entreprise
     * @param String $item
     * @return mixed
     */
    static function search_students_of_TE($item,$id_TE){
        if(!is_string($item))
            return false;
        $query = self::$PDO->prepare("SELECT * FROM ".self::$prefix."show_all_students WHERE (name LIKE :item OR fname LIKE :item OR email LIKE :item OR name_TE LIKE :item OR name_TI LIKE :item OR ".self::$prefix."show_all_students.group LIKE :item  OR address  LIKE :item OR city  LIKE :item OR country  LIKE :item) AND ID_TE = :id_te");
        $query->execute(array(':item'=>'%'.$item.'%',':id_te'=>$id_TE));
        return $query->fetchAll();
    }

    /**
     * Effectue une recherche dans la liste des Utilisateur
     * @param String $item
     * @return mixed
     */
    static function search_users($item){
        if(!is_string($item))
            return false;
        $query = self::$PDO->prepare("SELECT * FROM ".self::$prefix."show_all_users WHERE (name LIKE :item OR fname LIKE :item OR email LIKE :item OR address  LIKE :item OR city  LIKE :item OR country  LIKE :item)");
        $query->execute(array(':item'=>'%'.$item.'%'));
        return $query->fetchAll();
    }

    /**
     * Effectue une recherche dans la liste des Utilisateur pour un Tuteur Entreprise
     * @param String $item
     * @return mixed
     */
    static function search_users_from_TE($item,$id_te){
        if(!is_string($item) || !is_int($id_te))
            return false;
        $query = self::$PDO->prepare("SELECT * FROM show_all_users WHERE (name LIKE :item OR fname LIKE :item OR email LIKE :item OR address  LIKE :item OR city  LIKE :item OR country  LIKE :item) AND (ID IN (SELECT ID_TI FROM students WHERE ID_TE= :id_te) OR type = 1)");
        $query->execute(array(':item'=>'%'.$item.'%',':id_te' => $id_te));
        return $query->fetchAll();
    }

    /**
     * Affiche les réponses au questionnaire d'un étudiant
     * @param int $id_student
     * @return bool|array
     */
    static function show_answer($id_student){
        if(!is_int($id_student))
            return false;
        return self::$PDO->query("SELECT * FROM ".self::$prefix."answers WHERE ID_student=".$id_student)->fetchAll();
    }

    /**
     * Affiche les commentaires d'un publication
     * @param int $id_post
     * @return bool|array
     */
    static function show_comment($id_post){
        if(!is_int($id_post))
            return false;
        return self::$PDO->query("SELECT t1.*,concat(t2.fname,' ',t2.name) as comment_name FROM ".self::$prefix."posts_comments t1,".self::$prefix."users t2 WHERE deleted IS NULL AND t1.ID_USER=t2.ID AND ID_POST=".$id_post)->fetchAll();
    }

    /**
     * Affiche les messages supprimés d'un utilisateur
     * @param int $id_user
     * @return bool|array
     */
    static function show_deleted_message($id_user){
        if(!is_int($id_user))
            return false;
        $query = self::$PDO->prepare("SELECT t1.*,concat(t2.fname,' ',t2.name) as recipient_name,concat(t3.fname,' ',t3.name) as sender_name from ".self::$prefix."messages t1,".self::$prefix."users t2, ".self::$prefix."users t3 where (id_sender= :id_user OR id_recipient = :id_user) and t1.id_recipient = t2.ID AND t1.id_sender = t3.ID and (deleted IS NOT NULL AND deleted = 1)");
        $query->execute(array(':id_user'=>$id_user));
        return $query->fetchAll();
    }

    /**
     * Affiche les likes d'une publication
     * @param int $id_post
     * @return bool|array
     */
    static function show_likes($id_post){
        if(!is_int($id_post))
            return false;
        return self::$PDO->query("SELECT t1.*,concat(t2.fname,' ',t2.name) as liker_name FROM ".self::$prefix."liked_post t1,".self::$prefix."users t2 WHERE t1.ID_USER=t2.ID AND ID_POST=".$id_post)->fetchAll();
    }

    /**
     * Affiche les messages recu d'un utilisateur
     * @param int $id_user
     * @return bool|array
     */
    static function show_new_messages($id_user){
        if(!is_int($id_user))
            return false;
        $query = self::$PDO->prepare("SELECT t1.*,concat(t2.fname,' ',t2.name) as recipient_name,concat(t3.fname,' ',t3.name) as sender_name from ".self::$prefix."messages t1,".self::$prefix."users t2, ".self::$prefix."users t3 where id_recipient = :id_user and t1.id_recipient = t2.ID AND t1.id_sender = t3.ID and viewed IS NULL and (deleted IS NULL OR deleted = 0)");
        $query->execute(array(':id_user'=>$id_user));
        return $query->fetchAll();
    }

    /**
     * Affiche les notification d'un utilisateur
     * @param $id_user
     * @return bool|array
     */
    static function show_notification($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->query("SELECT * from ".self::$prefix."notifications WHERE ID_USER IS NULL OR ID_USER=".$id_user." ORDER BY requested_date DESC")->fetchAll();
    }

    /**
     * Affiche un message privé
     * @param int $id_message
     * @return bool|array
     */
    static function show_message($id_message){
        if(!is_int($id_message))
            return false;
        $query = self::$PDO->prepare("SELECT t1.*,concat(t2.fname,' ',t2.name) as recipient_name,concat(t3.fname,' ',t3.name) as sender_name from ".self::$prefix."messages t1,".self::$prefix."users t2, ".self::$prefix."users t3 where t1.id_recipient = t2.ID AND t1.id_sender = t3.ID  and t1.ID= :id_message");
        $query->execute(array(':id_message'=>$id_message));
        return $query->fetchAll()[0];
    }

    /**
     * Affiche les piéce jointes d'un message
     * @param int $id_message
     * @return bool|array
     */
    static function show_message_attachment($id_message){
        if(!is_int($id_message))
            return false;
        return self::$PDO->query("SELECT * from ".self::$prefix."message_attachments where ID_message=".$id_message)->fetchAll();
    }

    /**
     * Affiche les publication d'un utilisateur
     * @param int $id_user
     * @return bool|array
     */
    static function show_posts($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->query("SELECT t1.*,CONCAT(t2.fname,' ',t2.name) AS post_name from ".self::$prefix."posts t1,".self::$prefix."users t2 WHERE deleted IS NULL AND t1.ID_USER = t2.ID AND ID_USER=".$id_user)->fetchAll();
    }

    /**
     * Affiche les piéces jointes d'une publication
     * @param int $id_post
     * @return bool|array
     */
    static function show_post_attachment($id_post){
        if(!is_int($id_post))
            return false;
        return self::$PDO->query("SELECT * from ".self::$prefix."posts_attachments WHERE ID_POST=".$id_post)->fetchAll();
    }

    /**
     * Affiche les messages recu d'un utilisateur
     * @param int $id_user
     * @return bool|array
     */
    static function show_received_message($id_user){
        if(!is_int($id_user))
            return false;
        $query = self::$PDO->prepare("SELECT t1.*,concat(t2.fname,' ',t2.name) as recipient_name,concat(t3.fname,' ',t3.name) as sender_name from ".self::$prefix."messages t1,".self::$prefix."users t2, ".self::$prefix."users t3 where id_recipient = :id_user and t1.id_recipient = t2.ID AND t1.id_sender = t3.ID and (deleted IS NULL OR deleted=0)");
        $query->execute(array(':id_user'=>$id_user));
        return $query->fetchAll();
    }

    /**
     * Affiche les message envoyés d'un utilisateur
     * @param int $id_user
     * @return bool|array
     */
    static function show_sended_message($id_user){
        if(!is_int($id_user))
            return false;
        $query = self::$PDO->prepare("SELECT t1.*,concat(t2.fname,' ',t2.name) as recipient_name,concat(t3.fname,' ',t3.name) as sender_name from ".self::$prefix."messages t1,".self::$prefix."users t2, ".self::$prefix."users t3 where id_sender=".$id_user." and t1.id_recipient = t2.ID AND t1.id_sender = t3.ID and (deleted IS NULL OR deleted = 0)");
        $query->execute(array(':id_user'=>$id_user));
        return $query->fetchAll();
    }

    /**
     * Affiche les coordonées d'un étudiant
     * @param int $id_student
     * @return bool|array
     */
    static function show_student($id_student){
        if(!is_int($id_student))
            return false;
        return self::$PDO->query("SELECT ".self::$prefix."students.*,concat(u1.fname,' ',u1.name) AS name_TE,concat(u2.fname,' ',u2.name) AS name_TI from ".self::$prefix."students join ".self::$prefix."users u1 join ".self::$prefix."users u2 where ((".self::$prefix."students.ID_TE = u1.ID) and (".self::$prefix."students.ID_TI = u2.ID)) AND ".self::$prefix."students.ID=".$id_student)->fetchAll()[0];
    }

    /**
     * Affiche les étudiant dont un tuteur est responsable
     * @param int $id_user
     * @return bool|array
     */
    static function show_students($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->query("SELECT * FROM ".self::$prefix."students WHERE ID_TE=".$id_user." OR ID_TI=".$id_user)->fetchAll();
    }

    /**
     * Coordonnées d'un utilisateur
     * @param int $id_user
     * @return bool|array
     */
    static function show_user($id_user){
        if(!is_int($id_user))
            return false;
        return self::$PDO->query('SELECT ID,fname,name,type,email,phone,address,zip_code,city,country,language,registration_date,activation_date,delete_date,last_login_date,publication_entitled,CASE WHEN activation_date IS NULL THEN 0 ELSE 1 END as activated FROM '.self::$prefix.'users s1 LEFT JOIN '.self::$prefix.'show_last_stats_by_user s2 ON s1.ID = s2.ID_USER WHERE ID='.$id_user)->fetchAll()[0];
    }

    /**
     * Determine si un le questionnaire d'un étudiant est validé
     * @param int $id_student
     * @return bool
     */
    static function survey_is_validate($id_student){
        if(!is_int($id_student))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'survey_is_validate(:id_student)');
        $query->execute(array(':id_student'=>$id_student));
        return boolval($query->fetchAll()[0][0]);

    }

    /**
     * Vérifie si un utilisateur peut se connecter
     * @param string $email
     * @param string $password
     * @return bool
     */
    static function verification_connection($email,$password){
        if(!is_string($email) && !is_string($password))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'verification_connection(:email,:password)');
        $query->execute(array(':email'=>$email,':password' => $password));
        return boolval($query->fetchAll()[0][0]);
    }

    /**
     * Vérifie si un mail existe
     * @param string $email
     * @return bool|array
     */
    static function verification_email($email){
        if(!is_string($email))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'verification_email(:email)');
        $query->execute(array(':email'=>$email));
        return boolval($query->fetchAll()[0][0]);
    }

    /**
     * Vérifie si un utilisateur peut se connecter
     * @param string $id
     * @param string $password
     * @return bool
     */
    static function verification_id_password($id,$password){
        if(!is_int($id) && !is_string($password))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'verification_id_password(:id,:password)');
        $query->execute(array(':id'=>$id,':password' => $password));
        return boolval($query->fetchAll()[0][0]);
    }

    /**
     * Vérifie si un Identifiant existe dans la base
     * @param int $id_user
     * @return bool
     */
    static function userID_exist($id_user){
        if(!is_int($id_user))
            return false;
        $query = self::$PDO->prepare('SELECT '.self::$prefix.'userID_exist(:id_user)');
        $query->execute(array(':id_user'=>$id_user));
        return boolval($query->fetchAll()[0][0]);
    }

    //Create Event
    /**
     * Permet l'initialisation de la base de données
     * @param string $date
     * @return bool|array
     */
    static function initialize($date){
        if(!is_string($date))
            return false;
        return self::$PDO->prepare("CREATE EVENT `initialize` ON SCHEDULE AT :date DO UPDATE ".self::$prefix."students SET delete_date = NOW()")->execute(array(':date'=>$date));
    }

}