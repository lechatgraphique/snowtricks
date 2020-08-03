<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @UniqueEntity(fields={"name"}, message="Ce nom de fichier est déjà utilisé")
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null $name
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="string", length=255)
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
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var Trick|null $trick
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Picture
     */
    public function setName(?string $name): Picture
    {
        $this->name = $name;
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
