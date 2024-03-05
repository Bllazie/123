<?php
class DBConnection {

    private static $instance = null;


    public static function getInstance() {
        if (!self::$instance) {
            try {
                $hostname = "localhost";
                $username = "root";
                $password = "";
                $dbname = "jewelry";

                $dsn = "mysql:host=$hostname;dbname=$dbname";
                self::$instance = new PDO($dsn, $username, $password);


                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$instance;
    }


    private function __construct() {}


    private function __clone() {}


    public function __wakeup() {}
}

// Использование:
$pdo = DBConnection::getInstance();
