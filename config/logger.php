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

return [

    /*
    |--------------------------------------------------------------------------
    | Loggers
    |--------------------------------------------------------------------------
    |
    | Here are each of the loggers to call under the hood while logging.
    |
    */

    'loggers' => [
        'AltThree\Bugsnag\Logger' => ['error', 'critical', 'alert', 'emergency'],
    ],

];
