<?php
//automatically loads all classes when including this file
spl_autoload_register('autoLoadFiles');

function autoLoadFiles($className){
    $path = 'classes/';
    $extension = '.php';
    $filename = $path . $className . $extension;

    if(file_exists($filename)){
        include_once $path . $className . $extension;
    } else {
        echo 'Class not found';
    }
}