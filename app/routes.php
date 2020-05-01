<?php
declare(strict_types=1);

use App\Application\Actions\Testimony\ViewTestimonyAction;
use Slim\App;
use Slim\Psr7\Response;

return function (App $app) {
    // temporarily redirect home to provchurch website
    // $app->get('/', ViewHomeAction::class);
    $app->get('/', function ($request, Response $response) use ($app) {
        return $response->withStatus(302)->withHeader('Location', 'https://provchurch.org');
    });

    $app->get('/{slug}', ViewTestimonyAction::class);
};
