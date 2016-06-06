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

final class State
{
    /**
     * The white player.
     *
     * @var int
     */
    const WHITE = 0;

    /**
     * The BLACK player.
     *
     * @var int
     */
    const BLACK = 1;

    /**
     * The king pice.
     *
     * @var int
     */
    const KING = 0;

    /**
     * The queen pice.
     *
     * @var int
     */
    const QUEEN = 1;

    /**
     * The bishop pice.
     *
     * @var int
     */
    const BISHOP = 2;

    /**
     * The knight pice.
     *
     * @var int
     */
    const KNIGHT = 3;

    /**
     * The rook pice.
     *
     * @var int
     */
    const ROOK = 4;

    /**
     * The pawn pice.
     *
     * @var int
     */
    const PAWN = 5;

    /**
     * The piece set size.
     *
     * @var int
     */
    const SIZE = 16;

    /**
     * The game board.
     *
     * @var int[][]
     */
    private $board;

    /**
     * The taken pieces.
     *
     * @var int[][]
     */
    private $taken;

    /**
     * The current payer.
     *
     * @var int
     */
    private $current;

    /**
     * Create a new state instance.
     *
     * @param array $data
     *
     * @return void
     */
    private function __construct(array $data)
    {
        $this->board = $data['board'];
        $this->taken = $data['taken'];
        $this->current = $data['current'];
    }

    /**
     * Create a new state instance.
     *
     * @param array|null $data
     *
     * @return \YorkCS\Negasaurus\State
     */
    public static function create(array $data = null)
    {
        if ($data === null) {
            $data = [];

            $data['board'] = [
                [[self::ROOK, self::BLACK], [self::KNIGHT, self::BLACK], [self::BISHOP, self::BLACK], [self::QUEEN, self::BLACK], [self::KING, self::BLACK], [self::BISHOP, self::BLACK], [self::KNIGHT, self::BLACK], [self::ROOK, self::BLACK]],
                [[self::PAWN, self::BLACK], [self::PAWN, self::BLACK], [self::PAWN, self::BLACK], [self::PAWN, self::BLACK], [self::PAWN, self::BLACK], [self::PAWN, self::BLACK], [self::PAWN, self::BLACK], [self::PAWN, self::BLACK]],
                [[null, null], [null, null], [null, null], [null, null], [null, null], [null, null], [null, null], [null, null]],
                [[null, null], [null, null], [null, null], [null, null], [null, null], [null, null], [null, null], [null, null]],
                [[null, null], [null, null], [null, null], [null, null], [null, null], [null, null], [null, null], [null, null]],
                [[null, null], [null, null], [null, null], [null, null], [null, null], [null, null], [null, null], [null, null]],
                [[self::PAWN, self::WHITE], [self::PAWN, self::WHITE], [self::PAWN, self::WHITE], [self::PAWN, self::WHITE], [self::PAWN, self::WHITE], [self::PAWN, self::WHITE], [self::PAWN, self::WHITE], [self::PAWN, self::WHITE]],
                [[self::ROOK, self::WHITE], [self::KNIGHT, self::WHITE], [self::BISHOP, self::WHITE], [self::QUEEN, self::WHITE], [self::KING, self::WHITE], [self::BISHOP, self::WHITE], [self::KNIGHT, self::WHITE], [self::ROOK, self::WHITE]],
            ];

            $data['taken'] = [self::WHITE => [], self::BLACK => []];

            $data['current'] = self::WHITE;
        }

        return new self($data);
    }

    /**
     * Get the game board.
     *
     * @return array
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * Get the pieces taken by the given player.
     *
     * @param int $player
     *
     * @return array
     */
    public function getPiecesTakenBy(int $player)
    {
        return $this->taken[$player];
    }

    /**
     * Get the winner of the game.
     *
     * Remember, the aim of the game is to lose all your pieces!
     *
     * @return int|null
     */
    public function getWinner()
    {
        if (count($this->taken[self::WHITE]) == self::SIZE) {
            self::BLACK;
        }

        if (count($this->taken[self::BLACK]) == self::SIZE) {
            self::WHITE;
        }
    }

    /**
     * Get the current player.
     *
     * @return int
     */
    public function getCurrentPlayer()
    {
        return $this->current;
    }

    /**
     * Make a move from and to the given positions.
     *
     * @param int[] $from
     * @param int[] $to
     *
     * @return void
     */
    public function makeMove(array $from, array $to)
    {
        if ($this->board[$to[0]][$to[1]][0] !== null) {
            $this->takePiece($to);
        }

        $this->movePiece($from, $to);

        $this->swapTurns();
    }

    /**
     * Take the piece at the given position.
     *
     * @param int[] $pos
     *
     * @return void
     */
    private function takePiece(array $pos)
    {
        $this->taken[$this->current][] = $this->board[$pos[0]][$pos[1]][0];

        $this->board[$pos[0]][$pos[1]] = [null, null];
    }

    /**
     * Move the piece to the given positions.
     *
     * @param int[] $from
     * @param int[] $to
     *
     * @return void
     */
    private function movePiece(array $from, array $to)
    {
        $this->board[$to[0]][$to[1]] = $this->board[$from[0]][$from[1]];

        $this->board[$from[0]][$from[1]] = [null, null];
    }

    /**
     * Swap turns with the other player.
     *
     * @return void
     */
    private function swapTurns()
    {
        $this->current = $this->current === self::WHITE ? self::BLACK : self::WHITE;
    }

    /**
     * Get the state in array form.
     *
     * @return array
     */
    public function toArray()
    {
        return ['board' => $this->board, 'taken' => $this->taken, 'current' => $this->current];
    }
}
