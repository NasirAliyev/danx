<?php

/**
 * Created by PhpStorm.
 * User: Nasir
 * Date: 11/15/2017
 * Time: 12:06 PM
 * SINGLETON dessign pattern
 */

class DB {

    public static function instance()
    {
      $conn =  new PDO('mysql:host=localhost;dbname=danx','root','');
      $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      return $conn;
    }

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

}