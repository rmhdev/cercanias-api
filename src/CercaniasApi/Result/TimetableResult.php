<?php

namespace CercaniasApi\Result;

use Cercanias\Entity\Timetable;
use Cercanias\Entity\Station;

class TimetableResult
{
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
}
