<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Tests;

use AnzuSystems\AnzutapBundle\AnzutapApp;
use DateTimeImmutable;
use DateTimeZone;
use Exception;

final class AppTest extends AnzutapApp
{
    /**
     * @throws Exception
     */
    protected static function prepareAppDate(): DateTimeImmutable
    {
        return new DateTimeImmutable('2023-04-03 15:00:00', new DateTimeZone('Europe/Bratislava'));
    }
}
