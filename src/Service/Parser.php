<?php


namespace App\Service;


use App\Conf;
use App\RequestParser;
use Exception;
use GeoIp2\WebService\Client;
use Psr\Http\Message\ServerRequestInterface;

class Parser implements RequestParser
{
    protected ?string $country = null;
    protected ?string $browser = null;
    protected ?int $version = null;
    protected ?string $os = null;

    public function parse(ServerRequestInterface $request): void
    {
        $data = $request->getServerParams();
        $user_agent = $data['HTTP_USER_AGENT'];
        $this->parseBrowser($user_agent);
        $this->parseOs($user_agent);
        $this->parseCountry($data['REMOTE_ADDR']);
    }

    protected function parseBrowser(string $user_agent): void
    {
        $pattern = '/(chrome|firefox|opera|safari|msie|trident(?=\/))\/(\d+)/i';
        if (preg_match($pattern, $user_agent, $matches)) {
            $this->browser = $matches[1];
            $this->version = (int)$matches[2];
        }
    }

    protected function parseOs(string $user_agent): void
    {
        $pattern = '/[a-z]+(?=\/)\/[0-9\.]+\s\((.*?)\)/i';
        if (preg_match($pattern, $user_agent, $matches)) {
            $this->os = $matches[1];
        }
    }

    protected function parseCountry(string $ip): void
    {
        $config = Conf::$GeoIP;
        $client = new Client($config['account_id'], $config['license_key']);
        try {
            $record = $client->country($ip);
            $this->country = $record->country->name;
        } catch (Exception $e) {
        }
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getOS(): ?string
    {
        return $this->os;
    }
}
