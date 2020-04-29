<?php

namespace App\Application\Actions\Home;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class ViewHomeAction extends Action
{
    /** {@inheritdoc} */
    protected function action(): Response
    {
        return $this->respondWithView('home.html.twig');
    }
}
