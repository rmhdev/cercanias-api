<?php

namespace CercaniasApi\Result;

use Cercanias\Provider\AbstractProvider;

class RoutesResult implements ResultInterface
{
    private $serverUrl;

    public function __construct($serverUrl = "http://localhost")
    {
        $this->serverUrl = $serverUrl;
    }

    public function toArray()
    {
        return array(
            "routes" => $this->prepareRoutes()
        );
    }

    protected function prepareRoutes()
    {
        $routes = array();
        foreach (AbstractProvider::getRoutes() as $id => $name) {
            $routes[] = array(
                "id"    => $id,
                "name"  => $name,
                "url"   => $this->getRouteUrl($id)
            );
        }

        return $routes;
    }

    protected function getRouteUrl($routeId)
    {
        return sprintf("%s/route/%s", $this->getServerUrl(), $routeId);
    }

    protected function getServerUrl()
    {
        return $this->serverUrl;
    }
}
