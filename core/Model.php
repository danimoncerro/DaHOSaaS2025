<?php

namespace core;

use PDO;

class Model
{
    protected static function getConnection()
    {
        $host = 'localhost';
        $dbname = 'my_saas_app'; // ← modifică dacă baza ta de date are alt nume
        $username = 'root';
        $password = '';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            return new PDO($dsn, $username, $password);
        } catch (\PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}

