<?php

class DatabaseConnection {
    private $host = "localhost";
    private $dbname = "shopdb";
    private $user = "root";
    private $pass = "";

    public function getConnection() {
        $connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
}
