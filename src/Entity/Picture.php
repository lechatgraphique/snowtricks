<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\EntityListeners({"App\EntityListener\PictureListener"})
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @ORM\Column()
     * @var string|null $path
     */
    private ?string $path = null;

    /**
     * @Assert\Image()
     * @var UploadedFile|null $file
     */
    private ?UploadedFile $file = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="pictures")
     * @ORM\JoinColumn(name="trick_id", referencedColumnName="id", onDelete="CASCADE")
     * @var Trick|null
     */
    private ?Trick $trick = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Picture
     */
    public function setId(?int $id): Picture
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     * @return Picture
     */
    public function setPath(?string $path): Picture
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return UploadedFile|null
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile|null $file
     * @return Picture
     */
    public function setFile(?UploadedFile $file): Picture
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return Trick|null
     */
    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    /**
     * @param Trick|null $trick
     * @return Picture
     */
    public function setTrick(?Trick $trick): Picture
    {
        $this->trick = $trick;
        return $this;
    }
}
