<?php
declare(strict_types=1);

use App\Application\Actions\Home\ViewHomeAction;
use App\Application\Actions\Testimony\ViewTestimonyAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->get('/', ViewHomeAction::class);

    // temporary redirect
    $app->get('/01-lisa', function (Request $request, Response $response) {
        return $response->withStatus(302)->withHeader('Location', '/story/01-lisa');
    });

    $app->get('/story/{slug}', ViewTestimonyAction::class);
};
