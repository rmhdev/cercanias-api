<?php

namespace CercaniasApi\Tests;

use Cercanias\Entity\Station;
use Cercanias\Entity\Timetable;
use Cercanias\Entity\Train;
use Cercanias\Entity\Trip;
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

        $this->assertEmpty($data["transfer"]);
        $this->assertEmpty($data["trips"]);
        $this->assertEmpty($data["date"]);
    }

    public function testTimetableWithTransferToArray()
    {
        $timetable = new Timetable(
            new Station("111", "Departure station", 1),
            new Station("222", "Destination station", 1),
            "Transfer station"
        );
        $transfers = array(
            new Train("c2", new \DateTime("2014-07-13T12:40:00+02:00"), new \DateTime("2014-07-13T12:50:00+02:00"))
        );
        $timetable->addTrip(new Trip(
            new Train("c1", new \DateTime("2014-07-13T12:00:00+02:00"), new \DateTime("2014-07-13T12:35:00+02:00")),
            $transfers
        ));
        $result = new TimetableResult($timetable);
        $data = $result->toArray();

        $expectedTransfer = array(
            "id" => "", "name" => "Transfer station", "route_id" => 1
        );
        $this->assertEquals($expectedTransfer, $data["transfer"]);

        $expectedTrips = array(
            array(
                "line"      => "c1",
                "departure" => "2014-07-13T12:00:00+02:00",
                "arrival"   => "2014-07-13T12:35:00+02:00",
                "transfers" => array(
                    array(
                        "line"      => "c2",
                        "departure" => "2014-07-13T12:40:00+02:00",
                        "arrival"   => "2014-07-13T12:50:00+02:00",
                    )
                )
            )
        );
        $this->assertEquals($expectedTrips  , $data["trips"]);
        $this->assertEquals("2014-07-13"    , $data["date"]);
    }
}
