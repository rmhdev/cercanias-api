<?php

namespace CercaniasApi\Result;

use Cercanias\Entity\Timetable;

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
            "departure" => array(
                "id"        => $this->getTimetable()->getDeparture()->getId(),
                "name"      => $this->getTimetable()->getDeparture()->getName(),
                "route_id"  => $this->getTimetable()->getDeparture()->getRouteId(),
            )
        );
    }
}
