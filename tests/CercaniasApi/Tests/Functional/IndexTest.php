<?php

namespace CercaniasApi\Tests;

class IndexTest extends AbstractTest
{
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
            "routes_url"     => "http://localhost/route",
            "route_url"     => "http://localhost/route/{routeId}",
            "timetable_url" => "http://localhost/timetable/{routeId}/{departureId}/{destinationId}/{date}",
        );
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertEquals($jsonExpected, $jsonResponse);
    }

    public function testCachedPage()
    {
        $client = $this->createClient();
        $client->request("GET", "/");
        $response = $client->getResponse();

        $this->assertTrue($response->isCacheable());
        $this->assertEquals(3600, $response->getMaxAge());
        $this->assertTrue($response->isValidateable());
    }

    public function testCorsEnabled()
    {
        $client = $this->createClient();
        $client->request("GET", "/");
        $response = $client->getResponse();

        $this->assertEquals("*", $response->headers->get("Access-Control-Allow-Origin"));
        $this->assertEquals("GET", $response->headers->get("Access-Control-Allow-Methods"));
    }

    // Preflight requests: as this project only uses simple methods
    // (in this case, GET) there's no need to add this feature.
}
