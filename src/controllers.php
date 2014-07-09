<?php

/* @var Silex\Application */

$app->get('/', function () use ($app) {
    return $app->json(array(
        "route_url"     => "http://localhost/route",
        "timetable_url" => "http://localhost/timetable",
    ));
})->bind("homepage");

$app->get('/route/{routeId}', function ($routeId) use ($app) {
    return $app->json(array());
})->bind("route");

$app->get('/timetable', function () use ($app) {
    return "";
})->bind("timetable");

$app->error(function (\Exception $e, $code) use ($app) {
    return $app->json(array(
        "message" => "Invalid routeId"
    ));
});
