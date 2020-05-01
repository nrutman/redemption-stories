<?php
declare(strict_types=1);

use App\Application\Actions\Home\ViewHomeAction;
use App\Application\Actions\Testimony\ViewTestimonyAction;
use Slim\App;

return function (App $app) {
    $app->get('/', ViewHomeAction::class);

    $app->get('/{slug}', ViewTestimonyAction::class);
};
