<?php

/*
 * This file is part of the Predis\Async package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__.'/../autoload.php';

function getCurrentAlias($client) {
    return $client->getConnection()->getCurrent()->getParameters()->alias;
}

$parameters = array(
    'tcp://127.0.0.1:6379?alias=master',
    'tcp://127.0.0.1:6380?alias=slave',
);

$client = new Predis\Async\Client($parameters, array('replication' => true));

$client->connect(function ($client, $connection) {
    echo "Current server: ", getCurrentAlias($client), "\n";

    $client->set('foo', 'bar', function ($reply, $client) {
        echo "Current server: ", getCurrentAlias($client), "\n";
    });
});

$client->getEventLoop()->run();

/* OUTPUT:
Current server: slave
Current server: master
*/
