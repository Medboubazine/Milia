<?php
use Milia\Framework\Core\Route;
use Milia\Framework\Core\Request;
use Milia\Framework\Loader\MVLoad;
/**
 * 
 * Request class
 * 
 */
function request(){
    return (new Request);
}
/**
 * 
 * get route url
 * 
 */
function routeUrl(){
    $args = func_get_args();
    return call_user_func_array([(new Route),'getUrl'],$args);
}
/**
 * 
 * Load view helper
 * 
 */
function view(){
    $args = func_get_args();
    return call_user_func_array([(new MVLoad),'view'],$args);
}