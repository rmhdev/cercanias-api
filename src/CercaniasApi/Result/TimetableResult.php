<?php

namespace CercaniasApi\Result;

use Cercanias\Entity\Timetable;
use Cercanias\Entity\Station;
use Cercanias\Entity\Trip;
use Cercanias\Entity\Train;

class TimetableResult implements ResultInterface
{
    const DATE_FORMAT = "c";

    private $timetable;

    public function __construct(Timetable $timetable)
    {
        $this->timetable = $timetable;
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
            "trips"         => $this->toArrayTrips(),
            "date"          => $this->dateToString(),
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
            return array();
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

    protected function dateToString()
    {
        if (!$this->getTimetable()->getTrips()->count()) {
            return "";
        }

        foreach ($this->getTimetable()->getTrips() as $trip) {
            /* @var Trip $trip */
            return $trip->getDepartureTime()->format("Y-m-d");
        }
    }
}
