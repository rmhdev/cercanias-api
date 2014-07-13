<?php

/* @var Silex\Application $app */

$app->register(
    new Silex\Provider\UrlGeneratorServiceProvider()
);
$app->register(
    new \CercaniasApi\Provider\CercaniasServiceProvider()
);
