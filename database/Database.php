<?php
namespace db;

/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 12.01.17
 * Time: 0:17
 */
class Database
{
    private $pdo;
    private static $_instance; //The single instance
    private $dns = 'mysql:host=localhost;dbname=universal_trade;charset=utf8';
    private $usr = 'universal_trade';
    private $pwd = 'CVCBRhdQbFr68bC5';

    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if(!self::$_instance)
        {
            // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Constructor
    private function __construct()
    {
        $this->pdo = new \Slim\PDO\Database($this->dns, $this->usr, $this->pwd);
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone() { }

    // Get mysqli connection
    public function getPdo()
    {
        return $this->pdo;
    }
}