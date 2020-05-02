<?php


namespace App\Controller;


use App\Controller;
use App\Model\LinksRepository;
use App\Request\AddLinkRequest;
use App\RequestParser;
use App\Service\Shorter;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class LinkController extends Controller
{
    protected LinksRepository $repository;
    protected RequestParser $parser;

    /**
     * LinkController constructor.
     * @param LinksRepository $repository
     * @param RequestParser $parser
     */
    public function __construct(LinksRepository $repository, RequestParser $parser)
    {
        $this->repository = $repository;
        $this->parser = $parser;
    }

    public function index(): void
    {
        $this->render('add');
    }

    public function addLink(ServerRequestInterface $request): void
    {
        try {
            $addRequest = AddLinkRequest::fromRequest($request);
            $link = $this->repository->newLink($addRequest->getUrl());
            $short = Shorter::createShortLink($link->getId());

            $uri = $request->getUri();

            $short_link = $uri->getScheme() . '://' . $uri->getHost() . '/' . $short;
            $stat_link = $uri->getScheme() . '://' . $uri->getHost() . '/stat/' . $short;

            $this->render('result', [
                'short_link' => $short_link,
                'stat_link' => $stat_link
            ]);
        } catch (InvalidArgumentException $e) {
            $alert = $e->getMessage();
            $this->render('add', ['alert' => $alert]);
        }
    }

    public function viewLink(ServerRequestInterface $request, string $short_url): void
    {
        $id = Shorter::decodeShortLink($short_url);
        if ($link = $this->repository->getLinkByID($id)) {
            $data = $request->getServerParams();
            $this->parser->parse($request);
            $this->repository->newView(
                $link->getId(),
                $data['REMOTE_ADDR'],
                date('Y-m-d H:i:s', $data['REQUEST_TIME']),
                $this->parser->getCountry(),
                $this->parser->getBrowser(),
                $this->parser->getVersion(),
                $this->parser->getOS(),
            );
            header('Location: ' . $link->getUrl(), true, 302);
            exit();
        }
        $alert = 'Invalid URL';
        $this->render('add', ['alert' => $alert]);
    }

    public function statistic(string $short_url): void
    {
        $id = Shorter::decodeShortLink($short_url);
        $views = $this->repository->getViewsByLinkId($id);

        $this->render('statistic', [
            'views' => $views,
        ]);
    }
}
