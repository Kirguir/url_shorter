<?php


namespace App\Service;


class Shorter implements \App\Shorter
{
    private static string $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function createShortLink(int $id): string
    {
        $b = 62;
        $r = $id % $b;
        $result = static::$base[$r];
        $q = floor($id / $b);

        while ($q) {
            $r = $q % $b;
            $q = floor($q / $b);
            $result = static::$base[$r] . $result;
        }

        return $result;
    }

    public static function decodeShortLink(string $short): int
    {
        $b = 62;
        $limit = strlen($short);
        $result = strpos(static::$base, $short[0]);

        for ($i = 1; $i < $limit; $i++) {
            $result = $b * $result + strpos(static::$base, $short[$i]);
        }

        return $result;
    }
}