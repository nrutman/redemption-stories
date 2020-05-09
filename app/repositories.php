<?php
declare(strict_types=1);

use App\Domain\Testimony\TestimonyRepositoryInterface;
use App\Infrastructure\Persistence\Testimony\TestimonyRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our repository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        TestimonyRepositoryInterface::class => autowire(TestimonyRepository::class),
    ]);
};
