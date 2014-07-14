<?php

/* @var Silex\Application */

use Symfony\Component\HttpFoundation\Request;

$app->get('/', function (Request $request) use ($app) {
    $baseUrl = $request->getSchemeAndHttpHost();

    return $app->json(array(
        "routes_url"        => "{$baseUrl}/route",
        "route_url"         => "{$baseUrl}/route/{routeId}",
        "timetable_url"     => "{$baseUrl}/timetable/{routeId}/{departureId}/{destinationId}",
    ));
})->bind("homepage");

$app->get('/route', function (Request $request) use ($app) {
    $result = new \CercaniasApi\Result\RoutesResult($request->getSchemeAndHttpHost());

    return $app->json($result->toArray());
})->bind("route_list");

$app->get('/route/{routeId}', function (Request $request) use ($app) {
    $result = new \CercaniasApi\Result\RouteResult(
        $app["cercanias"]->getRoute((int) $request->get("routeId")),
        $request->getSchemeAndHttpHost()
    );

    return $app->json($result->toArray());
})->value("routeId", false)->bind("route");

$app->get(
    '/timetable/{routeId}/{departureId}/{destinationId}/{date}',
    function (Request $request) use ($app) {
        $query = new \Cercanias\Provider\TimetableQuery();
        $query
            ->setRoute(         (int) $request->get("routeId"))
            ->setDeparture(     $request->get("departureId"))
            ->setDestination(   $request->get("destinationId"))
            ->setDate(          new \DateTime($request->get("date")))
        ;
        $result = new \CercaniasApi\Result\TimetableResult(
            $app["cercanias"]->getTimetable($query),
            $request->getSchemeAndHttpHost()
        );

        return $app->json($result->toArray());
})->value("date", "today")->bind("timetable");

$app->error(function (\Exception $e, $code) use ($app) {
    return $app->json(
        array("message" => $e->getMessage()),
        404
    );
});
