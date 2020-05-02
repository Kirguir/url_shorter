<?php


use App\Service\Shorter;
use PHPUnit\Framework\TestCase;

class ShorterTest extends TestCase
{
    public function testCreateShortLink()
    {
        $id = 12586;
        $encoded = Shorter::createShortLink($id);
        $decoded = Shorter::decodeShortLink($encoded);

        $this->assertEquals($decoded, $id);
    }
}