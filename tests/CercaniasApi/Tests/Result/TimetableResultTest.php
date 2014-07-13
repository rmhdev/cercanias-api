<?php

namespace CercaniasApi\Tests;

use Cercanias\Entity\Station;
use Cercanias\Entity\Timetable;
use CercaniasApi\Result\TimetableResult;

class TimetableResultTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleTimetableToArray()
    {
        $timetable = new Timetable(
            new Station("111", "Departure station", 1),
            new Station("222", "Destination station", 1)
        );
        $result = new TimetableResult($timetable);
        $data = $result->toArray();

        $expectedDeparture = array(
            "id" => "111", "name" => "Departure station", "route_id" => 1
        );
        $this->assertEquals($expectedDeparture, $data["departure"]);

        $expectedDestination = array(
            "id" => "222", "name" => "Destination station", "route_id" => 1
        );
        $this->assertEquals($expectedDestination, $data["destination"]);
    }
}
