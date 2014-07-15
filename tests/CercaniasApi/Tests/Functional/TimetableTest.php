<?php

namespace CercaniasApi\Tests;

use Cercanias\Entity\Station;
use Cercanias\Entity\Timetable;
use Cercanias\Entity\Train;
use Cercanias\Entity\Trip;
use Symfony\Component\HttpKernel\Client;

class TimetableTest extends AbstractTest
{
    public function testIncorrectRoute()
    {
        $client = $this->createClient();
        $client->request("GET", "/timetable/lorem/111/222");
        $response = $client->getResponse();

        $this->assertTrue($response->isClientError());
        $this->assertEquals("application/json", $response->headers->get("Content-Type"));
        $expectedError = array(
            "message" => "Invalid routeId",
        );

        $json = json_decode($response->getContent(), true);
        $this->assertEquals($expectedError, $json);
    }

    public function testCorrectRouteWithoutDate()
    {
        $client = $this->createClientWithMockCercaniasReturnTimetable(
            $this->createTimetable()
        );
        $client->request("GET", "/timetable/1/111/222");
        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());

        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertEquals(3       , sizeof($jsonResponse["departure"]));
        $this->assertEquals("111"   , $jsonResponse["departure"]["id"]);
        $this->assertEquals(1       , $jsonResponse["departure"]["route_id"]);
        $this->assertEquals(3       , sizeof($jsonResponse["destination"]));
        $this->assertEquals("222"   , $jsonResponse["destination"]["id"]);
        $this->assertEquals(2       , sizeof($jsonResponse["trips"]));
        $this->assertEmpty($jsonResponse["transfer"]);
        $this->assertEquals("2014-07-14", $jsonResponse["date"]);
    }

    protected function createClientWithMockCercaniasReturnTimetable(Timetable $timetable)
    {
        $mockCercanias = $this->getMock('\CercaniasApi\Tests\EmptyCercanias');
        $mockCercanias
            ->expects($this->once())
            ->method("getTimetable")
            ->will($this->returnValue($timetable))
        ;
        $app = $this->createApplication();
        $app["cercanias"] = $mockCercanias;

        return new Client($app);
    }

    protected function createTimetable()
    {
        $timetable = new Timetable(
            new Station("111", "Departure Station", 1),
            new Station("222", "Destination Station", 1)
        );
        $timetable->addTrip(
            new Trip(
                new Train(
                    "c1",
                    new \DateTime("2014-07-14T12:00:00+02:00"),
                    new \DateTime("2014-07-14T12:55:00+02:00")
                )
            )
        );
        $timetable->addTrip(
            new Trip(
                new Train(
                    "c1",
                    new \DateTime("2014-07-14T12:35:00+02:00"),
                    new \DateTime("2014-07-14T13:30:00+02:00")
                )
            )
        );

        return $timetable;
    }

    public function testCorrectRouteWithDate()
    {
        $client = $this->createClientWithMockCercaniasReturnTimetable(
            $this->createTimetable()
        );
        $client->request("GET", "/timetable/1/111/222/2014-07-14");
        $response = $client->getResponse();
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("2014-07-14", $jsonResponse["date"]);
    }
}
