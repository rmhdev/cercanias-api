<?php

/* @var Silex\Application */

$app->get('/', function () use ($app) {
    return $app->json(array());
});
