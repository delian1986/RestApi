<?php


namespace Src\Models;


use DateTime;
use JsonSerializable;

class ArticleModel implements JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var CategoryModel
     */
    private $category;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $event = null;

    /**
     * @var string
     */
    private $location = null;

    /**
     * @var DateTime
     */
    private $published;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return CategoryModel
     */
    public function getCategory(): CategoryModel
    {
        return $this->category;
    }

    /**
     * @param CategoryModel $category
     */
    public function setCategory(CategoryModel $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getEvent(): ?string
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent(?string $event): void
    {
        if ($event===''){
            $event=null;
        }
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getLocation(): ?string
    {

        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(?string $location): void
    {
        if ($location===''){
            $location=null;
        }
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getPublished(): string
    {
        return $this->published;
    }

    /**
     * @param string $published
     */
    public function setPublished(string $published): void
    {
        $this->published = $published;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "category" => [
                "id" => $this->getCategory()->getId(),
                "name" => $this->getCategory()->getName()
            ],
            "title" => $this->getTitle(),
            "content" => $this->getContent(),
            "event" => $this->getEvent(),
            "location" => $this->getLocation(),
            "published" => $this->getPublished()
        ];
    }
}