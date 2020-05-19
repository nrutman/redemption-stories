<?php
declare(strict_types=1);

use App\Domain\Story\StoryRepositoryInterface;
use App\Infrastructure\Persistence\Story\StoryRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our repository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        StoryRepositoryInterface::class => autowire(StoryRepository::class),
    ]);
};
