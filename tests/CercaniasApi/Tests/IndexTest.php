<?php

namespace CercaniasApi\Tests;

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
        return require __DIR__ . "/../../../config/env_test.php";
    }

    public function testLoadIndexPage()
    {
        $client = $this->createClient();
        $client->request("GET", "/");
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("application/json", $response->headers->get("Content-Type"));
    }

    public function testIndexPageShowsUrls()
    {
        $client = $this->createClient();
        $client->request("GET", "/");
        $response = $client->getResponse();

        $jsonExpected = array(
            "route_url"     => "http://localhost/route",
            "timetable_url" => "http://localhost/timetable",
        );
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertEquals($jsonExpected, $jsonResponse);
    }
}
