<?php


namespace Src\Controllers;


class ArticleController extends AbstractController
{

    function processRequest()
    {
        $result = null;
        $statusCode = null;

        switch ($this->method) {
            case 'GET':
                if (false !== strpos($this->query, 'published')) {
                    // path: article/?published={time in minutes}
                    $result = $this->articleService->getLatestPublicByTime($this->query);
                    $statusCode = 200;
                } else if (false !== strpos($this->query, 'deleted')) {
                    // path: article/?deleted
                    $result = $this->articleService->getAllDeleted();
                    $statusCode = 200;
                } else if ($this->id) {
                    //path: article/{id}
                    $result = $this->articleService->getById($this->id);
                    if ($result) {
                        $statusCode = 200;
                    } else {
                        $statusCode = 404;
                    }
                } else {
                    //path: article/
                    $result = $this->articleService->getAll();
                    $statusCode = 200;
                }
                break;
            case
            'POST':
                //path: article/
                $request = json_decode(file_get_contents('php://input'), true);
                if ($request) {
                    $result = $this->articleService->create($request);
                    $result = $this->jsonSerialize(array("message" => "article created"));
                    $statusCode = 201;
                } else {
                    $statusCode = 422;
                }
                break;
            case 'PUT':
                //path: article/{id}/
                $request = json_decode(file_get_contents('php://input'), true);
                if ($request) {
                    $result = $this->articleService->statusUpdate($request, $this->id);
                    if ($result) {
                        $statusCode = 200;
                        $result = $this->jsonSerialize(array("message" => "article updated"));
                    } else {
                        $statusCode = 404;
                    }
                }
                break;
            default:
                $statusCode = 404;
        }

        $this->jsonResponse($result, $statusCode);
    }
}