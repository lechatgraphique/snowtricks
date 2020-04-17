<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int $id
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string $title
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string $caption
     */
    private $caption;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var datetime $createdAt
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="images")
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
     * @return Image
     */
    public function setId(int $id): Image
    {
        $this->id = $id;
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
     * @return Image
     */
    public function setTitle(string $title): Image
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     * @return Image
     */
    public function setCaption(string $caption): Image
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * @return datetime
     */
    public function getCreatedAt(): datetime
    {
        return $this->createdAt;
    }

    /**
     * @param datetime $createdAt
     * @return Image
     */
    public function setCreatedAt(datetime $createdAt): Image
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
     * @return Image
     */
    public function setTrick($trick)
    {
        $this->trick = $trick;
        return $this;
    }
}
