<?php

namespace CercaniasApi\Tests;

use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernel;

class RouteTest extends WebTestCase
{
    /**
     * Creates the application.
     *
     * @return HttpKernel
     */
    public function createApplication()
    {
        return require __DIR__ . "/../../../config/env_test.php";
    }

    public function testLoadRoutePage()
    {
        $client = $this->createClient();
        $client->request("GET", "/route/1");
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("application/json", $response->headers->get("Content-Type"));
    }
}
