<?php

/* @var Silex\Application $app */

use Monolog\Logger;
use Silex\Provider\MonologServiceProvider;

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

if (isset($app["log.level"])) {
    $logLevelName = Logger::getLevelName($app["log.level"]);
    $logFile = sprintf(__DIR__ . '/../var/log/%s-%s.log',
        strtolower($logLevelName),
        date("Y-m-d", strtotime("today"))
    );
    $app->register(
        new MonologServiceProvider(),
        array(
            'monolog.logfile'   => $logFile,
            'monolog.level'     => $app["log.level"],
            'monolog.name'      => "application"
        )
    );
}
