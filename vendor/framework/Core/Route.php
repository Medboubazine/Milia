<?php
namespace Milia\Framework\Core;
class Route{
/**
 * 
 * Global route key
 */
protected static $routeKey = 'routes';
/**
 * 
 * 
 * 
 */
public static function convertRoutePathToArray($path){
    preg_match_all("/\[([^\]]*)\]/",$path,$match);
    return $match[0];
}
/**
 * 
 * 
 * 
 */
public static function routeArrayImplement(){
    $args = func_get_args();
    return [
                    'path'=>$args[0],
                    'controller'=>$args[1],
                    'method'=>$args[2],
                    'arguments'=>$args[3],
                    'requestmethod'=>$args[4],
                    'closure'=>$args[5],
    ];
    return $array;
}
/**
 * 
 * 
 */
public static function list(){
    $list = '';
    foreach (self::routeArray() as $k => $v) {
            $list .= "
                        -----------------------------------------------------\n\r
                        | Path : {$v['path']} \n\r
                        | Controller#method : {$v['controller']}#{$v['method']} \n\r
                        | name : {$k} \n\r
                        -----------------------------------------------------\n\r";
    }
    return $list;
}
/**
 * 
 * 
 */
public static function getUrl(){
    $routes = self::routeArray();
    $args = func_get_args();
    if (func_num_args() >=1) {
        $route = (isset($routes[$args[0]]) && !empty($routes[$args[0]])) ? $routes[$args[0]] : null ;
        if ($route === null) {
            throw new \Exception("Route name '{$args[0]}' does not exist", 1);
        }
        if (!empty($route['arguments']) && func_num_args() <=1) {
            throw new \Exception("Arguments required for route name '{$route['path']}' does not exist", 1);
        }
        $replaced = $args;
        unset($replaced[0]);
        return self::getDomain().self::getHomeUrlPath().str_replace($route['arguments'],array_values($replaced),$route['path']);
    }
}
/**
 * 
 * Route array
 * 
 */
public static function routeArray(){
    $routes = (isset($GLOBALS[self::$routeKey]) && !empty($GLOBALS[self::$routeKey])) ? $GLOBALS[self::$routeKey] : null ;
    if ($routes === null) {
        throw new \Exception('Routes not set correctly', 1);
    }
    return $routes;
} 
/**
 * 
 * 
 */
public static function register($name,$path,$action,$requestMethod = []){
    $requestMethodFilterred = [];
    if (!is_array($requestMethod) OR empty($requestMethod)) {
        $requestMethod = ['get'];
    }
    if(is_object($action)){
        $closure = $action;
        $controller = null;
        $arr[0] = null;
        $arr[1] = null;
    }else{
        $controller = (string) $action;
        $closure = null;
        $arr = explode('#',$controller,2);
        if(count($arr) <= 1){
            throw new \Exception("Controller method not set correctly in route : {$name}", 1);
        }
    }
    foreach ($requestMethod as $value) {
        if(in_array($value,['get','post','put','delete'])){
            $requestMethodFilterred[] = $value;
        }
    }
    $GLOBALS[self::$routeKey][$name] = self::routeArrayImplement($path,$arr[0],$arr[1],self::convertRoutePathToArray($path),$requestMethodFilterred,$closure);
}
/**
 * 
 * 
 */
public static function getHomeUrlPath(){
    $original = $_SERVER["SCRIPT_NAME"];
    return rtrim(str_replace('webroot/index.php','',$original),'/');
}
/**
 * 
 * 
 * 
 */
public static function getDomain(){
    $original = $_SERVER["HTTP_HOST"];
    return rtrim('http://'.$original,'/');
}
/**
 * 
 * 
 * 
 */
public static function getRequestUri(){
    $original = $_SERVER["REQUEST_URI"];
    $new = str_replace([self::getHomeUrlPath(),'index.php/'],['',''],$original);
    $new = explode('?',$new,2)[0];
    return rtrim($new,'/');
}
/**
 * 
 * 
 * 
 */
public static function getRequestUriWithQueries(){
    $original = $_SERVER["REQUEST_URI"];
    $new = str_replace([self::getHomeUrlPath(),'index.php/'],['',''],$original);
    return rtrim($new,'/');
}
}