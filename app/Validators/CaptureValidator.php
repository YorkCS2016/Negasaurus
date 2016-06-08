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

namespace YorkCS\Negasaurus\Validators;

use YorkCS\Negasaurus\Exceptions\InvalidMoveException;

class CaptureValidator implements ValidatorInterface
{
    /**
     * Validate the given move by the given player.
     *
     * @param int[][] $board
     * @param int     $player
     * @param int[]   $from
     * @param int[]   $to
     *
     * @throws \YorkCS\Negasaurus\Exceptions\InvalidMoveException
     *
     * @return void
     */
    public function validate(array $board, int $player, array $from, array $to)
    {
        if (!$this->isCapture($board, $player, $from, $to) && $this->capturesAreAvailable($board, $player, $from, $to)) {
            throw new InvalidMoveException('You must take one of your opponent\'s pieces.');
        }
    }

    /**
     * Are we capturing a when we move?
     *
     * @param int[][] $board
     * @param int     $player
     * @param int[]   $from
     * @param int[]   $to
     *
     * @return bool
     */
    public function isCapture(array $board, int $player, array $from, array $to)
    {
        return $board[$to[0]][$to[1]][1] !== null;
    }

    /**
     * Is it possible to capture a piece?
     *
     * @param int[][] $board
     * @param int     $player
     * @param int[]   $from
     * @param int[]   $to
     *
     * @return bool
     */
    public function capturesAreAvailable(array $board, int $player, array $from, array $to)
    {
        // TODO

        return false;
    }
}
