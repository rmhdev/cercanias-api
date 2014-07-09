<?php

/* @var Silex\Application */

use Cercanias\Provider\AbstractProvider;

$app->get('/', function () use ($app) {
    return $app->json(array(
        "route_url"     => "http://localhost/route",
        "timetable_url" => "http://localhost/timetable",
    ));
})->bind("homepage");

$app->get('/route', function () use ($app) {
    $routes = array(
        array("id" => AbstractProvider::ROUTE_ASTURIAS          , "name" => "Asturias"),
        array("id" => AbstractProvider::ROUTE_BARCELONA         , "name" => "Barcelona"),
        array("id" => AbstractProvider::ROUTE_BILBAO            , "name" => "Bilbao"),
        array("id" => AbstractProvider::ROUTE_CADIZ             , "name" => "Cádiz"),
        array("id" => AbstractProvider::ROUTE_MADRID            , "name" => "Madrid"),
        array("id" => AbstractProvider::ROUTE_MALAGA            , "name" => "Málaga"),
        array("id" => AbstractProvider::ROUTE_MURCIA_ALICANTE   , "name" => "Murcia-Alicante"),
        array("id" => AbstractProvider::ROUTE_SAN_SEBASTIAN     , "name" => "San Sebastián"),
        array("id" => AbstractProvider::ROUTE_SANTANDER         , "name" => "Santander"),
        array("id" => AbstractProvider::ROUTE_SEVILLA           , "name" => "Sevilla"),
        array("id" => AbstractProvider::ROUTE_VALENCIA          , "name" => "Valencia"),
        array("id" => AbstractProvider::ROUTE_ZARAGOZA          , "name" => "Zaragoza"),

    );
    return $app->json(array(
        "routes" => $routes
    ));
})->bind("route_list");

$app->get('/route/{routeId}', function ($routeId) use ($app) {
    if (!$routeId) {
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
