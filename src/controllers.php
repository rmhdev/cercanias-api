<?php

/* @var Silex\Application */

$app->get('/', function () use ($app) {
    return $app->json(array(
        "routes_url"     => "http://localhost/route",
        "route_url"     => "http://localhost/route/{routeId}",
        "timetable_url" => "http://localhost/timetable",
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

$app->get('/timetable', function () use ($app) {
    return "";
})->bind("timetable");

$app->error(function (\Exception $e, $code) use ($app) {
    return $app->json(
        array("message" => $e->getMessage()),
        404
    );
});
