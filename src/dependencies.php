<?php

use \Psr\Container\ContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

// DIC configuration

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger   = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

/**
 * MongoDB initializer
 *
 * @param \Psr\Container\ContainerInterface $container
 *
 * @return \Illuminate\Database\Capsule\Manager
 * @throws \Exception
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
$container['mongodb'] = function (ContainerInterface $container) {
    $settings   = $container->get('settings');
    $connection = getenv('DB_CONNECTION');

    if (empty($connection) OR $connection != 'mongodb') {
        throw new Exception('MongoDB connection failed.');
    }

    $capsule = new Capsule;
    $capsule->getDatabaseManager()->extend(
        $connection,
        function ($config) {
            return new Jenssegers\Mongodb\Connection($config);
        }
    );
    $capsule->addConnection($settings['db'][$connection]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$container['errorHandler'] = function (ContainerInterface $container) {
    return function (\Slim\Http\Request $request, \Slim\Http\Response $response, $exception) use ($container) {
        /** @var \Slim\Http\Response $response */
        $response = $container['response'];

        return $response->withJson(['errors' => 'Something went wrong!'], 500);
    };
};