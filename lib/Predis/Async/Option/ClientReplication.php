<?php

/*
 * This file is part of the Predis\Async package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Async\Option;

use Predis\Option\AbstractOption;
use Predis\Option\ClientOptionsInterface;
use Predis\Async\Connection\AggregatedConnectionInterface;
use Predis\Async\Connection\MasterSlaveReplication;

/**
 * Option class that returns a replication connection be used by a client.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ClientReplication extends AbstractOption
{
    /**
     * Checks if the specified connection is valid.
     *
     * @param AggregatedConnectionInterface $connection Instance of a replication connection.
     * @return AggregatedConnectionInterface
     */
    protected function checkInstance($connection)
    {
        if (!$connection instanceof AggregatedConnectionInterface) {
            throw new \InvalidArgumentException('Instance of Predis\Async\Connection\AggregatedConnectionInterface expected');
        }

        return $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(ClientOptionsInterface $options, $value)
    {
        if (is_callable($value)) {
            $connection = $this->checkInstance(call_user_func($value, $options));

            return $connection;
        }

        if (is_string($value)) {
            if (!class_exists($value)) {
                throw new \InvalidArgumentException("Class $value does not exist");
            }

            $connection = $this->checkInstance(new $value());

            return $connection;
        }

        if ($value == true) {
            return $this->getDefault($options);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault(ClientOptionsInterface $options)
    {
        return new MasterSlaveReplication($options->eventloop);
    }
}
