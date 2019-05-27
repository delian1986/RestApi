<?php


namespace Src\Database;


interface ResultSetInterface
{
    public function fetch():\Generator;
}