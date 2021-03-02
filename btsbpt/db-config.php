<?php

    class DBConfig {
        
        public static $conn = null;
        public static $pdo = null;

        function getConn() {

            if (!self::$conn) {
                self::$conn = mysqli_connect('localhost', 'u606326170_eventmanager', '#QazEdcTgbUjm@15*', 'u606326170_sucdecdo');
        
                if (!self::$conn) {
                    echo "Error: Unable to connect to MySQL." . PHP_EOL;
                    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                    exit();
                }
            }
            return self::$conn;
        }

        function getPdo() {

            if (!self::$pdo) {
                $host = '127.0.0.1';
                $db   = 'u606326170_sucdecdo';
                $user = 'u606326170_eventmanager';
                $pass = '#QazEdcTgbUjm@15*';
                $port = "3306";
                $charset = 'utf8mb4';
            
                $options = [
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
                try {
                    self::$pdo = new \PDO($dsn, $user, $pass, $options);
                } catch (\PDOException $e) {
                    throw new \PDOException($e->getMessage(), (int)$e->getCode());
                }
            }

            return self::$pdo;
        }
    }

?>