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

interface ValidatorInterface
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
    public function validate(array $board, int $player, array $from, array $to);
}
