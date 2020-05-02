<?php


namespace App\Model;


class Link
{
    protected int $id;
    protected string $url;

    /**
     * Link constructor.
     * @param int $id
     * @param string $url
     */
    public function __construct(int $id, string $url)
    {
        $this->id = $id;
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}