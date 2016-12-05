<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 05/11/16
 * Time: 22:28
 */

class Deploy {

    static $_remote = "origin";
    static $_branch = "Valentin";
    static $_date_format = 'Y-m-d H:i:sP';
    static $_log = "deployments.log";

    static function run(){
        $_remote = self::$_remote;
        $_branch = self::$_branch;

        if(!exec('git pull'))
        {
            log('Git pull..','ERROR');
        }
        if(!exec("git checkout {$_remote}/{$_branch}"))
        {
            log("git checkout {$_remote}/{$_branch}...",'ERROR');
        }

        log('Deployement réussi !');

        return true;
    }

    static private function log($message, $type = 'INFO')
    {
        if (self::$_log)
        {
            // Set the name of the log file
            $filename = self::$_log;

            if ( ! file_exists($filename))
            {
                // Create the log file
                file_put_contents($filename, '');

                // Allow anyone to write to log files
                chmod($filename, 0666);
            }

            // Write the message into the log file
            // Format: time --- type: message
            file_put_contents($filename, date(self::$_date_format).' --- '.$type.': '.$message.PHP_EOL, FILE_APPEND);
        }
    }

} 