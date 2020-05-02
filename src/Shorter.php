<?php


namespace App;


interface Shorter
{
    public static function createShortLink(int $id): string;

    public static function decodeShortLink(string $short): int;
}