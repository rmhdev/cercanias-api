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
            "timetable_url" => "http://localhost/timetable/{routeId}/{departureId}/{destinationId}",
        );
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertEquals($jsonExpected, $jsonResponse);
    }
}
