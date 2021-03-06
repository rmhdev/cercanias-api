<?php

namespace CercaniasApi\Tests;

use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernel;
use Cercanias\CercaniasInterface;
use Cercanias\Provider\TimetableQueryInterface;

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

class EmptyCercanias implements CercaniasInterface
{
    /**
     * {@inheritDoc}
     */
    public function getRoute($routeId)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function getTimetable(TimetableQueryInterface $query)
    {

    }
}
