<?php


namespace Src\Repository;


use Generator;
use Src\Models\ArticleModel;

interface ArticleRepositoryInterface
{
    /**
     * @return Generator|ArticleModel[]
     */
    public function getAllPublished(): Generator;

    /**
     * @param int $id
     * @return ArticleModel
     */
    public function getById($id): ArticleModel;

    /**
     * @param string $time
     * @return Generator|ArticleModel[]
     */
    public function getLatestByTime(string $time): Generator;

    /**
     * @return Generator|ArticleModel[]
     */
    public function getAllDeleted(): Generator;

    /**
     * @param $id
     * @return Generator
     */
    public function getAllByCategoryId(int $id): Generator;

    /**
     * @param array $input
     * @return bool
     */
    public function create(array $input): bool;

    /**
     * @param string $statusName
     * @param int $articleId
     * @return bool
     */
    public function statusUpdate(string $statusName, int $articleId): bool;
}