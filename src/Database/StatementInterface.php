<?php


namespace Src\Database;


interface StatementInterface
{
    public function execute(... $params):ResultSetInterface;
}