<?php

require __DIR__ . "/../vendor/autoload.php";

/* @var Silex\Application $app */
$app = require __DIR__ . "/../src/app.php";
$app["log.level"] = \Monolog\Logger::ERROR;
require __DIR__ . "/config.php";

return $app;
