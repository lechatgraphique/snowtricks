<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Movie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int $id
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string $url
     */
    private $url;

    /**
     * @ORM\Column(type="datetime")
     * @var datetime $createdAt
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="movies")
     */
    private $trick;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Movie
     */
    public function setId(int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Movie
     */
    public function setUrl(string $url): Movie
    {
        $this->url = $url;
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
     * @return Movie
     */
    public function setCreatedAt(DateTime $createdAt): Movie
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrick()
    {
        return $this->trick;
    }

    /**
     * @param mixed $trick
     * @return Movie
     */
    public function setTricks($trick)
    {
        $this->trick = $trick;
        return $this;
    }
}
