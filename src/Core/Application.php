<?php


namespace Src\Core;


use src\Controllers\AbstractController;

class Application
{
    private $controllerName;
    private $id;
    private $method;
    private $query;

    /**
     * Application constructor.
     * @param $controllerName
     * @param $method
     * @param $id
     * @param null $query
     */
    public function __construct($controllerName, $method, $id = null, $query = null)
    {
        $this->controllerName = $controllerName;
        $this->method = $method;
        $this->id = $id;
        $this->query = $query;
    }

    /**
     * @var AbstractController $controller
     */
    public function start(): void
    {
        $fullQualifiedName = DIRECTORY_SEPARATOR . 'Src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . ucfirst($this->controllerName) . 'Controller';
        $controller = new $fullQualifiedName($this->method, $this->id, $this->query);

        $controller->processRequest();
    }
}