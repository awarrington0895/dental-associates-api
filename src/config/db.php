<?php
    class Database {
        // Properties
        private $host = 'localhost';
        private $user = 'root';
        private $pass = '';
        private $name = 'slimapp';

        // Connect
        public function connect() {
            $mysql_connect_str = "mysql:host=$this->host;dbname=$this->name";
            $dbConnection = new PDO($mysql_connect_str, $this->user, $this->pass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        }
    }