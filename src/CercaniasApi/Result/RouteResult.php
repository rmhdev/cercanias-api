<?php

namespace CercaniasApi\Result;

use Cercanias\Entity\Route;
use Cercanias\Entity\Station;

class RouteResult
{
    private $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function toArray()
    {
        return array(
            "id"        => $this->getRoute()->getId(),
            "name"      => $this->getRoute()->getName(),
            "url"       => $this->getRouteUrl(),
            "stations"  => $this->getRouteStations(),
        );
    }

    /**
     * @return Route
     */
    protected function getRoute()
    {
        return $this->route;
    }

    /**
     * @return string
     */
    protected function getRouteUrl()
    {
        return sprintf("http://localhost/route/%s", $this->getRoute()->getId());
    }

    /**
     * @return array
     */
    protected function getRouteStations()
    {
        $stations = array();
        foreach ($this->getRoute()->getStations() as $station) {
            /* @var Station $station */
            $stations[] = array(
                "id"        => $station->getId(),
                "name"      => $station->getName(),
                "route_id"  => $station->getRouteId(),
            );
        }

        return $stations;
    }
}
