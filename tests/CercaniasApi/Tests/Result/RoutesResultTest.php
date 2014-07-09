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
    }
}
