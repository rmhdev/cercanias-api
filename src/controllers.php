<?php

/* @var Silex\Application */

use Symfony\Component\HttpFoundation\Request;

$app->get('/', function (Request $request) use ($app) {
    $baseUrl = $request->getSchemeAndHttpHost();

    return $app->json(array(
        "routes_url"        => "{$baseUrl}/route",
        "route_url"         => "{$baseUrl}/route/{routeId}",
        "timetable_url"     => "{$baseUrl}/timetable",
    ));
})->bind("homepage");

$app->get('/route', function () use ($app) {
    $result = new \CercaniasApi\Result\RoutesResult();

    return $app->json($result->toArray());
})->bind("route_list");

$app->get('/route/{routeId}', function ($routeId) use ($app) {
    $result = new \CercaniasApi\Result\RouteResult(
        $app["cercanias"]->getRoute((int) $routeId)
    );

    return $app->json($result->toArray());
})->value("routeId", false)->bind("route");

$app->get(
    '/timetable/{routeId}/{departureId}/{destinationId}',
    function ($routeId, $departureId, $destinationId) use ($app) {
        $query = new \Cercanias\Provider\TimetableQuery();
        $query
            ->setRoute((int) $routeId)
            ->setDeparture($departureId)
            ->setDestination($destinationId)
        ;
        $result = new \CercaniasApi\Result\TimetableResult(
            $app["cercanias"]->getTimetable($query)
        );

        return $app->json($result->toArray());
})->bind("timetable");

$app->error(function (\Exception $e, $code) use ($app) {
    return $app->json(
        array("message" => $e->getMessage()),
        404
    );
});
