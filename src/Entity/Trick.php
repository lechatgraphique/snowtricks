<?php

namespace App\Entity;

use App\Service\Slugify;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"name"}, message="Un trick possède déjà ce nom, merci de le modifier")
 * @UniqueEntity(fields={"slug"}, message="Un trick possède déjà ce slug")
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int|null $id
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null $slug
     */
    private ?string $slug = null;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max=100, maxMessage="Le nom ne doit pas faire plus de 100 caractères")
     * @var string|null $name
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=20, minMessage="La description doit faire au moins 20 caractères")
     * @var string|null $description
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null $movie
     */
    private ?string $movie = null;

    /**
     * @ORM\Column(type="boolean")
     * @var bool|null $disabled
     */
    private ?bool $disabled = null;

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
     * @ORM\OneToOne(targetEntity="App\Entity\Picture", cascade={"persist", "remove"})
     * @Assert\Valid()
     * @var Picture|null $mainPicture
     */
    private ?Picture $mainPicture = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="tricks")
     * @var Category|null $category
     */
    private ?Category $category = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="trick", orphanRemoval=true, cascade={"persist", "remove"})
     * @Assert\Valid()
     * @var Collection|null $pictures
     */
    private ?Collection $pictures = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trick", orphanRemoval=true)
     * @var Collection|null $comments
     */
    private ?Collection $comments = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     * @var User|null $user
     */
    private ?User $user = null;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Trick
     */
    public function setName(?string $name): Trick
    {
        $this->name = $name;
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
    public function getMovie(): ?string
    {
        return $this->movie;
    }

    /**
     * @param string|null $movie
     * @return Trick
     */
    public function setMovie(?string $movie): Trick
    {
        $this->movie = $movie;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDisabled(): ?bool
    {
        return $this->disabled;
    }

    /**
     * @param bool|null $disabled
     * @return Trick
     */
    public function setDisabled(?bool $disabled): Trick
    {
        $this->disabled = $disabled;
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
     * @return Picture|null
     */
    public function getMainPicture(): ?Picture
    {
        return $this->mainPicture;
    }

    /**
     * @param Picture|null $mainPicture
     * @return Trick
     */
    public function setMainPicture(?Picture $mainPicture): Trick
    {
        $this->mainPicture = $mainPicture;
        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return Trick
     */
    public function setCategory(?Category $category): Trick
    {
        $this->category = $category;
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
     * @return $this
     */
    public function addImage(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setTrick($this);
        }

        return $this;
    }

    /**
     * @param Picture $picture
     * @return $this
     */
    public function removeImage(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getTrick() === $this) {
                $picture->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getComments(): ?Collection
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTrick($this);
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
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Trick
     */
    public function setUser(?User $user): Trick
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Initialisation du slug avant un persist ou un update
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function initializeSlug()
    {
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->name);

        }
    }

}