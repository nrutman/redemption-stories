<?php
declare(strict_types=1);

namespace App\Application\Actions\Home;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class ViewHomeAction extends Action
{
    /** {@inheritdoc} */
    protected function action(): Response
    {
        return $this->response->withStatus(302)->withHeader('Location', '/story/01-lisa');











        
//        return $this->respondWithView('home.html.twig');
    }
}
