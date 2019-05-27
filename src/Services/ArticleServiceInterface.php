<?php


namespace Src\Services;


use Generator;
use Src\Models\ArticleModel;

interface ArticleServiceInterface
{

    /**
     * @return Generator|ArticleModel[]
     */
    public function getAll();

    /**
     * @param int $id
     * @return ArticleModel
     */
    public function getById(int $id):ArticleModel;

    /**
     * @param string $time
     * @return Generator|ArticleModel[]
     */
    public function getLatestPublicByTime(string $time);

    /**
     * @return Generator|ArticleModel[]
     */
    public function getAllDeleted();

    /**
     * @param int $id
     */
    public function getByCategoryId(int $id);


    /**
     * @param array $input
     * @return bool
     */
    public function create(array $input):bool;

    /**
     * @param array $input
     * @param int $id
     * @return bool
     */
    public function statusUpdate(array $input, int $id):bool ;
}