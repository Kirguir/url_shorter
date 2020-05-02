<?php


namespace App\Model;


class LinkView
{
    protected int $link_id;
    protected string $ip;
    protected string $viewed_at;
    protected ?string $country;
    protected ?string $browser;
    protected ?int $version;
    protected ?string $os;

    /**
     * LinkView constructor.
     * @param int $link_id
     * @param string $ip
     * @param string $viewed_at
     * @param string $country
     * @param string $browser
     * @param int $version
     * @param string $os
     */
    public function __construct(
        int $link_id,
        string $ip,
        string $viewed_at,
        string $country = null,
        string $browser = null,
        int $version = null,
        string $os = null
    )
    {
        $this->link_id = $link_id;
        $this->ip = $ip;
        $this->country = $country;
        $this->browser = $browser;
        $this->version = $version;
        $this->os = $os;
        $this->viewed_at = $viewed_at;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getViewedAt(): string
    {
        return $this->viewed_at;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return string|null
     */
    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    /**
     * @return int|null
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @return string|null
     */
    public function getOs(): ?string
    {
        return $this->os;
    }
}