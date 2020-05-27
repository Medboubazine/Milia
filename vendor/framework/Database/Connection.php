<?php
namespace Milia\Framework\Database;
use Milia\Framework\Configuration\Config;
class Connection extends \PDO {
/**
 * 
 * Connection info
 * 
 */
private $connection = 'mysql';
private $host;
private $port;
private $username;
private $password;
private $db;
/**
 * 
 * Connection object
 * 
 */
private $conn = null;
/**
 * 
 * DB Connection name
 * 
 */
public $db_name = '';
/**
 * 
 * Connection status
 * 
 */
public $status = false;
/**
 * 
 * 
 * 
 */
public function __construct(string $connectionName = ''){
    $this->fillConnectionInformation($connectionName);
    $this->connect();
}
/**
 * 
 * 
 * 
 */
public function conn(){
    return $this->conn;
}
/**
 * 
 * 
 * 
 */
public function connect(){
    if ($this->port !== null && !is_numeric($this->port)) {
        $this->port = 3306;
    }
    $port = "port={$this->port}";
    $str = "{$this->connection}:host={$this->host};dbname={$this->db};{$port}";
    try {
        parent::__construct($str,$this->username,$this->password);
        $conn = $this->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        $this->conn = $conn;
        $this->status = true;
        $this->db_name = $this->db;
    } catch (\PDOException $e) {
        throw new \Exception($e->getMessage(),1);
    }
}
/**
 * 
 * Fill Connection information
 * 
 */
public function fillConnectionInformation(string $name){
    $name = (isset($name) && !empty($name) && is_array(Config::get("database.{$name}") && !empty(Config::get("database.{$name}")))) ? "{$name}." : '' ;
    $this->connection = Config::get("database.{$name}connection");
    $this->host = Config::get("database.{$name}host");
    $this->port = Config::get("database.{$name}port");
    $this->username = Config::get("database.{$name}username");
    $this->password = Config::get("database.{$name}password");
    $this->db = Config::get("database.{$name}name");
}
/**
 * 
 * 
 * 
 */
public function __desctuct(){
    $this->conn = null;
}
}