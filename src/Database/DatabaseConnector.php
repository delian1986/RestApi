<?php


namespace Src\Database;


use PDO;
use PDOException;

class DatabaseConnector implements DatabaseConnectorInterface
{
    private $dbConnection = null;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $db = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');

        try {
            $this->dbConnection = new PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $e) {
            exit ($e->getMessage());
        }
    }

    public function getConnection():PDO
    {
        return $this->dbConnection;
    }

}