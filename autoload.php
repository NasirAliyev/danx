<?php

spl_autoload_register(function($class){
    $class_path=__DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.basename($class).'.php';
    if (file_exists($class_path)) require_once $class_path;
});
