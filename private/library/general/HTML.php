<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 23/11/16
 * Time: 11:58
 */

namespace general;

use app\Navigation;
use app\Search;

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
     * @return string
     */
    function language(){
        $datas = link_parameters('languages/dictionnary');
        $response = "";
        foreach($datas as $iso=>$language){
            if($iso == $this->default_language)
                $response .= "<option value='$iso' selected>$language</option>";
            else
                $response .= "<option value='$iso'>$language</option>";
        }
        return $response;
    }

    /**
     * Génére des options pour les pays
     * @return string
     */
    function country(){
        $datas = link_parameters('general/countries');
        $response = "";
        foreach($datas as $iso=>$country){
            if($iso == $this->default_country)
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

    /**
     * Revois un objet select instancié
     * @return Select
     */
    function select(){
        return new Select();
    }

} 