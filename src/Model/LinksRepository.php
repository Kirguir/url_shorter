<?php


namespace App\Model;


interface LinksRepository
{
    public function getLinkByID(int $id): ?Link;

    public function newLink(string $url): Link;

    public function newView(
        int $link_id,
        string $ip,
        string $viewed_at,
        string $country = null,
        string $browser = null,
        int $version = null,
        string $os = null
    ): LinkView;

    public function getViewsByLinkId(int $id): array;
}