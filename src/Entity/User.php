<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
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
     * @var string $username
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string $password
     */
    private $password;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="user")
     */
    private $tricks;

    /**
     * Trick constructor
     */
    public function __construct()
    {
        $this->tricks = new ArrayCollection();
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
    public function getUsername(): string
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
    public function getPassword(): string
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
    public function getAvatar(): string
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
    public function getCountry(): string
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
    public function getFirstName(): string
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
    public function getLastName(): string
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
    public function getCreatedAt(): DateTime
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
    public function isDisabled(): bool
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
    public function getRoles(): array
    {
        return $this->roles;
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
    public function getResetPassword(): string
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
    public function getResetPasswordAt(): DateTime
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
