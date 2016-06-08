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

class KnightGenerator implements GeneratorInterface
{
    /**
     * Generate all the valid moves for a given piece.
     *
     * @param int[][] $board
     * @param int[]   $from
     *
     * @return int[][]
     */
    public function generate(array $board, array $from)
    {
        return [];
    }
}
