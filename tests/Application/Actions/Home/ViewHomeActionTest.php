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
        $this->assertCount(1, $response->getHeader('Location'));
    }
}
