<?php

namespace CercaniasApi\Tests;

use CercaniasApi\Provider\CercaniasServiceProvider;
use Silex\Application;

class CercaniasServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterProvider()
    {
        $provider = new CercaniasServiceProvider();
        $app = new Application();
        $app->register($provider);

        $this->assertInstanceOf('\Cercanias\Cercanias', $app["cercanias"]);
        $this->assertInstanceOf('\Cercanias\HttpAdapter\HttpAdapterInterface', $app["cercanias.adapter"]);
        $this->assertInstanceOf('\Cercanias\Provider\ProviderInterface', $app["cercanias.provider"]);
    }
}
