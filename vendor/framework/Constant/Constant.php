<?php
namespace Milia\Framework\Constant;
class Constant{
/**
 * 
 * define constant
 * 
 */
public function define($name,$value){
    return (defined($name) OR define($name,$value));
}
/**
 * 
 * Declare constants
 * 
 */
public function call($dir){
/*
//
$this->define('',);
*/
    //home directory
    $this->define('HOME_DIR',$dir);
    //App directory
    $this->define('APP_DIR',$dir.DS.'app');
    //Config directory
    $this->define('CONFIG_DIR',$dir.DS.'config');
    //log directory
    $this->define('LOG_DIR',$dir.DS.'config');
    //resourcess directory
    $this->define('RES_DIR',$dir.DS.'res');
    //temporary directory
    $this->define('TMP_DIR',$dir.DS.'tmp');
    //webroot directory
    $this->define('WEBROOT_DIR',$dir.DS.'webroot');
    //return
    return $this;
}
}
