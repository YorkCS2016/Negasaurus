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

class ValidatorFactory implements ValidatorInterface
{
    /**
     * The validators to run.
     *
     * @var YorkCS\Negasaurus\Validators\ValidatorInterface[]
     */
    protected $validators;

    /**
     * Create a new validator factory instance.
     *
     * @param YorkCS\Negasaurus\Validators\ValidatorInterface[] $validators
     *
     * @return void
     */
    public function __construct(array $validators)
    {
        $this->validators = $validators;
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
        foreach ($this->validators as $validator) {
            $validator->validate($board, $player, $from, $to);
        }
    }
}
