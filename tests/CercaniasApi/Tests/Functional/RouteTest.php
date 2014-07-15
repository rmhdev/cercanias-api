<?php

namespace CercaniasApi\Tests;

use Cercanias\Entity\Route;
use Cercanias\Entity\Station;
use Symfony\Component\HttpKernel\Client;

class RouteTest extends AbstractTest
{
    public function testEmptyRouteMustReturnListOfRoutes()
    {
        $client = $this->createClient();
        $client->request("GET", "/route");
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("application/json", $response->headers->get("Content-Type"));

        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertTrue(array_key_exists("routes", $jsonResponse));
        $this->assertEquals(12, sizeof($jsonResponse["routes"]));
    }

    public function testIncorrectRouteIdMustReturnError()
    {
        $client = $this->createClient();
        $client->request("GET", "/route/0");
        $response = $client->getResponse();

        $this->assertTrue($response->isClientError());
        $this->assertEquals("application/json", $response->headers->get("Content-Type"));
        $expectedError = array(
            "message" => "Invalid routeId"
        );
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertEquals($expectedError, $jsonResponse);
    }

    public function testGetRoute()
    {
        $expectedRoute = $this->createRoute();
        $client = $this->createClientWithMockCercaniasReturnRoute($expectedRoute);
        $client->request("GET", "/route/61");
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("application/json", $response->headers->get("Content-Type"));

        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertEquals("San Sebastián", $jsonResponse["name"]);
        $this->assertEquals(61, $jsonResponse["id"]);
        $this->assertEquals(3, sizeof($jsonResponse["stations"]));
    }

    protected function createRoute()
    {
        $route = new Route(61, "San Sebastián");
        $route->addStation(new Station("111", "Station 1", 61));
        $route->addStation(new Station("222", "Station 2", 61));
        $route->addStation(new Station("333", "Station 3", 61));

        return $route;
    }

    protected function createClientWithMockCercaniasReturnRoute(Route $route)
    {
        $mockCercanias = $this->getMock('\CercaniasApi\Tests\EmptyCercanias');
        $mockCercanias
            ->expects($this->once())
            ->method("getRoute")
            ->will($this->returnValue($route))
        ;
        $app = $this->createApplication();
        $app["cercanias"] = $mockCercanias;

        return new Client($app);
    }

    public function testCachedRouteList()
    {
        $client = $this->createClient();
        $client->request("GET", "/route");
        $response = $client->getResponse();

        $this->assertTrue($response->isCacheable());
        $this->assertEquals(3600, $response->getMaxAge());
        $this->assertTrue($response->isValidateable());
    }

    public function testCachedRoute()
    {
        $expectedRoute = $this->createRoute();
        $client = $this->createClientWithMockCercaniasReturnRoute($expectedRoute);
        $client->request("GET", "/route/61");
        $response = $client->getResponse();

        $this->assertTrue($response->isCacheable());
        $this->assertEquals(3600, $response->getMaxAge());
        $this->assertTrue($response->isValidateable());
    }
}


