<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobControllerTest extends WebTestCase
{
    public function testJobs()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/jobs');
    }

}
