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
use YorkCS\Negasaurus\Generators\GeneratorInterface;

class MoveValidator implements ValidatorInterface
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
        $moves = $this->generator->generator($board, $from);

        if (!in_array($to, $moves, true)) {
            throw new InvalidMoveException('Your piece cannot move like that.');
        }
    }
}
