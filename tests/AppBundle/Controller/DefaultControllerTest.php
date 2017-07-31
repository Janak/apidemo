<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }
    
    
    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'janak', $password = 'janak')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            array(
                '_username' => $username,
                '_password' => $password,
            )
            );
    
        $data = json_decode($client->getResponse()->getContent(), true);
    
        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));
    
        return $client;
    }
    
    /**
     * test getPagesAction
     */
    public function testGetPages()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api');
        // ...
    }
}
