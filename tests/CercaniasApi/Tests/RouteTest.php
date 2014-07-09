<?php

namespace CercaniasApi\Tests;

class RouteTest extends AbstractTest
{
    public function testLoadRoutePage()
    {
        $client = $this->createClient();
        $client->request("GET", "/route/1");
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("application/json", $response->headers->get("Content-Type"));
    }

    public function testEmptyRouteMustReturnError()
    {
        $client = $this->createClient();
        $client->request("GET", "/route/");
        $response = $client->getResponse();

        $this->assertTrue($response->isClientError());
        $this->assertEquals("application/json", $response->headers->get("Content-Type"));
        $expectedError = array(
            "message" => "Invalid routeId"
        );
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertEquals($expectedError, $jsonResponse);
    }
}
