<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 08/10/16
 * Time: 15:14
 */

namespace general;


class crypt {

    /**
     * Permet de crypter des données
     * @param $data
     * @return string
     */
    static function encrypt($data) {
        include_once $_SERVER['DOCUMENT_ROOT'].'/private/config.php';
        $data = serialize($data);
        $td = mcrypt_module_open(MCRYPT_DES,"",MCRYPT_MODE_ECB,"");
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td,CRYPT_KEY,$iv);
        $data = base64_encode(mcrypt_generic($td, '!'.$data));
        mcrypt_generic_deinit($td);
        return $data;
    }

    /**
     * Permet de décrypter des données
     * @param $data
     * @return bool|mixed
     */
    static function decrypt($data) {
        include_once $_SERVER['DOCUMENT_ROOT'].'/private/config.php';
        $td = mcrypt_module_open(MCRYPT_DES,"",MCRYPT_MODE_ECB,"");
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td,CRYPT_KEY,$iv);
        $data = mdecrypt_generic($td, base64_decode($data));
        mcrypt_generic_deinit($td);

        if (substr($data,0,1) != '!')
            return false;

        $data = substr($data,1,strlen($data)-1);
        return unserialize($data);
    }
} 