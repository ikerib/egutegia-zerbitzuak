<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DefaultControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function doLogin($username, $password): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form    = $crawler->selectButton('_submit')->form(
            array(
                '_username' => $username,
                '_password' => $password,
            )
        );
        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect());

        $crawler = $this->client->followRedirect();
    }

    public function testLogin(): void
    {

        $crawler = $this->client->request('GET', '/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Hasi saioa', $crawler->filter('.form-signin-heading')->text());
    }


    public function testMycalendar(): void
    {
        $this->doLogin('iibarguren', 'pasadon');
        $crawler = $this->client->request('GET', '/mycalendar');
        $this->assertSame('IKER IBARGUREN BERASALUZE', $crawler->filter('h3')->text());

    }

}
