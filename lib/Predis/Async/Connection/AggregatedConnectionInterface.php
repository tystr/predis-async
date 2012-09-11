<?php

/*
 * This file is part of the Predis\Async package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Async\Connection;

use Predis\Command\CommandInterface;
use React\EventLoop\LoopInterface;

/**
 * Defines a connection object that groups multiple single connection instances.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface AggregatedConnectionInterface extends ConnectionInterface
{
    /**
     * Adds a connection instance to the aggregated connection.
     *
     * @param SingleConnectionInterface $connection Instance of a connection.
     */
    public function add(SingleConnectionInterface $connection);

    /**
     * Removes the specified connection instance from the aggregated
     * connection.
     *
     * @param SingleConnectionInterface $connection Instance of a connection.
     * @return Boolean Returns true if the connection was in the pool.
     */
    public function remove(SingleConnectionInterface $connection);

    /**
     * Gets the actual connection instance in charge of the specified command.
     *
     * @param CommandInterface $command Instance of a Redis command.
     * @return SingleConnectionInterface
     */
    public function getConnection(CommandInterface $command);
}
