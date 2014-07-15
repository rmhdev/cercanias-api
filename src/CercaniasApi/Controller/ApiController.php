<?php
/**
 * This file is part of the CercaniasApi\Controller package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace CercaniasApi\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use CercaniasApi\Result\RoutesResult;
use CercaniasApi\Result\RouteResult;
use Cercanias\Provider\TimetableQuery;
use CercaniasApi\Result\TimetableResult;

class ApiController
{
    public function indexAction(Request $request, Application $app)
    {
        $baseUrl = $request->getSchemeAndHttpHost();
        $response = $app->json(
            array(
                "routes_url"        => "{$baseUrl}/route",
                "route_url"         => "{$baseUrl}/route/{routeId}",
                "timetable_url"     => "{$baseUrl}/timetable/{routeId}/{departureId}/{destinationId}",
            )
        );
        //prepare cache.

        return $response;
    }

    public function routesAction(Request $request, Application $app)
    {
        $result = new RoutesResult($request->getSchemeAndHttpHost());

        return $app->json($result->toArray());
    }

    public function routeAction(Request $request, Application $app)
    {
        $result = new RouteResult(
            $app["cercanias"]->getRoute((int) $request->get("routeId")),
            $request->getSchemeAndHttpHost()
        );

        return $app->json($result->toArray());
    }

    public function timetableAction(Request $request, Application $app)
    {
        $query = new TimetableQuery();
        $query
            ->setRoute(         (int) $request->get("routeId"))
            ->setDeparture(     $request->get("departureId"))
            ->setDestination(   $request->get("destinationId"))
            ->setDate(          new \DateTime($request->get("date")))
        ;
        $result = new TimetableResult(
            $app["cercanias"]->getTimetable($query),
            $request->getSchemeAndHttpHost()
        );

        return $app->json($result->toArray());
    }
}
