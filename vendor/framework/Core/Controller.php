<?php
namespace Milia\Framework\Core;
use Milia\Framework\Loader\MVLoad;
abstract class Controller{
/**
 * 
 * 
 * 
 */
protected function load(){
    return new MVLoad();
}
}
