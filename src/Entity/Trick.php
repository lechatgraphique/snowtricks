<?php

namespace App\Entity;

use DateTime;
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
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int $id
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\user", mappedBy="tricks")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="trick")
     * @var Image
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movie", mappedBy="trick")
     */
    private $movies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trick")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="tricks")
     */
    private $categories;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->movies = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

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

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @param Collection $images
     * @return $this
     */
    public function setImages(Collection $images): self
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @param Image $image
     * @return $this
     */
    public function addImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->add($image);
        }

        return $this;
    }

    /**
     * @param Image $image
     * @return $this
     */
    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    /**
     * @param Collection $movies
     * @return $this
     */
    public function setMovies(Collection $movies): self
    {
        $this->movies = $movies;

        return $this;
    }

    /**
     * @param Movie $movie
     * @return $this
     */
    public function addMovie(Movie $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->add($movie);
        }

        return $this;
    }

    /**
     * @param Movie $movie
     * @return $this
     */
    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param Collection $comments
     * @return $this
     */
    public function setComments(Collection $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->add($comment);
        }

        return $this;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Collection $categories
     * @return $this
     */
    public function setCategories(Collection $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function addCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }
}
