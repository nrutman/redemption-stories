<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Home;

use Tests\TestCase;

class ViewHomeActionTest extends TestCase
{
    public function testAction()
    {
        $response = $this
            ->getAppInstance()
            ->handle(
                $this
                ->createRequest('GET', '/')
            );

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(['/story/01-lisa'], $response->getHeader('Location'));
    }
}
