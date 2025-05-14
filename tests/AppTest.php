<?php

declare(strict_types=1);

namespace AnzuSystems\AnzuTapBundle\Tests;

use AnzuSystems\AnzuTapBundle\AnzuTapApp;
use DateTimeImmutable;
use DateTimeZone;
use Exception;

final class AppTest extends AnzuTapApp
{
    /**
     * @throws Exception
     */
    protected static function prepareAppDate(): DateTimeImmutable
    {
        return new DateTimeImmutable('2023-04-03 15:00:00', new DateTimeZone('Europe/Bratislava'));
    }
}
