<?php


namespace Src\Database;


use Generator;
use PDO;
use PDOStatement;

class PDOResultSet implements ResultSetInterface
{
    /**
     * @var PDOStatement
     */
    private $pdoStatement;

    /**
     * @param PDOStatement $pdoStatement
     */
    public function __construct(PDOStatement $pdoStatement)
    {
        $this->pdoStatement = $pdoStatement;
    }

    /**
     * @return Generator
     */
    public function fetch(): Generator
    {
        while ($row = $this->pdoStatement->fetch(PDO::FETCH_ASSOC)) {
            yield $row;
        }
    }


}