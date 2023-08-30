<?php

class Connector
{
    private $host = "localhost";
    private $dbname = "demo_login";
    private $user = "root";
    private $pass = "1234";

    public function getConnection()
    {
        $connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
}
