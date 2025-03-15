<?php

namespace App\Database;

use PDO;

class Database
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            $dsn = 'mysql:host=localhost;dbname=vetschedulerdb;charset=utf8mb4';
            $user = 'root';
            $password = 'mst2024';

            try {
                self::$instance = new PDO($dsn, $user, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                die('Connection failed: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
