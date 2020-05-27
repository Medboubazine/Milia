<?php
namespace Milia\Framework\Loader;
use Milia\Framework\Core\View;
class MVLoad{
/**
 * 
 * Load model
 * 
 */
public static function model(string $name){
    $name .= 'Model';
    $view = APP_DIR.DS.'model'.DS.$name.'.php';
    if (file_exists($view)) {
        require_once $view;
        return new $name();
    }
    self::undefinedModel($name,$view);
}
/**
 * 
 * Load view
 * 
 */
public static function view(){
    $args = func_get_args();
    return call_user_func_array([(new View),'load'],$args);
}
/**
 * 
 * Undefined message
 * 
 */
protected static function undefinedModel($name,$path){
    throw new \Exception("Undefined Model '{$name}' , create it in : '{$path}'", 1);
    
}
}