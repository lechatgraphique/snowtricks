<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @UniqueEntity(fields={"username"}, message="Le compte existe déjà")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int $id
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     * @Assert\Email
     * @var string $username
     */
    private $username;


    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire minimum {{ limit }} caractères", groups={"registration"})
     * @Assert\EqualTo(propertyPath="confirmPassword", message="Votre mot de passe doit être le même que votre mot de passe de confirmation", groups={"registration"})
     * @var string $password
     */
    private $password;

    /**
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire minimum {{ limit }} caractères", groups={"registration"})
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tapé le même mot de passe", groups={"registration"})
     * @var string $oldPassword
     */
    private $oldPassword;

    /**
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire minimum {{ limit }} caractères", groups={"registration"})
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tapé le même mot de passe", groups={"registration"})
     * @var string $newPassword
     */
    private $newPassword;

    /**
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire minimum {{ limit }} caractères", groups={"registration"})
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tapé le même mot de passe", groups={"registration"})
     * @var string $confirmPassword
     */
    private $confirmPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string $avatar
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", columnDefinition="CHAR(2)", nullable=false)
     * @var string $country
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string $firstName
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string $lastName
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var DateTime $createdAt
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var bool $disabled
     */
    private $disabled = false;

    /**
     * @ORM\Column(type="json", nullable=false)
     * @var array $roles
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string $resetPassword
     */
    private $resetPassword;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime $resetPasswordAt
     */
    private $resetPasswordAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trick", mappedBy="user")
     */
    private $tricks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     */
    private $comments;

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
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    /**
     * @param string $oldPassword
     * @return User
     */
    public function setOldPassword(string $oldPassword): User
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     * @return User
     */
    public function setNewPassword(string $newPassword): User
    {
        $this->newPassword = $newPassword;
        return $this;
    }


    /**
     * @return string
     */
    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    /**
     * @param string $confirmPassword
     * @return User
     */
    public function setConfirmPassword(string $confirmPassword): User
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     * @return User
     */
    public function setAvatar(string $avatar): User
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return User
     */
    public function setCountry(string $country): User
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return User
     */
    public function setCreatedAt(DateTime $createdAt): User
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled(): ?bool
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return User
     */
    public function setDisabled(bool $disabled): User
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): ?array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string
     */
    public function getResetPassword(): ?string
    {
        return $this->resetPassword;
    }

    /**
     * @param string $resetPassword
     * @return User
     */
    public function setResetPassword(string $resetPassword): User
    {
        $this->resetPassword = $resetPassword;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getResetPasswordAt(): ?DateTime
    {
        return $this->resetPasswordAt;
    }

    /**
     * @param DateTime $resetPasswordAt
     * @return User
     */
    public function setResetPasswordAt(DateTime $resetPasswordAt): User
    {
        $this->resetPasswordAt = $resetPasswordAt;

        return $this;
    }

    /**
     * @return Collection|Trick[]
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    /**
     * @param Collection $tricks
     * @return $this
     */
    public function setTricks(Collection $tricks): self
    {
        $this->tricks = $tricks;

        return $this;
    }

    /**
     * @param Trick $trick
     * @return $this
     */
    public function addTrick(Trick $trick): self
    {
        if ($this->tricks->contains($trick)) {
            $this->tricks->add($trick);
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
            $this-> comments->removeElement($comment);
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {

    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {

    }
}
