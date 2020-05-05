<?php
declare(strict_types=1);

namespace Tests\Domain\Testimony;

use App\Domain\Testimony\Testimony;
use Tests\TestCase;

class TestimonyTest extends TestCase
{
    public function getterSetterProvider(): array
    {
        return [
            'Standard' => [0, '01-bill', 'Bill', 'Davis', '<strong>some</strong>description', 'Pastor Foo', 'https://video', 'https://poster']
        ];
    }

    /**
     * @dataProvider getterSetterProvider
     * @param int $id
     * @param string $slug
     * @param string $ownerFirstName
     * @param string $ownerLastName
     * @param string $descriptionHtml
     * @param string $toldBy
     * @param string $videoUri
     * @param string $videoPosterUri
     */
    public function testGetters(
        int $id,
        string $slug,
        string $ownerFirstName,
        string $ownerLastName,
        string $descriptionHtml,
        string $toldBy,
        string $videoUri,
        string $videoPosterUri
    ) {
        $testimony = new Testimony(
            $id,
            $slug,
            $ownerFirstName,
            $ownerLastName,
            $descriptionHtml,
            $toldBy,
            $videoUri,
            $videoPosterUri
        );

        $this->assertEquals($id, $testimony->getId());
        $this->assertEquals($slug, $testimony->getSlug());
        $this->assertEquals($ownerFirstName, $testimony->getOwnerFirstName());
        $this->assertEquals($ownerLastName, $testimony->getOwnerLastName());
        $this->assertEquals($descriptionHtml, $testimony->getDescriptionHtml());
        $this->assertEquals($toldBy, $testimony->getToldBy());
        $this->assertEquals($videoUri, $testimony->getVideoUri());
        $this->assertEquals($videoPosterUri, $testimony->getVideoPosterUri());
    }
}
