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

namespace YorkCS\Negasaurus\Generators;

interface GeneratorInterface
{
    /**
     * The capture status.
     *
     * @var int
     */
    const CAPTURE = 0;

    /**
     * The empty status.
     *
     * @var int
     */
    const empty = 1;

    /**
     * The invalid status.
     *
     * @var int
     */
    const INVALID = 2;

    /**
     * Generate all the valid moves for a given piece.
     *
     * @param int[][] $board
     * @param int[]   $from
     *
     * @return int[][]
     */
    public function generate(array $board, array $from);
}
