<?php

spl_autoload_register(function($class){
     $class_path='classes'.DIRECTORY_SEPARATOR.$class.'.php';
     if (file_exists($class_path)) require_once $class_path;
});


DB::instance()->prepare('select * from users')->execute();



