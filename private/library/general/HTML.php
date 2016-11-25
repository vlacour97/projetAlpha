<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 23/11/16
 * Time: 11:58
 */

namespace general;

use app\Config;
use app\Log;
use app\Message;
use app\Navigation;
use app\Notifications;
use app\Search;
use app\Stats;
use app\User;

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
        'widgster/widgster.js'
    );
    private $basic_script = array('settings.js','app.js');
    private $favicon_path = "";

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
            <title></title>
            <!-- Applications Links -->
            <?php $linker->css($links) ?>
            <?php $linker->css($links_ie,true) ?>
            <link rel="shortcut icon" href="<?php echo $this->favicon_path ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
            <meta name="description" content="">
            <meta name="author" content="">
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
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

    private function generate_navigation(){
        $datas = Navigation::get_navbar();
        $response = '<ul class="sidebar-nav">';
        foreach($datas as $page){
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
                $response .= '<li class="'.$active.'"><a class="collapsed" href="#user_nav_list" data-toggle="collapse" data-parent="#sidebar"><span class="icon"><i class="'.$page->logo.'"></i></span>'.$page->name.'<i class="toggle fa fa-angle-down"></i></a><ul id="user_nav_list" class="collapse">';
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

    private function label_nb_message(&$gabarit){
        if(($nb_message = Message::count_message(Log::get_id())) != "0")
            $gabarit = str_replace('{nb_message}',$nb_message,$gabarit);
    }

    function navbar(){
        $gabarit = Language::translate_gabarit('components/navbar');

        $id = Log::get_id();
        $user = User::get_user($id);
        $date = new Date('now');

        $replace = array('{user_fname}','{user_name}','{profile_img_link}','{now-date}');
        $by = array($user->fname,$user->name,User::get_profile_photo($id),$date->format('dd MM yyyy {at} hh:mn'));
        $gabarit = str_replace($replace,$by,$gabarit);

        $this->label_nb_message($gabarit);

        echo $gabarit;
    }

    /**
     * Revois un objet select instancié
     * @return Select
     */
    function select(){
        return new Select();
    }

} 