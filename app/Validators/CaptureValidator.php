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

use YorkCS\Negasaurus\Generators\GeneratorInterface;
use YorkCS\Negasaurus\Exceptions\InvalidMoveException;

class CaptureValidator implements ValidatorInterface
{
    /**
     * The move generator instance.
     *
     * @var \YorkCS\Negasaurus\Validators\GeneratorInterface
     */
    protected $generator;

    /**
     * Create a move validator instance.
     *
     * @param \YorkCS\Negasaurus\Generators\GeneratorInterface $generator
     *
     * @return void
     */
    public function __construct(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

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
        if (!$this->isCapture($board, $to) && $this->capturesAreAvailable($board, $player)) {
            throw new InvalidMoveException('You must take one of your opponent\'s pieces.');
        }
    }

    /**
     * Are we capturing a when we move?
     *
     * @param int[][] $board
     * @param int[]   $to
     *
     * @return bool
     */
    protected function isCapture(array $board, array $to)
    {
        return $board[$to[0]][$to[1]][1] !== null;
    }

    /**
     * Is it possible to capture a piece?
     *
     * @param int[][] $board
     * @param int     $player
     *
     * @return bool
     */
    protected function capturesAreAvailable(array $board, int $player)
    {
        foreach ($this->getPieces($board, $player) as $pos) {
            foreach ($this->generator->generate($board, $pos) as $move) {
                if ($board[$move[0]][$move[1]][0] !== null) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the candidate pieces to move.
     *
     * @param int[][] $board
     * @param int     $player
     *
     * @return bool
     */
    protected function getPieces(array $board, int $player)
    {
        $pieces = [];

        foreach ($board as $row) {
            foreach ($row as $col) {
                if ($board[$row][$col][1] === $player) {
                    $pieces[] = [$row, $col];
                }
            }
        }

        return $pieces;
    }
}
