<?php
declare(strict_types=1);

namespace App\Domain\Testimony;

use JsonSerializable;

class Testimony
{
    /** @var string */
    private $descriptionHtml;

    /** @var string */
    private $ownerName;

    /** @var string */
    private $slug;

    /** @var string */
    private $videoPosterUri;

    /** @var string */
    private $videoUri;

    /**
     * @param string $slug
     * @param string $ownerName
     * @param string $descriptionHtml
     * @param string $videoUri
     * @param string $videoPosterUri
     */
    public function __construct(
        string $slug, string $ownerName, string $descriptionHtml, string $videoUri, string $videoPosterUri
    ) {
        $this->slug = $slug;
        $this->ownerName = $ownerName;
        $this->descriptionHtml = $descriptionHtml;
        $this->videoUri = $videoUri;
        $this->videoPosterUri = $videoPosterUri;
    }

    /**
     * @return string
     */
    public function getDescriptionHtml(): string
    {
        return $this->descriptionHtml;
    }

    /**
     * @return string
     */
    public function getOwnerName(): string
    {
        return $this->ownerName;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getVideoPosterUri(): string
    {
        return $this->videoPosterUri;
    }

    /**
     * @return string
     */
    public function getVideoUri(): string
    {
        return $this->videoUri;
    }
}
