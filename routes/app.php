<?php
use Milia\Framework\Core\Route;
/**
 * 
 * Web routes
 * 
 * here you can register all routes
 * 
 */
//welcome page
Route::register('welcome','/','AppController#index',['get']);