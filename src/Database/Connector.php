<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

class Connector
{

    private $host;
    private $dbname;
    private $user;
    private $pass;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->host = $_ENV['SQL_SERVER'];
        $this->dbname = $_ENV['SQL_DB'];
        $this->user = $_ENV['SQL_USERNAME'];
        $this->pass = $_ENV['SQL_PASSWORD'];
    }


    protected function getConnection()
    {
        try {
            $connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (PDOException $e) {
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
            die();
        }
    }
}
