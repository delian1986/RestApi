<?php


namespace Src\Database;


interface DatabaseInterface
{
    public function query(string $query):StatementInterface;
}