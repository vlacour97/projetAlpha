<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 24/11/16
 * Time: 09:39
 */

/**
 * Class PersonalizeException
 * @author Valentin Lacour
 */
class PersonalizeException extends Exception{

    /**
     * @param string $code
     * @param array $var
     * @param Exception $previous
     */
    public function __construct($code, $var = array(), Exception $previous = null)
    {
        parent::__construct(\general\Language::get_exception_text($code,$var).' ('.$code.')', $code, $previous);
    }
}
