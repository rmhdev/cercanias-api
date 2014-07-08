<?php

/* @var Silex\Application */

$app->get('/', function () use ($app) {
    return $app->json(array(
        "route_url"     => "http://localhost/route",
        "timetable_url" => "http://localhost/timetable",
    ));
})->bind("homepage");

$app->get('/route', function () use ($app) {
    return "";
})->bind("route");

$app->get('/timetable', function () use ($app) {
    return "";
})->bind("timetable");
