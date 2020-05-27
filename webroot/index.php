<?php
use Milia\Framework\Core\App;
use Milia\Framework\Loader\MVLoad;
use Milia\Framework\Core\Request;
/**
 * 
 * 
 * 
 * 
 */
require '../bootstrap/app.php';
/**
 * 
 * Config get 
 * 
 * Config::get('app.xxx');
 * 
 */

/**
 * 
 * App start
 * 
 */
$app = new App();

exit($app->start(dirname(__DIR__)));
//delete after this
/*
<form action="../index" method='post'>
<input type='text' name="__method" value="delete">
<input type='submit' name="submit" value="true">
</form>*/