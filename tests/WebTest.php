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

namespace YorkCS\Tests\Negasaurus;

class WebTest extends AbstractTestCase
{
    /**
     * Test the homepage works.
     *
     * @return void
     */
    public function testHome()
    {
        $this->get('/');

        $this->assertResponseOk();

        $this->seeJsonEquals(['meta' => ['message' => 'You have arrived!']]);
    }
}
