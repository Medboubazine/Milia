<?php

defined('DS') OR define('DS',DIRECTORY_SEPARATOR);

function load($dir = []){
    foreach ($dir as $key=>$value) {
        if (is_dir($value)) {
            load(glob($value.DS.'*'));
        }else{
            require $value;
        }
    }
}
load(glob(__DIR__.DS.'framework'.DS.'*'));