<?php
declare(strict_types=1);

namespace Tests\Domain\Story;

use App\Domain\Story\Story;
use Tests\TestCase;

class StoryTest extends TestCase
{
    public function getterSetterProvider(): array
    {
        return [
            'Standard' => [0, '01-bill', 'bill.jpg', 'Bill', 'Davis', 'a title', '<strong>some</strong>description', 'Pastor Foo', 'https://video', 'https://poster']
        ];
    }

    /**
     * @dataProvider getterSetterProvider
     *
     * @param int $id
     * @param string $slug
     * @param string $bioPhoto
     * @param string $ownerFirstName
     * @param string $ownerLastName
     * @param string $title
     * @param string $descriptionHtml
     * @param string $toldBy
     * @param string $videoUri
     * @param string $videoPosterUri
     */
    public function testGetters(
        int $id,
        string $slug,
        string $bioPhoto,
        string $ownerFirstName,
        string $ownerLastName,
        string $title,
        string $descriptionHtml,
        string $toldBy,
        string $videoUri,
        string $videoPosterUri
    ) {
        $story = new Story(
            $id,
            $slug,
            $bioPhoto,
            $ownerFirstName,
            $ownerLastName,
            $title,
            $descriptionHtml,
            $toldBy,
            $videoUri,
            $videoPosterUri
        );

        $this->assertEquals($id, $story->getId());
        $this->assertEquals($slug, $story->getSlug());
        $this->assertEquals($bioPhoto, $story->getBioPhoto());
        $this->assertEquals($ownerFirstName, $story->getOwnerFirstName());
        $this->assertEquals($ownerLastName, $story->getOwnerLastName());
        $this->assertEquals($title, $story->getTitle());
        $this->assertEquals($descriptionHtml, $story->getDescriptionHtml());
        $this->assertEquals($toldBy, $story->getToldBy());
        $this->assertEquals($videoUri, $story->getVideoUri());
        $this->assertEquals($videoPosterUri, $story->getVideoPosterUri());
    }
}
