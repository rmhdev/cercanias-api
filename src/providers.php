<?php

/* @var Silex\Application $app */

$app->register(
    new Silex\Provider\UrlGeneratorServiceProvider()
);
$app->register(
    new \CercaniasApi\Provider\CercaniasServiceProvider()
);

$app->register(
    new Silex\Provider\HttpCacheServiceProvider(),
    array(
        'http_cache.cache_dir'  => __DIR__ . '/../var/cache/',
        'http_cache.esi'        => null
    )
);
