<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int $id
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\user", mappedBy="tricks"
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string $title
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var  string $description
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string $mainImage
     */
    private $mainImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string $mainVideo
     */
    private $mainVideo;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var DateTime $createdAt
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime $updatedAt
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     * @var bool $validated
     */
    private $validated = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Trick
     */
    public function setId(int $id): Trick
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Trick
     */
    public function setUser(User $user): Trick
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Trick
     */
    public function setTitle(string $title): Trick
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Trick
     */
    public function setDescription(string $description): Trick
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getMainImage(): string
    {
        return $this->mainImage;
    }

    /**
     * @param string $mainImage
     * @return Trick
     */
    public function setMainImage(string $mainImage): Trick
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getMainVideo(): string
    {
        return $this->mainVideo;
    }

    /**
     * @param string $mainVideo
     * @return Trick
     */
    public function setMainVideo(string $mainVideo): Trick
    {
        $this->mainVideo = $mainVideo;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Trick
     */
    public function setCreatedAt(DateTime $createdAt): Trick
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return Trick
     */
    public function setUpdatedAt(DateTime $updatedAt): Trick
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return bool
     */
    public function getValidated(): bool
    {
        return $this->validated;
    }

    /**
     * @param bool $validated
     * @return Trick
     */
    public function setValidated(bool $validated): Trick
    {
        $this->validated = $validated;

        return $this;
    }
}
