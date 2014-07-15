<?php

/* @var Silex\Application */

$app->get(
    '/',
    'CercaniasApi\Controller\ApiController::indexAction'
)->bind("homepage");

$app->get(
    '/route',
    'CercaniasApi\Controller\ApiController::routesAction'
)->bind("route_list");

$app->get(
    '/route/{routeId}',
    'CercaniasApi\Controller\ApiController::routeAction'
)->value("routeId", false)->bind("route");

$app->get(
    '/timetable/{routeId}/{departureId}/{destinationId}/{date}',
    'CercaniasApi\Controller\ApiController::timetableAction'
)->value("date", "today")->bind("timetable");

$app->error(function (\Exception $e, $code) use ($app) {
    return $app->json(
        array("message" => $e->getMessage()),
        404
    );
});
