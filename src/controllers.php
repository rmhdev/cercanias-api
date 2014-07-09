<?php

/* @var Silex\Application */

$app->get('/', function () use ($app) {
    return $app->json(array(
        "route_url"     => "http://localhost/route",
        "timetable_url" => "http://localhost/timetable",
    ));
})->bind("homepage");

$app->get('/route', function () use ($app) {
    $result = new \CercaniasApi\Result\RoutesResult();

    return $app->json($result->toArray());
})->bind("route_list");

$app->get('/route/{routeId}', function ($routeId) use ($app) {
    $query = new \Cercanias\Provider\RouteQuery();
    $query->setRoute((int) $routeId);
    if (!$query->isValid()) {
        throw new \Exception("Invalid routeId");
    }
    return $app->json(array());
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
