<?php

namespace CercaniasApi\Tests;

use Cercanias\Entity\Route;
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
}
