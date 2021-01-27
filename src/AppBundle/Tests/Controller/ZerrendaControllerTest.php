<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ZerrendaControllerTest extends WebTestCase
{
    public function testAbsentismo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/absentismo');
    }

    public function testKonpentsatuak()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/konpentsatuak');
    }

}
