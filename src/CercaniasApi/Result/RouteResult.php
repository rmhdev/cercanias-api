<?php

namespace CercaniasApi\Result;

use Cercanias\Entity\Route;

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
            "stations"  => array(),
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
}
