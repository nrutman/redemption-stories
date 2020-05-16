<?php
declare(strict_types=1);

namespace App\Domain\Testimony;

use JsonSerializable;

class Testimony
{
    /** @var string */
    private $bioPhoto;

    /** @var string */
    private $descriptionHtml;

    /** @var int */
    private $id;

    /** @var string */
    private $ownerFirstName;

    /** @var string */
    private $ownerLastName;

    /** @var string */
    private $slug;

    /** @var string */
    private $toldBy;

    /** @var string */
    private $videoPosterUri;

    /** @var string */
    private $videoUri;

    /**
     * @param int $id
     * @param string $slug
     * @param string $bioPhoto
     * @param string $ownerFirstName
     * @param string $ownerLastName
     * @param string $descriptionHtml
     * @param string $toldBy
     * @param string $videoUri
     * @param string $videoPosterUri
     */
    public function __construct(
        int $id,
        string $slug,
        string $bioPhoto,
        string $ownerFirstName,
        string $ownerLastName,
        string $descriptionHtml,
        string $toldBy,
        string $videoUri,
        string $videoPosterUri
    ) {
        $this->id = $id;
        $this->slug = $slug;
        $this->bioPhoto = $bioPhoto;
        $this->ownerFirstName = $ownerFirstName;
        $this->ownerLastName = $ownerLastName;
        $this->descriptionHtml = $descriptionHtml;
        $this->toldBy = $toldBy;
        $this->videoUri = $videoUri;
        $this->videoPosterUri = $videoPosterUri;
    }

    /**
     * @return string
     */
    public function getBioPhoto(): string
    {
        return $this->bioPhoto;
    }

    /**
     * @return string
     */
    public function getDescriptionHtml(): string
    {
        return $this->descriptionHtml;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOwnerFirstName(): string
    {
        return $this->ownerFirstName;
    }

    /**
     * @return string
     */
    public function getOwnerLastName(): string
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
     * @return string
     */
    public function getToldBy(): string
    {
        return $this->toldBy;
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
