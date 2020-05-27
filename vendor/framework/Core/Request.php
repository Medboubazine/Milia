<?php
namespace Milia\Framework\Core;
class Request{
/**
 * 
 * 
 */
public $attributes = [];
/**
 * 
 * 
 */
public $sessions = [];
/**
 * 
 * 
 */
public $cookies = [];
/**
 * 
 * 
 * 
 */
public $requestMethod = '';// GET or POST
/**
 * 
 * 
 * 
 */
public $headers = [];
/**
* 
* 
* 
*/
public $fillablerequests = [];
/**
 * 
 * 
 */
public function __construct(){
    $this->makeDefaultVariables();
}
/**
 * 
 * get request input value
 *
 */
public function input($name){
    return (isset($this->attributes[$name])) ? $this->attributes[$name] : null ;
}
/**
 * 
 * get Arguments from uri
 *
 */
public function getArgumentsFromUri($route){
    $args = [];
    $uri = $this->route()->getRequestUri();
    if(!empty($route{'arguments'})){
        $uriToArray = explode('/',ltrim($uri,'/'));
        $pathToArray = explode('/',str_replace($route{'arguments'},'*',ltrim($route{'path'},'/')));
        for ($i=0; $i < count($route{'arguments'}); $i++) {
            if($uriToArray[$i] !== $pathToArray[$i]){
                $args[] = $uriToArray[$i];
            }
        }
    }
    return $args;
}
/**
 * 
 * 
 * 
 */
protected function makeDefaultVariables(){
    $this->fillablerequests = ['get','post','put','delete'];
    $this->headers = $_SERVER;
    $this->requestMethod = $this->getRequestMethod();
    $this->route = $this->getRouteIfExist();
    //
    $this->attributes = ($this->requestMethod !== 'post') ? $_GET : $_POST ;
    $this->sessions = (isset($_SESSION)) ? $_SESSION : [] ;
    $this->cookies = $_COOKIE;
}
/**
 * 
 * 
 * 
 */
public function run(){
    if(!$this->checkValidRequestMethod($this->route['requestmethod'])){
        $this->invalidRequestMethod($this->route['requestmethod']);
    }
    return $this;
}
/**
 * 
 * 
 * 
 */
protected function getRouteIfExist(){
    $routes = $this->route()->routeArray();
    $uri = $this->route()->getRequestUri();
    foreach ($routes as $key => $value) {
        $str = $value['path'];
        $usePM = false;
        if (empty($uri) && $value['path'] === '/') {
            return $value;
        }
        if (!empty($value['arguments'])) {
            $str = "~".str_replace(array_values($value['arguments']),'(.*)',$value['path'])."~i";
            $usePM = true;
        }
        $PM = false;
        if ($usePM) {
            $PM = preg_match($str,$uri);
        }
        if ($str === $uri OR $PM OR $str === $uri) {
            return $value;
        }
    }
    $this->undefinedRoute();
    return [];
}
/**
 * 
 * 
 * 
 */
protected function checkValidRequestMethod($arr = []){// ['post','put']
    foreach ($arr as $value) {
        if(in_array($value,$this->fillablerequests)){
            if ($this->getRequestMethod() === $value) {
                return true;
            }
        }
    }
    return false;
}
/**
 * 
 * 
 * 
 */
protected function getRequestMethod(){
    $rm = 'get';
    if ($this->headers['REQUEST_METHOD'] === 'POST') {
        $rMethod = (isset($this->attributes['__method']) && !empty($this->attributes['__method'])) ? $this->attributes['__method'] : '' ;
        if(empty($rMethod)){
            $rm = 'post';
        }else{
            if ($rMethod === 'put') {
                $rm = 'put';
            } elseif ($rMethod === 'delete') {
                $rm = 'delete';
            }
        }
    } else {
        $rm = 'get';
    }
    return $rm;
}
/**
 * 
 * 
 * 
 */
protected function route(){
    return new \Milia\Framework\Core\Route;
}
/**
 * 
 * 
 * 
 */
protected function undefinedRoute(){
    throw new \Exception("No route matching", 1);
}
/**
 * 
 * 
 * 
 */
protected function invalidRequestMethod($rMethods = []){
    throw new \Exception('Invalid Request Method accept only : '.@implode(',',$rMethods), 1);
}
}