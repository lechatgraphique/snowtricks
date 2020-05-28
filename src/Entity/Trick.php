<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @var int|null $id
     */
    private ?int $id = null;

    /**
     * @ORM\Column()
     * @var string|null $author
     */
    private ?string $author = null;

    /**
     * @ORM\Column()
     * @var string|null $slug
     */
    private ?string $slug = null;

    /**
     * @ORM\Column()
     * @var string|null $title
     */
    private ?string $title = null;

    /**
     * @ORM\Column(type="text")
     * @var string|null $description
     */
    private ?string $description = null;

    /**
     * @ORM\Column()
     * @var string|null $mainPicture
     */
    private ?string $mainPicture = null;

    /**
     * @ORM\Column()
     * @var string|null $youtubeMovie
     */
    private ?string $youtubeMovie = null;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTimeInterface|null $createdAt
     */
    private ?DateTimeInterface $createdAt = null;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTimeInterface|null $updatedAt
     */
    private ?DateTimeInterface $updatedAt = null;

    /**
     * @ORM\Column(type="boolean")
     * @var bool|null $isValid
     */
    private ?bool $isValid = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="trick", cascade={"persist"}, orphanRemoval=true)
     * @var Collection|null $pictures
     */
    private ?Collection $pictures = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trick")
     * @var Collection|null $comments
     */
    private ?Collection $comments = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="tricks")
     * @var Collection|null $categories
     */
    private ?Collection $categories = null;

    public function __construct()
    {
        $this->setIsValid(false);
        $this->pictures = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

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
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     * @return Trick
     */
    public function setAuthor(?string $author): Trick
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return Trick
     */
    public function setSlug(?string $slug): Trick
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Trick
     */
    public function setTitle(?string $title): Trick
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Trick
     */
    public function setDescription(?string $description): Trick
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMainPicture(): ?string
    {
        return $this->mainPicture;
    }

    /**
     * @param string|null $mainPicture
     * @return Trick
     */
    public function setMainPicture(?string $mainPicture): Trick
    {
        $this->mainPicture = $mainPicture;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getYoutubeMovie(): ?string
    {
        return $this->youtubeMovie;
    }

    /**
     * @param string|null $youtubeMovie
     * @return Trick
     */
    public function setYoutubeMovie(?string $youtubeMovie): Trick
    {
        $this->youtubeMovie = $youtubeMovie;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface|null $createdAt
     * @return Trick
     */
    public function setCreatedAt(?DateTimeInterface $createdAt): Trick
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $updatedAt
     * @return Trick
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): Trick
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    /**
     * @param bool|null $isValid
     * @return Trick
     */
    public function setIsValid(?bool $isValid): Trick
    {
        $this->isValid = $isValid;
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getPictures(): ?Collection
    {
        return $this->pictures;
    }

    /**
     * @param Picture $picture
     */
    public function addImage(Picture $picture)
    {
        $picture->setTrick($this);
        $this->pictures->add($picture);
    }

    public function removeImage(Picture $picture)
    {
        $picture->setTrick(null);
        $this->pictures->removeElement($picture);
    }

    /**
     * @param Collection|null $pictures
     * @return Trick
     */
    public function setPictures(?Collection $pictures): Trick
    {
        $this->pictures = $pictures;
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getComments(): ?Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @param Collection|null $comments
     * @return Trick
     */
    public function setComments(?Collection $comments): Trick
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getCategories(): ?Collection
    {
        return $this->categories;
    }

    /**
     * @param Collection|null $categories
     * @return Trick
     */
    public function setCategories(?Collection $categories): Trick
    {
        $this->categories = $categories;
        return $this;
    }
}