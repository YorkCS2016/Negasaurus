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

namespace YorkCS\Negasaurus;

final class Validator
{
    /**
     * Validate the given move by the given player.
     *
     * @param int[][] $board
     * @param int     $player
     * @param int[]   $from
     * @param int[]   $to
     *
     * @return bool
     */
    public function validate(array $board, int $player, array $from, array $to)
    {
        if (!$this->checkFromPiece($board, $player, $from, $to)) {
            return false;
        }

        if (!$this->checkToPiece($board, $player, $from, $to)) {
            return false;
        }

        if (!$this->canMoveThere($board, $player, $from, $to)) {
            return false;
        }

        return $this->isCapture($board, $player, $from, $to) || $this->noCapturesAreAvailable($board, $player, $from, $to);
    }

    /**
     * Is the from piece owned by the player?
     *
     * @param int[][] $board
     * @param int     $player
     * @param int[]   $from
     * @param int[]   $to
     *
     * @return bool
     */
    public function checkFromPiece(array $board, int $player, array $from, array $to)
    {
        return $board[$from[0]][$from[1]][1] === $player;
    }

    /**
     * Is the to piece clear, or owned by the opponent?
     *
     * @param int[][] $board
     * @param int     $player
     * @param int[]   $from
     * @param int[]   $to
     *
     * @return bool
     */
    public function checkToPiece(array $board, int $player, array $from, array $to)
    {
        return $board[$to[0]][$to[1]][1] !== $player;
    }

    /**
     * Can the given piece perform a move like this?
     *
     * @param int[][] $board
     * @param int     $player
     * @param int[]   $from
     * @param int[]   $to
     *
     * @return bool
     */
    public function canMoveThere(array $board, int $player, array $from, array $to)
    {
        // TOTO

        return true;
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
     * Is it not possible to capture a piece?
     *
     * @param int[][] $board
     * @param int     $player
     * @param int[]   $from
     * @param int[]   $to
     *
     * @return bool
     */
    public function noCapturesAreAvailable(array $board, int $player, array $from, array $to)
    {
        // TODO

        return true;
    }
}
