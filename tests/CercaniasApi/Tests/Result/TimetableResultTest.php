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

        $this->assertFalse($data["transfer"]);
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
        $this->assertEquals($expectedTrips              , $data["trips"]);
        $this->assertEquals("2014-07-13T00:00:00+02:00" , $data["date"]);
    }

    /**
     * @dataProvider getRouteInformationProvider()
     */
    public function testRouteInformation($routeId, $expectedRouteName)
    {
        $timetable = new Timetable(
            new Station("111", "Departure station", $routeId),
            new Station("222", "Destination station", $routeId)
        );
        $result = new TimetableResult($timetable);
        $data = $result->toArray();
        $expectedRoute = array(
            "id" => $routeId,
            "name" => $expectedRouteName,
            "url" => "http://localhost/route/" . $routeId
        );
        $this->assertEquals($expectedRoute, $data["route"]);
    }

    public function getRouteInformationProvider()
    {
        return array(
            array(20, "Asturias"),
            array(1, ""),
        );
    }

    public function testUrls()
    {
        $result = new TimetableResult($this->createSimpleTimetable());
        $data = $result->toArray();

        $this->assertEquals("http://localhost/timetable/1/222/111/2014-07-13", $data["return_url"]);
        $this->assertEquals("http://localhost/route/1", $data["route"]["url"]);
    }

    protected function createSimpleTimetable()
    {
        $timetable = new Timetable(
            new Station("111", "Departure station", 1),
            new Station("222", "Destination station", 1),
            "Transfer station"
        );
        $timetable->addTrip(new Trip(
            new Train("c1", new \DateTime("2014-07-13T12:00:00+02:00"), new \DateTime("2014-07-13T12:35:00+02:00"))
        ));

        return $timetable;
    }

    public function testUrlsWithCustomServerUrl()
    {
        $result = new TimetableResult($this->createSimpleTimetable(), "http://example.com");
        $data = $result->toArray();

        $this->assertEquals("http://example.com/timetable/1/222/111/2014-07-13", $data["return_url"]);
        $this->assertEquals("http://example.com/route/1", $data["route"]["url"]);
    }
}
