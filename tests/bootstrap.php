<?php

declare(strict_types=1);

use AnzuSystems\AnzutapBundle\Tests\AnzuTestKernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');

$kernel = new AnzuTestKernel(
    appSystem: 'anzutapbundle',
    appVersion: 'dev',
    appTimeZone: 'Europe/Bratislava',
    environment: 'test',
    debug: false,
);
$kernel->boot();

$app = new Application($kernel);
$app->setAutoExit(false);

//return;

$output = new ConsoleOutput();

# Clear cache
$input = new ArrayInput([
    'command' => 'cache:clear',
    '--no-warmup' => true,
    '--env' => 'test',
]);
$input->setInteractive(false);
$app->run($input, $output);
