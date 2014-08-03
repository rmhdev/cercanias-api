<?php

namespace CercaniasApi\Tests;

use CercaniasApi\Result\RoutesResult;

class RoutesResultTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $routesResult = new RoutesResult();
        $result = $routesResult->toArray();

        $this->assertTrue(array_key_exists("routes", $result));
        $this->assertEquals(12, sizeof($result["routes"]));

        $route = $result["routes"][0];
        $this->assertTrue(array_key_exists("url", $route));
        $this->assertRegExp('/http:\/\/localhost\/route\/\w/', $route["url"]);
    }

    public function testRouteUrlWithCustomServerUrl()
    {
        $routesResult = new RoutesResult("http://example.com");
        $result = $routesResult->toArray();
        $route = $result["routes"][0];
        $this->assertRegExp('/http:\/\/example.com\/route\/\w/', $route["url"]);
    }
}
