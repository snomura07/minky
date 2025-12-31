<?php

class Db {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {

            $host = getenv('DB_HOST');
            $name = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                $host,
                $name
            );

            self::$instance = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return self::$instance;
    }
}
