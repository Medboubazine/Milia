<?php
use Milia\Framework\Core\Controller;
use Milia\Framework\Database\Connection;
class AppController extends Controller{


public function index(){
    $conn = (new Connection())->db_name;
    return view('welcome',['name'=>$conn]);
}
}
