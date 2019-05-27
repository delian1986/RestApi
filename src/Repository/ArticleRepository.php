<?php

namespace Src\Repository;


use Generator;
use Src\Core\ModelBinder;
use Src\Database\DatabaseConnector;
use Src\Database\DatabaseInterface;
use Src\Database\PDODatabase;
use Src\Models\ArticleModel;
use Src\Models\CategoryModel;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var DatabaseInterface
     */
    private $db;

    /**
     * @var ModelBinder
     */
    private $binder;

    /**
     * ArticleRepository constructor.
     */
    public function __construct()
    {
        $pdo = (new DatabaseConnector())->getConnection();
        $this->db = new PDODatabase($pdo);

        $this->binder = new ModelBinder();
    }

    /**
     * @return Generator
     */
    public function getAllPublished(): Generator
    {
        $qry = "SELECT 
                        a.id,
                        a.title,
                        a.content,
                        c.id,
                        c.name,
                        a.`event`,
                        a.location,
                        a.published
                            FROM article_status AS ars
                                JOIN article AS a ON a.id=ars.article_id
                                JOIN `status` AS s ON s.id=ars.status_id
                                JOIN category AS c ON c.id=a.category_id
                            WHERE s.NAME='Open'
                            ORDER BY a.published DESC";

        $lazyArticlesResult = $this->db->query($qry)
            ->execute()
            ->fetch();

        foreach ($lazyArticlesResult as $row) {
            /** @var ArticleModel $article */
            $article = $this->binder->bind($row, ArticleModel::class);

            /** @var CategoryModel $category */
            $category = $this->binder->bind($row, CategoryModel::class);

            $article->setCategory($category);

            yield $article;
        }
    }

    /**
     * @param int $id
     * @return ArticleModel
     */
    public function getById($id): ArticleModel
    {
        $qry = "SELECT a.id,
                    a.title,
                    a.content,
                    c.id,
                    c.name,
                    a.`event`,
                    a.location,
                    a.published
                FROM article a
                JOIN category c ON a.category_id=c.id
                WHERE a.id=? ";

        $row = $this->db->query($qry)
            ->execute($id)
            ->fetch()
            ->current();

        /** @var ArticleModel $article */
        $article = $this->binder->bind($row, ArticleModel::class);

        /** @var CategoryModel $category */
        $category = $this->binder->bind($row, CategoryModel::class);

        $article->setCategory($category);

        return $article;
    }

    /**
     * @param string $time
     * @return Generator|ArticleModel[]
     */
    public function getLatestByTime($time): Generator
    {
        $qry = "SELECT 
                a.id,
                a.title,
                a.content,
                c.id,
                c.name,
                a.`event`,
                a.location,
                a.published
                FROM article_status AS ars
                JOIN article AS a ON a.id=ars.article_id
                JOIN `status` AS s ON s.id=ars.status_id
                JOIN category AS c ON c.id=a.category_id
                WHERE a.published between (NOW() - interval ? minute) AND NOW()
                AND s.NAME='Open'
                ORDER BY a.published DESC
                ";

        $lazyArticlesResult = $this->db->query($qry)
            ->execute($time)
            ->fetch();

        foreach ($lazyArticlesResult as $row) {
            /** @var ArticleModel $article */
            $article = $this->binder->bind($row, ArticleModel::class);

            /** @var CategoryModel $category */
            $category = $this->binder->bind($row, CategoryModel::class);

            $article->setCategory($category);

            yield $article;
        }
    }

    /**
     * @return Generator|ArticleModel[]
     */
    public function getAllDeleted(): Generator
    {
        $qry = "SELECT 
                    a.id,
                    a.title,
                    a.content,
                    c.id ,
                    c.NAME,
                    a.`event`,
                    a.location,
                    a.published
                    FROM article_status AS ars
                    JOIN article AS a ON a.id=ars.article_id
                    JOIN `status` AS s ON s.id=ars.status_id
                    JOIN category AS c ON c.id=a.category_id
                    WHERE s.NAME != 'Open'
                ORDER BY a.published DESC";

        $lazyArticlesResult = $this->db->query($qry)
            ->execute()
            ->fetch();

        foreach ($lazyArticlesResult as $row) {
            /** @var ArticleModel $article */
            $article = $this->binder->bind($row, ArticleModel::class);

            /** @var CategoryModel $category */
            $category = $this->binder->bind($row, CategoryModel::class);

            $article->setCategory($category);

            yield $article;
        }
    }

    /**
     * @param $id
     * @return Generator
     */
    public function getAllByCategoryId(int $id): Generator
    {
        $qry = "SELECT 
             a.id,
            a.title,
            a.content,
            c.id ,
            c.NAME,
            a.`event`,
            a.location,
            a.published
            FROM article_status AS ars
            JOIN article AS a ON a.id=ars.article_id
            JOIN `status` AS s ON s.id=ars.status_id
            JOIN category AS c ON c.id=a.category_id
            WHERE a.category_id = ?
            ORDER BY a.published DESC";

        $lazyArticlesResult = $this->db->query($qry)
            ->execute($id)
            ->fetch();

        foreach ($lazyArticlesResult as $row) {
            /** @var ArticleModel $article */
            $article = $this->binder->bind($row, ArticleModel::class);

            /** @var CategoryModel $category */
            $category = $this->binder->bind($row, CategoryModel::class);

            $article->setCategory($category);

            yield $article;
        }
    }

    /**
     * @param array $input
     * @return bool
     */
    public function create(array $input): bool
    {
        foreach ($input as $row) {
            /** @var ArticleModel $article */
            $article = $this->binder->bind($row, ArticleModel::class);
            $qry = "INSERT INTO article (
                category_id, title, content, `event`,location)
                VALUES (?,?,?,?,?);";
            try {
                $this->db->query($qry)->execute(
                    $article->getCategory()->getId(),
                    $article->getTitle(),
                    $article->getContent(),
                    $article->getEvent(),
                    $article->getLocation()
                );
            } catch (\PDOException $e) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $statusName
     * @param int $articleId
     * @return bool
     */
    public function statusUpdate(string $statusName, int $articleId): bool
    {
        $qry = 'UPDATE article_status,
                        (SELECT id FROM `status`
                            INNER JOIN article_status AS ars ON `status`.id=ars.status_id
                            WHERE `status`.`name`=?)AS `id`
                  SET status_id = `id` WHERE article_status.article_id=?';
        try {
            $this->db->query($qry)->execute($statusName, $articleId);
            return true;
        }catch (\PDOException $e){
            return false;
        }
    }

}