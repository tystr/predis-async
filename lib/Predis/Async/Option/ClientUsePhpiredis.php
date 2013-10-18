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

/**
 * Option class that handles the creation of the event loop.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ClientUsePhpiredis extends AbstractOption
{
    /**
     * {@inheritdoc}
     */
    public function filter(ClientOptionsInterface $options, $value)
    {
        return (bool) $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault(ClientOptionsInterface $options)
    {
        return extension_loaded('phpiredis');
    }
}
