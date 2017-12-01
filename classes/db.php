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
            $conn =  new PDO('mysql:host=localhost;dbname=danx','root','');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("set names utf8");
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
