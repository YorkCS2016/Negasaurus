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

use YorkCS\Negasaurus\State;

class PawnGenerator extends AbstractGenerator
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
        $player = $board[$from[0]][$from[1]][1];
        $direction = $player === State::WHITE ? 1 : -1;

        $moves = [];

        if ($this->check($board, $player, [0, $direction]) === static::FREE) {
            $moves[] = [0, $direction];
        }

        if ($this->check($board, $player, [-1, $direction]) === static::CAPTURE) {
            $moves[] = [-1, $direction];
        }

        if ($this->check($board, $player, [1, $direction]) === static::CAPTURE) {
            $moves[] = [1, $direction];
        }

        return $moves;
    }
}
