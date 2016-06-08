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

class GeneratorFactory implements GeneratorInterface
{
    /**
     * The generators to run.
     *
     * @var YorkCS\Negasaurus\Generators\GeneratorInterface[]
     */
    protected $generators;

    /**
     * Create a new generator factory instance.
     *
     * @param YorkCS\Negasaurus\Generators\GeneratorInterface[] $generators
     *
     * @return void
     */
    public function __construct(array $generators)
    {
        $this->generators = $generators;
    }

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
        $type = $board[$from[0]][$from[1]][0];

        if ($type === null) {
            return [];
        }

        return $this->generators[$type]->generate($board, $from);
    }
}
