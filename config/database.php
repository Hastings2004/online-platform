<?php

class Database{
    public function connect() {
        try {
            $dsn = 'mysql:host=localhost;dbname=platform';
            $username = 'root';
            $password = '';
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            );
            $conn = new PDO($dsn, $username, $password, $options);
            return $conn;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}
?>
