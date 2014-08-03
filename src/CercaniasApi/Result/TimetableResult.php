<?php

namespace CercaniasApi\Result;

use Cercanias\Entity\Timetable;
use Cercanias\Entity\Station;
use Cercanias\Entity\Trip;
use Cercanias\Entity\Train;
use Cercanias\Provider\AbstractProvider;

class TimetableResult implements ResultInterface
{
    const DATE_FORMAT = "c";

    private $timetable;
    private $serverUrl;

    public function __construct(Timetable $timetable, $serverUrl = "http://localhost")
    {
        $this->timetable = $timetable;
        $this->serverUrl = $serverUrl;
    }

    /**
     * @return Timetable
     */
    protected function getTimetable()
    {
        return $this->timetable;
    }

    public function toArray()
    {
        return array(
            "departure"     => $this->toArrayDeparture(),
            "destination"   => $this->toArrayDestination(),
            "transfer"      => $this->toArrayTransfer(),
            "date"          => $this->dateToString(self::DATE_FORMAT),
            "route"         => $this->toArrayRoute(),
            "return_url"    => $this->createReturnUrl(),
            "trips"         => $this->toArrayTrips(),
        );
    }

    protected function toArrayDeparture()
    {
        return $this->toArrayStation($this->getTimetable()->getDeparture());
    }

    protected function toArrayDestination()
    {
        return $this->toArrayStation($this->getTimetable()->getDestination());
    }

    protected function toArrayStation(Station $station)
    {
        return array(
            "id"        => $station->getId(),
            "name"      => $station->getName(),
            "route_id"  => $station->getRouteId(),
        );
    }

    protected function toArrayTransfer()
    {
        if (!$this->getTimetable()->hasTransfer()) {
            return false;
        }

        return array(
            "id"        => "",
            "name"      => $this->getTimetable()->getTransferName(),
            "route_id"  => $this->getTimetable()->getDeparture()->getRouteId(),
        );
    }

    protected function toArrayTrips()
    {
        $result = array();
        foreach ($this->getTimetable()->getTrips() as $trip) {
            /* @var Trip $trip */
            $result[] = $this->toArrayTrip($trip);
        }

        return $result;
    }

    protected function toArrayTrip(Trip $trip)
    {
        $train = $trip->getDepartureTrain();

        return array(
            "line"      => $train->getLine(),
            "departure" => $train->getDepartureTime()->format(self::DATE_FORMAT),
            "arrival"   => $train->getArrivalTime()->format(self::DATE_FORMAT),
            "transfers" => $this->toArrayTripTransfers($trip)
        );
    }

    protected function toArrayTripTransfers(Trip $trip)
    {
        $result = array();
        foreach ($trip->getTransferTrains() as $train) {
            /* @var Train $train */
            $result[] = array(
                "line"      => $train->getLine(),
                "departure" => $train->getDepartureTime()->format(self::DATE_FORMAT),
                "arrival"   => $train->getArrivalTime()->format(self::DATE_FORMAT),
            );
        }

        return $result;
    }

    protected function dateToString($format = "Y-m-d")
    {
        $date = $this->getTimetable()->getDate();
        if (!$date) {
            return "";
        }

        return $date->format($format);
    }

    protected function createReturnUrl()
    {
        return sprintf(
            "%s/timetable/%s/%s/%s/%s",
            $this->getServerUrl(),
            $this->getTimetable()->getDeparture()->getRouteId(),
            $this->getTimetable()->getDestination()->getId(),
            $this->getTimetable()->getDeparture()->getId(),
            $this->dateToString()
        );
    }

    protected function getServerUrl()
    {
        return $this->serverUrl;
    }

    protected function toArrayRoute()
    {
        $routeId = $this->getTimetable()->getDeparture()->getRouteId();
        $routeName = "";
        $routes = AbstractProvider::getRoutes();
        if (array_key_exists($routeId, $routes)) {
            $routeName = $routes[$routeId];
        }

        return array(
            "id"    => $routeId,
            "name"  => $routeName,
            "url"   => $this->createRouteUrl($routeId)
        );
    }

    protected function createRouteUrl($routeId)
    {
        return sprintf("%s/route/%s", $this->getServerUrl(), $routeId);
    }
}
