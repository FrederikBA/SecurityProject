<?php

require 'vendor/autoload.php'; // Load Composer's autoloader

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

    public function getConnection()
    {
        $connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
}