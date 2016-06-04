<?php

declare(strict_types=1);

/*
 * This file is part of York CS Negasaurus.
 *
 * (c) Graham Campbell
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Laravel\Lumen\Application(realpath(__DIR__.'/../'));

$app->configure('database');

$app->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, GrahamCampbell\Exceptions\LumenExceptionHandler::class);
$app->singleton(Illuminate\Contracts\Console\Kernel::class, Laravel\Lumen\Console\Kernel::class);

$app->register(AltThree\Bugsnag\BugsnagServiceProvider::class);
$app->register(AltThree\Logger\LoggerServiceProvider::class);
$app->register(GrahamCampbell\Exceptions\ExceptionsServiceProvider::class);
$app->register(Illuminate\Redis\RedisServiceProvider::class);
$app->register(Vinkla\Pusher\PusherServiceProvider::class);
$app->register(YorkCS\Negasaurus\AppServiceProvider::class);

return $app;
