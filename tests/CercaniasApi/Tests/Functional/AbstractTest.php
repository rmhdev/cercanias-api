<?php

namespace CercaniasApi\Tests;

use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernel;

abstract class AbstractTest extends WebTestCase
{
    /**
     * Creates the application.
     *
     * @return HttpKernel
     */
    public function createApplication()
    {
        return require __DIR__ . "/../../../../config/env_test.php";
    }
}
