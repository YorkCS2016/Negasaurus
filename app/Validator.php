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

use YorkCS\Negasaurus\Exceptions\InvalidMoveException;

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
     * @throws \YorkCS\Negasaurus\Exceptions\InvalidMoveException
     *
     * @return void
     */
    public function validate(array $board, int $player, array $from, array $to)
    {
        if (!$this->checkFromPiece($board, $player, $from, $to)) {
            throw new InvalidMoveException('You must choose a piece that belongs to you.');
        }

        if (!$this->checkToPiece($board, $player, $from, $to)) {
            throw new InvalidMoveException('You cannot take one of your own pieces.');
        }

        if (!$this->canMoveThere($board, $player, $from, $to)) {
            throw new InvalidMoveException('Your piece cannot move like that.');
        }

        if (!$this->isCapture($board, $player, $from, $to) && $this->capturesAreAvailable($board, $player, $from, $to)) {
            throw new InvalidMoveException('You must take one of your opponent\'s pieces.');
        }
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
