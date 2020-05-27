<?php
namespace Milia\Framework\Core;
class View{
/**
 * 
 * Load
 * 
 */
public static function load(string $name,array $data = []){
    $nameToPath = str_replace('.',DS,$name);
    $view = RES_DIR.DS.'views'.DS.$nameToPath.'.mt.php';
    if (file_exists($view)) {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        require $view;
    }else{
        self::undefinedView($name,$view);
    }
    return '';
}
/**
 * 
 * Undefined message
 * 
 */
protected static function undefinedView($name,$path){
    throw new \Exception("Undefined view '{$name}' , create it in : '{$path}'", 1);
    
}
}