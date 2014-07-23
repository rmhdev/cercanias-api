<?php

/* @var Silex\Application */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

$app->after(function (Request $request, Response $response) {
    $response->headers->set("Access-Control-Allow-Origin", "*");
    $response->headers->set("Access-Control-Allow-Methods", "GET");
});

$app->error(function (\Exception $e, $code) use ($app) {
    return $app->json(
        array("message" => $e->getMessage()),
        404
    );
});
