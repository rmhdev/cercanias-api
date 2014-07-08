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
}
