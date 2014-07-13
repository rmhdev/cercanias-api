<?php

namespace CercaniasApi\Tests;

use Cercanias\Entity\Route;
use Cercanias\Entity\Station;
use CercaniasApi\Result\RouteResult;

class RouteResultTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleRouteToArray()
    {
        $route = $this->createSimpleRoute();
        $routeResult = new RouteResult($route);
        $data = $routeResult->toArray();

        $this->assertEquals(61, $data["id"]);
        $this->assertEquals("San Sebastián", $data["name"]);
        $this->assertEquals("http://localhost/route/61", $data["url"]);
        $this->assertEquals(array(), $data["stations"]);
    }

    protected function createSimpleRoute()
    {
        return new Route(61, "San Sebastián");
    }

    public function testStations()
    {
        $route = $this->createCompleteRoute();
        $routeResult = new RouteResult($route);
        $data = $routeResult->toArray();

        $stations = $data["stations"];
        $this->assertEquals(3, sizeof($stations));

        $expectedStations = array(
            array("id" => "111", "name" => "Station 1", "route_id" => 61),
            array("id" => "222", "name" => "Station 2", "route_id" => 61),
            array("id" => "333", "name" => "Station 3", "route_id" => 61),
        );
        $this->assertEquals($expectedStations, $stations);
    }

    protected function createCompleteRoute()
    {
        $route = $this->createSimpleRoute();
        $route->addStation( new Station("111", "Station 1", $route->getId()));
        $route->addStation( new Station("222", "Station 2", $route->getId()));
        $route->addStation( new Station("333", "Station 3", $route->getId()));

        return $route;
    }
}
