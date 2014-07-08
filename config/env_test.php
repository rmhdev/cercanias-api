<?php

require __DIR__ . "/../vendor/autoload.php";

/* @var Silex\Application $app */
$app = require __DIR__ . "/../src/app.php";
require __DIR__ . "/config.php";

return $app;
