<?php
declare(strict_types=1);

namespace App\Domain\Story;

use JsonSerializable;

class Story
{
    /** @var string|null */
    private $bioPhoto;

    /** @var string|null */
    private $descriptionHtml;

    /** @var int */
    private $chapter;

    /** @var string|null */
    private $ownerFirstName;

    /** @var string|null */
    private $ownerLastName;

    /** @var string */
    private $slug;

    /** @var string|null */
    private $title;

    /** @var string|null */
    private $toldBy;

    /** @var string|null */
    private $videoPosterUri;

    /** @var string|null */
    private $videoUri;

    /**
     * @param int $chapter
     * @param string $slug
     * @param string|null $bioPhoto
     * @param string|null $ownerFirstName
     * @param string|null $ownerLastName
     * @param string|null $title
     * @param string|null $descriptionHtml
     * @param string|null $toldBy
     * @param string|null $videoUri
     * @param string|null $videoPosterUri
     */
    public function __construct(
        int $chapter,
        string $slug,
        ?string $bioPhoto,
        ?string $ownerFirstName,
        ?string $ownerLastName,
        ?string $title,
        ?string $descriptionHtml,
        ?string $toldBy,
        ?string $videoUri,
        ?string $videoPosterUri
    ) {
        $this->chapter = $chapter;
        $this->slug = $slug;
        $this->bioPhoto = $bioPhoto;
        $this->ownerFirstName = $ownerFirstName;
        $this->ownerLastName = $ownerLastName;
        $this->title = $title;
        $this->descriptionHtml = $descriptionHtml;
        $this->toldBy = $toldBy;
        $this->videoUri = $videoUri;
        $this->videoPosterUri = $videoPosterUri;
    }

    /**
     * @return string|null
     */
    public function getBioPhoto(): ?string
    {
        return $this->bioPhoto;
    }

    /**
     * @return string|null
     */
    public function getDescriptionHtml(): ?string
    {
        return $this->descriptionHtml;
    }

    /**
     * @return int
     */
    public function getChapter(): int
    {
        return $this->chapter;
    }

    /**
     * @return string|null
     */
    public function getOwnerFirstName(): ?string
    {
        return $this->ownerFirstName;
    }

    /**
     * @return string|null
     */
    public function getOwnerLastName(): ?string
    {
        return $this->ownerLastName;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getToldBy(): ?string
    {
        return $this->toldBy;
    }

    /**
     * @return string|null
     */
    public function getVideoPosterUri(): ?string
    {
        return $this->videoPosterUri;
    }

    /**
     * @return string|null
     */
    public function getVideoUri(): ?string
    {
        return $this->videoUri;
    }
}
