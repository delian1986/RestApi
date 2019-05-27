<?php


namespace Src\Services;


use Generator;
use Src\Models\ArticleModel;
use Src\Repository\ArticleRepository;
use Src\Repository\ArticleRepositoryInterface;

class ArticleService implements ArticleServiceInterface
{
    /**
     * @var ArticleRepositoryInterface
     */
    private $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    /**
     * @return Generator|ArticleModel[]
     */
    public function getAll()
    {
        return $this->articleRepository->getAllPublished();
    }

    /**
     * @param int $id
     * @return ArticleModel
     */
    public function getById($id): ArticleModel
    {
        return $this->articleRepository->getById($id);
    }

    /**
     * @param string $time
     * @return Generator|ArticleModel[]
     */
    public function getLatestPublicByTime($time)
    {
        $tokens = explode("=", $time);
        $minutes = $tokens[1];
        return $this->articleRepository->getLatestByTime($minutes);
    }

    public function getAllDeleted()
    {
        return $this->articleRepository->getAllDeleted();
    }

    /**
     * @param int $id
     * @return Generator
     */
    public function getByCategoryId($id)
    {
        return $this->articleRepository->getAllByCategoryId($id);
    }

    /**
     * @param array $input
     * @return bool
     */
    public function create(array $input):bool
    {
        return $this->articleRepository->create($input);
    }

    /**
     * @param array $input
     * @param int $id
     * @return bool
     */
    public function statusUpdate(array $input,int $id): bool
    {
        $statusName=ucfirst($input['status']);
        return $this->articleRepository->statusUpdate($statusName,$id);
    }
}