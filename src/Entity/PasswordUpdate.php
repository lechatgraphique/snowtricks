<?php


namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;

class PasswordUpdate
{
    /**
     * @var string|null $oldPassword
     */
    private ?string $oldPassword = null;

    /**
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire au moins 8 caractères !")
     * @var string|null $newPassword
     */
    private ?string $newPassword = null;

    /**
     * @Assert\EqualTo(propertyPath="newPassword", message="La confirmation et le nouveau mot de passe ne correspondent pas !")
    * @var string|null $confirmPassword
     */
    private ?string $confirmPassword = null;

    /**
     * @return string|null
     */
    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    /**
     * @param string|null $oldPassword
     * @return PasswordUpdate
     */
    public function setOldPassword(?string $oldPassword): PasswordUpdate
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    /**
     * @param string|null $newPassword
     * @return PasswordUpdate
     */
    public function setNewPassword(?string $newPassword): PasswordUpdate
    {
        $this->newPassword = $newPassword;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    /**
     * @param string|null $confirmPassword
     * @return PasswordUpdate
     */
    public function setConfirmPassword(?string $confirmPassword): PasswordUpdate
    {
        $this->confirmPassword = $confirmPassword;
        return $this;
    }

}