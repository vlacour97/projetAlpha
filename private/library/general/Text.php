<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 22/10/16
 * Time: 21:45
 */

namespace general;


class Text {

    /**
     * Permet de réduire une chaine de caractére
     * @param string $string
     * @param int $start
     * @param int $length
     * @param string $endStr
     * @return string
     */
    static function cutString($string, $start, $length, $endStr = '&hellip;'){
        // si la taille de la chaine est inférieure ou égale à celle attendue on la retourne telle qu'elle
        if( strlen( $string ) <= $length ) return $string;

        // permet de couper la phrase aux caractères définis tout en prenant en compte la taille de votre $endStr et en re-précisant l'encodage du contenu récupéré
        $str = mb_substr( $string, $start, $length - strlen( $endStr ) + 1, 'UTF-8');
        // retourne la chaîne coupée avant la dernière espace rencontrée à laquelle s'ajoute notre $endStr
        return substr( $str, 0, strrpos( $str,' ') ).$endStr;
    }


} 