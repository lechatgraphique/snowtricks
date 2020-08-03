<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity()
 * @UniqueEntity(fields={"username"}, message="Ce nom d'utilisateur est déjà utilisé")
 * @UniqueEntity(fields={"email"}, message="Cet email est déjà utilisé")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int $id
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Veuillez renseigner un nom d'utilisateur")
     * @Assert\Length(max=50, maxMessage="Votre nom d'utilisateur ne doit pas dépasser 50 caractères")
     * @var string|null $username
     */
    private ?string $username = null;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Email(message="Veuillez renseigner un email valide")
    * @var string|null $email
     */
    private ?string $email = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire au moins 8 caractères !")
     * @var string|null $password
     */
    private ?string $password = null;

    /**
     * @Assert\EqualTo(propertyPath="password", message="La confirmation et le mot de passe ne correspondent pas !")
     * @var string|null $passwordConfirm
     */
    private ?string $passwordConfirm = null;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTimeInterface|null $createdAt
     */
    private ?DateTimeInterface  $createdAt = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trick", mappedBy="user", orphanRemoval=true)
     * @var Trick|null $tricks
     */
    private $tricks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user", orphanRemoval=true)
     * @var Comment|null $comments
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null $token
     */
    private ?string $token = null;

    /**
     * @ORM\Column(type="boolean")
     * @var bool|null $activated
     */
    private ?bool $activated = null;

    /**
     * @Assert\Image()
     * @var UploadedFile|null $file
     */
    private ?UploadedFile $file = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null $picturePath
     */
    private ?string $picturePath = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null $picutreName
     */
    private ?string $pictureName = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->tricks = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return User
     */
    public function setUsername(?string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return User
     */
    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return User
     */
    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }

    /**
     * @param string|null $passwordConfirm
     * @return User
     */
    public function setPasswordConfirm(?string $passwordConfirm): User
    {
        $this->passwordConfirm = $passwordConfirm;
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
     * @return User
     */
    public function setCreatedAt(?DateTimeInterface $createdAt): User
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Trick|null
     */
    public function getTricks(): ?Trick
    {
        return $this->tricks;
    }

    /**
     * @param Trick $trick
     * @return $this
     */
    public function addTrick(Trick $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setUser($this);
        }

        return $this;
    }

    /**
     * @param Trick $trick
     * @return $this
     */
    public function removeTrick(Trick $trick): self
    {
        if ($this->tricks->contains($trick)) {
            $this->tricks->removeElement($trick);

            if ($trick->getUser() === $this) {
                $trick->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Comment|null
     */
    public function getComments(): ?Comment
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
            $comment->setUser($this);
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

            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     * @return User
     */
    public function setToken(?string $token): User
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getActivated(): ?bool
    {
        return $this->activated;
    }

    /**
     * @param bool|null $activated
     * @return User
     */
    public function setActivated(?bool $activated): User
    {
        $this->activated = $activated;
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
     * @return User
     */
    public function setFile(?UploadedFile $file): User
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPicturePath(): ?string
    {
        return $this->picturePath;
    }

    /**
     * @param string|null $picturePath
     * @return User
     */
    public function setPicturePath(?string $picturePath): User
    {
        $this->picturePath = $picturePath;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPictureName(): ?string
    {
        return $this->pictureName;
    }

    /**
     * @param string|null $pictureName
     * @return User
     */
    public function setPictureName(?string $pictureName): User
    {
        $this->pictureName = $pictureName;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }
    /**
     * @see UserInterface
     */
    public function getsalt() {}

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {}

}
