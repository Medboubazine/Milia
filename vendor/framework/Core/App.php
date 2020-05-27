<?php
namespace Milia\Framework\Core;
use Milia\Framework\Constant\Constant;
class App{
/**
 * 
 * 
 */
protected $__dir;
/**
 * 
 * Called route
 * 
 */
protected $__route;
/**
 * 
 * Called route
 * 
 */
protected $controller;
/**
 * 
 * 
 */
protected $c_request;
/**
 * 
 * 
 */
protected $c_route;
/**
 * 
 * Route class
 * 
 */
protected function route(){
    $this->c_route = new \Milia\Framework\Core\Route;
    return $this->c_route;
}
/**
 * 
 * Request class
 * 
 */
protected function request(){
    $this->c_request = new \Milia\Framework\Core\Request;
    return $this->c_request;
}
/**
 * 
 * Constant class
 * 
 */
protected function constant(){
    return (new Constant())->call($this->__dir);
}
/**
 * 
 * 
 * 
 */
public function start($dir){
    $this->__dir = $dir;
    $this->constant();
    $this->request();
    $this->c_request->run();
    $this->c_route = $this->route();
    $this->__route = $this->c_request->route;
    $this->loadClientContent();
}
/**
 * 
 * load page
 * 
 */
protected function loadClientContent(){
    if (is_object($this->__route['closure'])) {
        echo $this->callClosure($this->request()->getArgumentsFromUri($this->__route));
    }else{
        echo $this->callControllerMethod($this->callController(),$this->__route['method'],$this->request()->getArgumentsFromUri($this->__route));
    }
}
/**
 * 
 * Controller class
 * 
 */
protected function callController(){
    $controllerName = $this->__route["controller"];
    $controllerPath = APP_DIR.'/controller/'.ltrim($controllerName,'/').'.php';
    if (file_exists($controllerPath)) {
        require_once $controllerPath;
        $controller = new $controllerName();
        $this->controller = $controller;
        return $controller;
    }else{
        $this->undefinedController($this->__route["controller"]);
    }
}
/**
 * 
 * Controller class
 * 
 */
protected function callClosure(){
    $closure = $this->__route["closure"];
    $args = func_get_args();
    return call_user_func_array($closure,$args[0]);
}
/**
 * 
 * Controller method class
 * 
 */
protected function callControllerMethod(){
    $args = func_get_args();
    $controller = $args[0];
    $method = $args[1];
    $args = array_values($args[2]);
    if(method_exists($controller,$method)){
        return call_user_func_array([$controller,$method],$args);
    }else{
        $this->undefinedMethod($this->__route["controller"],$method);
    }
}
/**
 * 
 * Undefined Messages
 * 
 */
protected function undefinedController($controller){
    throw new \Exception("Controller '{$controller}' , does not exist", 1);
    
}
/**
 * 
 * Undefined Messages
 * 
 */
protected function undefinedMethod($c,$m){
    throw new \Exception("Method '{$m}' , does not exist in controller '{$c}'", 1);
    
}
}