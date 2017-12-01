<?php

/**
 * Created by PhpStorm.
 * User: Nasir
 * Date: 11/15/2017
 * Time: 12:06 PM
 * SINGLETON dessign pattern
 */

class db {

    public static function instance()
    {
        try {
            //$conn = new PDO('mysql:host=192.168.1.3;port=3306;dbname=mhm','mhm','*#MHM5673256s',array(PDO::ATTR_PERSISTENT => true));
            $conn = new PDO('mysql:host=localhost;dbname=danx', 'root', '');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            echo $e->errorInfo();
        }

      return $conn;
    }

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

}
