<?php


namespace App;


use Psr\Http\Message\ServerRequestInterface;

interface RequestParser
{
    public function parse(ServerRequestInterface $request): void;

    public function getCountry(): ?string;

    public function getBrowser(): ?string;

    public function getVersion(): ?int;

    public function getOS(): ?string;
}