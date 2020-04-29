<?php
declare(strict_types=1);

use App\Domain\Testimony\TestimonyRepository;
use App\Infrastructure\Persistence\Testimony\InMemoryTestimonyRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our repository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        TestimonyRepository::class => autowire(InMemoryTestimonyRepository::class),
    ]);
};
