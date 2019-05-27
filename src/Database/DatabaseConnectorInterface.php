<?php


namespace Src\Database;


use PDO;

interface DatabaseConnectorInterface
{
    public function getConnection(): PDO;
}