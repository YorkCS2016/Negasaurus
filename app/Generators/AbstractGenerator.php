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

abstract class AbstractGenerator implements GeneratorInterface
{
    /**
     * Walk in the given direction as far as we can get within the limit.
     *
     * @param int[][]  $board
     * @param int[]    $from
     * @param int[][]  $directions
     * @param int|null $limit
     *
     * @return int[][]
     */
    protected function walkThrough(array $board, array $from, array $directions, int $limit = null)
    {
        $moves = [];

        foreach ($directions as $direction) {
            $moves = array_merge($moves, $this->walk($board, $from, $direction));
        }

        return $moves;
    }

    /**
     * Walk in the given direction as far as we can get within the limit.
     *
     * @param int[][]  $board
     * @param int[]    $from
     * @param int[]    $direction
     * @param int|null $limit
     *
     * @return int[][]
     */
    protected function walk(array $board, array $from, array $direction, int $limit = null)
    {
        $player = $board[$from[0]][$from[1]][1];

        $moves = [];

        while ($limit === null || $limit--) {
            $from[0] += $direction[0];
            $from[1] += $direction[1];

            switch ($this->check($board, $player, $move)) {
                case INVALID:
                    break 2;
                case CAPTURE:
                    $moves[] = $from;
                    break 2;
                default:
                    $moves[] = $from;
            }
        }

        return $moves;
    }

    /**
     * Check the state of a given position.
     *
     * @param int[][] $board
     * @param int     $player
     * @param int[]   $position
     *
     * @return int[][]
     */
    protected function check(array $board, int $player, array $position)
    {
        if (!isset($board[$position[0]][$position[1]]) || $board[$position[0]][$position[1]][1] === $player) {
            return static::INVALID;
        }

        if ($board[$position[0]][$position[1]][1] !== null) {
            return static::CAPTURE;
        }

        return static::FREE;
    }
}
