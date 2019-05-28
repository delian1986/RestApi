<?php

namespace src\Controllers;

use Generator;
use Src\Services\ArticleService;
use Src\Services\ArticleServiceInterface;

abstract class AbstractController
{
    protected $method;
    protected $id;
    protected $query;

    /**
     * @var ArticleServiceInterface
     */
    protected $articleService;

    /**
     * AbstractController constructor.
     * @param $method
     * @param $id
     * @param null $query
     */
    public function __construct($method, $id = null, $query = null)
    {
        $this->method = $method;
        $this->id = $id;
        $this->query = $query;
        $this->articleService = new ArticleService();
    }

    abstract function processRequest();

    /**
     * @param $data
     * @param $statusCode
     */
    protected function jsonResponse($data, $statusCode)
    {
        $body = $this->jsonSerialize($data);
        $statusMessage=$this->getHttpStatusMessage($statusCode);

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET,POST,PUT");
        header($response['status_code_header'] = "HTTP/1.1 $statusCode $statusMessage");
        echo $response['body'] = $body;
    }

    protected function jsonSerialize($data): string
    {
        if ($data instanceof Generator) {
            $jsonArray = [];
            foreach ($data as $row) {
                $json = json_encode($row, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                $jsonArray[] = $json;
            }
            return json_encode($jsonArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * @param $statusCode
     * @return string
     */
    private function getHttpStatusMessage($statusCode):string
    {
        $httpStatus = array(
            200 => 'OK',
            201 => 'Created',
            400 => 'Bad Request',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return $httpStatus[$statusCode];
    }
}