<?php
use Milia\Framework\Core\App;
use Milia\Framework\Configuration\Config;
/**
 * 
 * 
 */
defined('DS') OR define('DS',DIRECTORY_SEPARATOR);
/**
 * 
 * Load application configuration
 * 
 * 
 */
require dirname(__DIR__).'/config/app.php';
/**
 * 
 * 
 * Load core
 * 
 */
require dirname(__DIR__).'/vendor/autoload.php';
/**
 * 
 * 
 * load routes
 * 
 */
require dirname(__DIR__).'/routes/app.php';
