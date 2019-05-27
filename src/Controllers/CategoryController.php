<?php


namespace Src\Controllers;


class CategoryController extends AbstractController
{
    function processRequest()
    {
        $result = null;
        $statusCode = null;

        switch ($this->method) {
            case 'GET':
                if ($this->id) {
                    // path: category/?{id}
                    $result = $this->articleService->getByCategoryId($this->id);
                    $statusCode = 200;
                }
                break;
            default:
                $statusCode = 404;
        }

        $this->jsonResponse($result, $statusCode);
    }
}