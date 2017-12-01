<?php
spl_autoload_register(function($class){

    $clsStrArr=explode("\\",$class);
    $class=end($clsStrArr);

    $class_path=__DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$class.'.php';

    if (file_exists($class_path))
        require_once $class_path;
    else
        die('Class not found ->  '.$class_path);

});

