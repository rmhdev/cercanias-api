<?php

namespace CercaniasApi\Provider;

use Cercanias\Cercanias;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Cercanias\HttpAdapter\CurlHttpAdapter;
use Cercanias\Provider\HorariosRenfeCom\Provider;

class CercaniasServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Application $app)
    {
        $app["cercanias"] = $app->share(function () use ($app) {
            return new Cercanias($app["cercanias.provider"]);
        });

        $app["cercanias.adapter"] = $app->share(function () {
            return new CurlHttpAdapter();
        });

        $app["cercanias.provider"] = $app->share(function () use ($app) {
            return new Provider($app["cercanias.adapter"]);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function boot(Application $app)
    {

    }
}
