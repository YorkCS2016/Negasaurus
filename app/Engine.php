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

use Illuminate\Contracts\Cache\Repository;
use Pusher;
use YorkCS\Negasaurus\Exceptions\GameNotFoundException;
use YorkCS\Negasaurus\Exceptions\InvalidMoveException;
use YorkCS\Negasaurus\Exceptions\OpponentMovingException;

final class Engine
{
    /**
     * The pending entry.
     *
     * @var string[]
     */
    const PENDING = 'pending';

    /**
     * The timeout.
     *
     * @var int
     */
    const TIMEOUT = 60;

    /**
     * The cache repository instance.
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    private $cache;

    /**
     * The pusher instance.
     *
     * @var \Pusher
     */
    protected $pusher;

    /**
     * The move validator instance.
     *
     * @var \YorkCS\Negasaurus\Validator
     */
    private $validator;

    /**
     * Create a new engine instance.
     *
     * @param \Illuminate\Contracts\Cache\Repository $cache
     * @param \Pusher                                $pusher
     * @param \YorkCS\Negasaurus\Validator           $validator
     *
     * @return void
     */
    public function __construct(Repository $cache, Pusher $pusher, Validator $validator)
    {
        $this->cache = $cache;
        $this->pusher = $pusher;
        $this->validator = $validator;
    }

    /**
     * Start a new game, or join an existing game.
     *
     * @param bool $new
     *
     * @return array
     */
    public function start(bool $new = false)
    {
        if ($new || !($game = $this->cache->pull(self::PENDING))) {
            $this->cache->put(self::PENDING, $game = str_random(8), self::TIMEOUT);
            $player = State::WHITE;
        } else {
            $this->cache->put($game, $data = State::create()->toArray(), self::TIMEOUT);
            $player = State::BLACK;

            $this->pusher->trigger($data, 'GameUpdatedEvent', $data);
        }

        return ['game' => $game, 'player' => $player];
    }

    /**
     * Attempt to make the given move.
     *
     * @param string $game
     * @param int    $player
     * @param int[]  $from
     * @param int[]  $to
     *
     * @return array
     */
    public function move(string $game, int $player, array $from, array $to)
    {
        if (!($game = $this->cache->get($game))) {
            throw new GameNotFoundException();
        }

        $state = State::create($game);

        if ($state->getCurrentPlayer() !== $player) {
            throw new OpponentMovingException();
        }

        if (!$this->validator->validate($state->getBoard(), $state->getCurrentPlayer(), $from, $to)) {
            throw new InvalidMoveException();
        }

        $state->makeMove($from, $to);

        $this->cache->put($game, $data = $state->toArray(), self::TIMEOUT);

        $this->pusher->trigger($game, 'GameUpdatedEvent', $data);

        if (($winner = $state->getWinner()) !== null) {
            $this->cache->forget($game);

            $this->pusher->trigger($game, 'GameEndedEvent', ['winner' => $winner]);
        }
    }

    /**
     * Attempt to forfit the game.
     *
     * @param string $game
     * @param int    $player
     *
     * @return array
     */
    public function forfit(string $game, int $player)
    {
        if (!($game = $this->cache->get($game))) {
            throw new GameNotFoundException();
        }

        $this->cache->forget($game);

        $this->pusher->trigger($game, 'GameEndedEvent', ['winner' => $player === State::WHITE ? State::BLACK : State::WHITE]);
    }
}
