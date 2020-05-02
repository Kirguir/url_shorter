<?php


namespace App\Request;


use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class AddLinkRequest
{
    protected string $url;

    /**
     * AddLinkRequest constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $data = $request->getParsedBody();
        if (!isset($data['url']) || empty($data['url'])
            || !filter_var($data['url'], FILTER_VALIDATE_URL)
        ) {
            throw new InvalidArgumentException('Not a valid URL');
        }
        return new self($data['url']);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
