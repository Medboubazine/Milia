<?php
namespace Milia\Framework\Database;
use Milia\Framework\Database\Connection;

class DB {
/**
 * 
 * 
 * 
 */
public function connection(string $name = ''){
    return (new Connection($name))->conn();
}
}
