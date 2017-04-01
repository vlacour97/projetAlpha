<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 23/11/16
 * Time: 11:58
 */

namespace general;

use app\Config;
use app\Install;
use app\Log;
use app\Message;
use app\Navigation;
use app\Notifications;
use app\Search;
use app\Stats;
use app\User;
use app\Weather;

/**
 * Class Link
 * @package general
 * @author Valentin Lacour
 */
class Link{

    private $css_path = "../../../public/css/";
    private $js_path = "../../../public/js/";
    private $vendor_path = "../../../public/vendor/";

    /**
     * Génére des lignes d'insertion css
     * @param array|string $links
     * @param bool $ie
     */
    function css($links = array(), $ie = false){
        if(is_string($links))
            $links = array($links);
        foreach($links as $link)
        {
            $link = $this->css_path.$link;
            if($ie)
                echo '<!--[if IE 9]>
            <link href="'.$link.'" rel="stylesheet">
            <![endif]-->';
            else
                echo '<link href="'.$link.'" rel="stylesheet">';
        }

    }

    /**
     * Génére des lignes d'insertion script
     * @param array|string $scripts
     * @param bool $vendor
     */
    function script($scripts = array(),$vendor = true){
        if(is_string($scripts))
            $scripts = array($scripts);
        foreach($scripts as $script)
        {
            if($vendor)
                $link = $this->vendor_path.$script;
            else
                $link = $this->js_path.$script;

            echo '<script src="'.$link.'"></script>';
        }
    }

}

class Widget{

    /**
     * Widget de météo
     * @return mixed|string
     * @throws \Exception
     */
    function weather(){
        $gabarit = Language::translate_gabarit('components/weather');
        try{
            $user = User::get_user(Log::get_id());
            $weather = new Weather($user->city,$user->zip_code);
            $weather = $weather->getWeather();
        }catch (\Exception $e){
            return "";
        }

        $replace = array('{city}','{country}','{updated_date}');
        $by = array($weather->city,$weather->country,$weather->updated_date->format('h:mn'));
        $gabarit = str_replace($replace,$by,$gabarit);

        $replace = array('{temp0}','{date0}','{desc0}','{logo0}');
        $by = array($weather->today->temp,$weather->today->date->format('WW'),$weather->today->lbl,$weather->today->icon);
        $gabarit = str_replace($replace,$by,$gabarit);

        for($i=1;$i<5;$i++)
        {
            $replace = array('{temp'.$i.'}','{date'.$i.'}','{logo'.$i.'}');
            $by = array($weather->days[$i-1]->temp,$weather->days[$i-1]->date->format('WW'),$weather->days[$i-1]->icon);
            $gabarit = str_replace($replace,$by,$gabarit);
        }

        return $gabarit;
    }


    /**
     * Widget de message
     * @return string
     * @throws \Exception
     */
    function message(){

        try{
            $id = Log::get_id();
            $gabarit = Language::translate_gabarit('components/message_widget');
            $messages = Message::get_all_messages($id);
        }catch (\Exception $e){
            return "";
        }

        $response = "";

        for($i=0;$i<2;$i++)
        {
            $message = $messages[$i];
            if(!isset($message))
                return $response;
            /** @var $message \app\messageDatas */
            $user = User::get_user($message->id_sender);
            $replace = array('{profile_img}','{fname}','{name}','{time}','{object}','{content}');
            $by = array(User::get_profile_photo($message->id_sender),$user->fname,$user->name,$message->send_date->format('d MM yyyy'),$message->object,Text::cutString(Text::automatic_emo($message->content),0,50,'...'));
            $response .= str_replace($replace,$by,$gabarit);
        }

        return $response;
    }

}

/**
 * Class Select
 * @package general
 * @author Valentin Lacour
 */
class Select{

    private $default_language = "fr_FR";
    private $default_country = "FR";

    /**
     * Génére des options pour les langues
     * @param string $selected
     * @return string
     */
    function language($selected = ""){
        $datas = link_parameters('languages/dictionnary');
        $response = "";
        $default_language = $this->default_language;
        if($selected != "" && array_key_exists($selected,$datas))
            $default_language = $selected;
        foreach($datas as $iso=>$language){
            if($iso == $default_language)
                $response .= "<option value='$iso' selected>$language</option>";
            else
                $response .= "<option value='$iso'>$language</option>";
        }
        return $response;
    }

    /**
     * Génére des options pour les pays
     * @param string $selected
     * @return string
     */
    function country($selected = ""){
        $datas = link_parameters('general/countries');
        $response = "";
        $default_country = $this->default_country;
        if($selected != "" && array_key_exists($selected,$datas))
            $default_country = $selected;
        foreach($datas as $iso=>$country){
            if($iso == $default_country)
                $response .= "<option value='$iso' selected>$country</option>";
            else
                $response .= "<option value='$iso'>$country</option>";
        }
        return $response;
    }

    function TI($selected = 0){
        $ti_list = \app\User::get_TI();
        $html_ti = '<option value=""></option>';

        foreach($ti_list as $ti){
            /** @var $ti \app\UserDatas */
            if($ti->ID == $selected)
                $html_ti .= '<option selected value="'.$ti->ID.'">'.$ti->fname.' '.$ti->name.'</option>';
            else
                $html_ti .= '<option value="'.$ti->ID.'">'.$ti->fname.' '.$ti->name.'</option>';
        }

        return $html_ti;
    }

    function TE($selected = 0){
        $te_list = \app\User::get_TE();
        $html_te = '<option value=""></option>';

        foreach($te_list as $te){
            /** @var $ti \app\UserDatas */
            if($te->ID == $selected)
                $html_te .= '<option selected value="'.$te->ID.'">'.$te->fname.' '.$te->name.'</option>';
            else
                $html_te .= '<option value="'.$te->ID.'">'.$te->fname.' '.$te->name.'</option>';
        }

        return $html_te;
    }

    function type($selected = 0){
        $type_list = Language::get_user_type_text();
        $html_type = '<option value=""></option>';

        foreach($type_list as $key=>$type){
            $key++;
            if($key == $selected)
                $html_type .= '<option selected value="'.$key.'">'.$type.'</option>';
            else
                $html_type .= '<option value="'.$key.'">'.$type.'</option>';
        }

        return $html_type;
    }

    function boolChose($selected = 0){
        $type_list = Language::get_boolChose_text();
        $html_type = '<option value=""></option>';

        foreach($type_list as $key=>$type){
            if($key == $selected)
                $html_type .= '<option selected value="'.$key.'">'.$type.'</option>';
            else
                $html_type .= '<option value="'.$key.'">'.$type.'</option>';
        }

        return $html_type;
    }

}

/**
 * Class HTML
 * @package general
 * @author Valentin Lacour
 */
class HTML {

    private $basic_css = array('application.min.css','main.css');
    private $basic_css_ie = array('application-ie9-part2.css');
    private $basic_vendor_scripts = array(
        'jquery/dist/jquery.min.js',
        'jquery-pjax/jquery.pjax.js',
        'bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js',
        'bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js',
        'bootstrap-sass/vendor/assets/javascripts/bootstrap/dropdown.js',
        'bootstrap-sass/vendor/assets/javascripts/bootstrap/button.js',
        'bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js',
        'bootstrap-sass/vendor/assets/javascripts/bootstrap/alert.js',
        'jQuery-slimScroll/jquery.slimscroll.min.js',
        'widgster/widgster.js',
        'bootstrap-sass/vendor/assets/javascripts/bootstrap/modal.js',
        'messenger/build/js/messenger.js',
        'messenger/build/js/messenger-theme-flat.js'
    );
    private $basic_script = array('settings.js','app.js','main.js');
    private $favicon_path = "/public/img/favicon.png";
    private $social_image_path = "/public/img/social_card.jpg";

    /**
     * Génére le header d'une page HTML
     * @param array $links
     * @param array $links_ie
     */
    function open($links = array(),$links_ie = array()){
        $linker = new Link();
        $links = array_merge($this->basic_css,$links);
        $links_ie = array_merge($links_ie,$this->basic_css_ie);
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title><?php if(Log::isLogged()) echo Navigation::get_title(); elseif(Install::APP_is_installed()) echo Config::getName(); ?></title>
            <!-- Applications Links -->
            <?php $linker->css($links) ?>
            <?php $linker->css($links_ie,true) ?>
            <link rel="shortcut icon" href="<?php echo HOST.$this->favicon_path ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
            <meta name="description" content="<?php echo Config::getDescription() ?>">
            <meta name="keywords" content="<?php echo Config::getKeywords() ?>">
            <meta name="author" content="<?php echo Config::getAuthor() ?>">
            <meta name="copyright" content="<?php echo Config::getCopyright() ?>">
            <meta http-equiv="Content-Language" content="<?php echo Log::get_lang() ?>" />
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <meta property="og:title" content="<?php if(Log::isLogged()) echo Navigation::get_title(); elseif(Install::APP_is_installed()) echo Config::getName(); ?>" />
            <meta property="og:type" content="website" />
            <meta property="og:url" content="<?php echo CURRENT_LINK; ?>" />
            <meta property="og:image" content="<?php echo HOST.$this->social_image_path ?>" />
        </head>
        <?php
        echo ob_get_clean();

    }

    /**
     * Génére le footer d'une page HTML
     * @param array $vendor_links
     * @param array $private_links
     */
    function close($vendor_links = array(),$private_links = array()){
        $linker = new Link();
        ob_start();
        ?>

        <?php if(Log::isLogged()) echo Language::translate_gabarit('components/feedBack') ?>

        <!-- The Loader. Is shown when pjax happens -->
        <div class="loader-wrap hiding hide">
            <i class="fa fa-circle-o-notch fa-spin-fast"></i>
        </div>

        <!-- common libraries. required for every page-->
        <?php $linker->script($this->basic_vendor_scripts); ?>

        <!-- page specific libs -->
        <?php $linker->script($vendor_links); ?>

        <!-- common app js -->
        <?php $linker->script($this->basic_script,false); ?>
        <?php $linker->script($private_links,false); ?>

        </body>
        </html>
        <?php
        echo ob_get_clean();
    }

    /**
     * Génére la sidebar
     * @throws \Exception
     */
    function sidebar(){

        $id = Log::get_id();
        $user = User::get_user($id);

        $gabarit = Language::translate_gabarit('components/sidebar');

        $replace = array('{profile_img_link}','{nb_notifications}','{user_fname}','{user_name}','{navigation_control}','{percent_response}');
        $by = array(User::get_profile_photo($id),Notifications::countNotifications(),$user->fname,$user->name,$this->generate_navigation(),Stats::progressResponsesState($id));
        $gabarit = str_replace($replace,$by,$gabarit);

        $this->generate_navigation();

        echo $gabarit;
    }

    /**
     * Génére la barre de navigation
     * @return string
     */
    private function generate_navigation(){
        $datas = Navigation::get_navbar();
        $response = '<ul class="sidebar-nav">';
        foreach($datas as $key=>$page){
            /** @var $page \app\NavLine */
            $active = "";
            if($page->id == $_GET[Navigation::$navigation_marker] || ($page->id == "home" && is_null($_GET[Navigation::$navigation_marker])))
                $active = "active";
            if(!is_null($page->navPage) && is_array($page->navPage)){
                $flag = false;
                $responseTmp = "";

                foreach($page->navPage as $pageUnder){
                    /** @var $pageUnder \app\NavLine */
                    $active = "";
                    if($page->id.Navigation::$navigation_separator.$pageUnder->id == $_GET[Navigation::$navigation_marker]){
                        $active = "active";
                        $flag = true;
                    }

                    $responseTmp .= '<li class="'.$active.'"><a href="'.$pageUnder->link.'">'.$pageUnder->name.'</a></li>';
                }
                $active = "";
                if($flag)
                    $active = "active";
                $response .= '<li class="'.$active.'"><a class="collapsed" href="#user_nav_list'.$key.'" data-toggle="collapse" data-parent="#sidebar"><span class="icon"><i class="'.$page->logo.'"></i></span>'.$page->name.'<i class="toggle fa fa-angle-down"></i></a><ul id="user_nav_list'.$key.'" class="collapse">';
                $response .= $responseTmp;
                $response .= '</ul></li>';

            }else{
                $response .= '<li class="'.$active.'"><a href="'.$page->link.'"><span class="icon"><i class="'.$page->logo.'"></i></span>'.$page->name.'</a></li>';
            }
        }
        $response .= '</ul>';
        $this->label_nb_message($response);
        return $response;
    }

    /**
     * Place le nombre de massage non lues dans une balises correspondante
     * @param $gabarit
     * @throws \Exception
     */
    private function label_nb_message(&$gabarit){
        if(($nb_message = Message::count_message(Log::get_id())) == "0")
            $nb_message = "";
        $gabarit = str_replace('{nb_message}',$nb_message,$gabarit);
    }

    /**
     * Génére la navbar
     * @throws \Exception
     */
    function navbar(){
        $gabarit = Language::translate_gabarit('components/navbar');

        $id = Log::get_id();
        $user = User::get_user($id);
        $date = new Date('now');

        $nb_notifications = "";
        if(($tmp = Notifications::countNotifications()) != 0)
            $nb_notifications = "<span class=\"circle bg-warning fw-bold nb-notifications\">$tmp</span>";

        $replace = array('{user_fname}','{user_name}','{profile_img_link}','{now-date}','{nb_notifications}','{notifications}','{language_switcher}');
        $by = array($user->fname,$user->name,User::get_profile_photo($id),$date->format('dd MM yyyy {at} hh:mn'),$nb_notifications,$this->notifications(),$this->language_switcher());
        $gabarit = str_replace($replace,$by,$gabarit);

        $this->label_nb_message($gabarit);

        echo $gabarit;
    }

    /**
     * Génére les notifications
     * @return string
     * @throws \Exception
     */
    function notifications(){
        $gabarit = Language::translate_gabarit('components/notifications');
        $notifications = Notifications::get_notifications();

        $response = "";

        foreach($notifications as $notification)
        {
            /** @var $notification \app\NotificationsForm */
            $replace = array('{link}','{content}','{time}','{icon}');
            $by = array($notification->link,$notification->text,$notification->date->format('d MM yyyy - hh:mn'),$notification->icon);
            $response .= str_replace($replace,$by,$gabarit);
        }

        return $response;
    }

    private function language_switcher(){
        $gabarit = Language::translate_gabarit('components/language_switcher');
        $languages = link_parameters('languages/dictionnary');
        $tmp = "";

        foreach ($languages as $iso=>$language) {
            $tmp .= '<li><a class="language_switcher" data-id="'.$iso.'"><i class="flag flag-fr"></i> '.$language.'</a></li><li class="divider"></li>';
        }
        $tmp = substr($tmp,0,-strlen('<li class="divider"></li>'));
        $gabarit = str_replace('{list}',$tmp,$gabarit);

        return $gabarit;
    }

    /**
     * Revois un objet widget instancié
     * @return Widget
     */
    function widget(){
        return new Widget();
    }

    /**
     * Revois un objet select instancié
     * @return Select
     */
    function select(){
        return new Select();
    }

} 