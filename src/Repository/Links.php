<?php


namespace App\Repository;


use App\Model\Link;
use App\Model\LinksRepository;
use App\Model\LinkView;
use PDO;

class Links implements LinksRepository
{
    protected PDO $db;

    /**
     * Links constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getLinkByID(int $id): ?Link
    {
        $sql = "SELECT id, url FROM links WHERE id = ?";
        $stm = $this->db->prepare($sql);
        $stm->execute([$id]);
        if ($data = $stm->fetch(PDO::FETCH_ASSOC)) {
            return new Link($data['id'], $data['url']);
        }
        return null;
    }

    public function newLink(string $url): Link
    {
        $sql = 'INSERT INTO links SET url = ?';
        $stm = $this->db->prepare($sql);
        $stm->execute([$url]);

        $id = $this->db->lastInsertId();
        return new Link($id, $url);
    }

    public function newView(
        int $link_id,
        string $ip,
        string $viewed_at,
        string $country = null,
        string $browser = null,
        int $version = null,
        string $os = null
    ): LinkView
    {
        $sql = 'INSERT INTO views SET link_id=?, ip=INET_ATON(?), viewed_at=?, country=?, browser=?, version=?, os=?';
        $stm = $this->db->prepare($sql);
        $stm->execute([$link_id, $ip, $viewed_at, $country, $browser, $version, $os]);

        return new LinkView($link_id, $ip, $viewed_at, $country, $browser, $version, $os);
    }

    public function getViewsByLinkId(int $id): array
    {
        $sql = 'SELECT INET_NTOA(ip) as ip, viewed_at, country, browser, version, os FROM views WHERE link_id=?';
        $stm = $this->db->prepare($sql);
        $stm->execute([$id]);
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        $views = [];
        foreach ($data as $view) {
            $views[] = new LinkView(
                $id,
                $view['ip'],
                $view['viewed_at'],
                $view['country'],
                $view['browser'],
                $view['version'],
                $view['os'],
            );
        }
        return $views;
    }
}