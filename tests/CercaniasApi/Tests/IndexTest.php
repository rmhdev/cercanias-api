<?php

namespace CercaniasApi\Functional;

use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernel;

class IndexTest extends WebTestCase
{
    /**
     * Creates the application.
     *
     * @return HttpKernel
     */
    public function createApplication()
    {
        return require __DIR__ . "/../../../src/env_test.php";
    }

    public function testLoadIndexPage()
    {
        $client = $this->createClient();
        $client->request("GET", "/");
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("application/json", $response->headers->get("Content-Type"));
    }
}
