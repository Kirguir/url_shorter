<?php

use App\Conf;
use App\Model\LinksRepository;
use App\Repository\Links;
use App\RequestParser;
use App\Service\Parser;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use function DI\{create, factory, get};

Conf::parseFromFile();

return [
    PDO::class => factory(function () {
        $config = Conf::$Database;
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        return new PDO($dsn, $config['username'], $config['password'], $opt);
    }),

    LinksRepository::class => create(Links::class)
        ->constructor(get(PDO::class)),

    RequestParser::class => create(Parser::class),

    ServerRequestInterface::class => factory([ServerRequest::class, 'fromGlobals'])
];
