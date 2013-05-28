<?php

namespace DW\EntityManagerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Classe de test du controlleur par defaut
 */
class DefaultControllerTest extends WebTestCase
{
  /**
   * Fonction de test de la page d'accueil
   */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
