<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Twig\Environment as TwigEnvironment;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        TwigEnvironment::class => function (ContainerInterface $c): TwigEnvironment {
            $loader = new \Twig\Loader\FilesystemLoader(sprintf('%s/../view', __DIR__));

            $twig = new TwigEnvironment($loader, [
                sprintf('%s/../var/cache', __DIR__),
            ]);

            $twig->enableDebug();

            return $twig;
        },
    ]);
};
