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
            "route_url"     => "http://localhost/route",
            "timetable_url" => "http://localhost/timetable",
        );
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertEquals($jsonExpected, $jsonResponse);
    }
}
