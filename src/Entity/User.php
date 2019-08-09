<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Board;

/**
 * A user.
 * @ApiResource()
 * @ORM\Entity()
 * @UniqueEntity(fields="phone", message="{{ value }} is already in use by another user.")
 * @UniqueEntity(fields="email", message="{{ value }} is already in use by another user.")
 */

class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\OneToMany(targetEntity="Board", mappedBy="userId", cascade={"all"}, orphanRemoval=true)
     * @ApiSubresource
     */
    private $boards;

    /**
     * @ORM\Column(type="boolean")
     */
    private $confirmed;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $facebookId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $githubId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $gravatar;

    public function __construct()
    {
        $this->roles[] = 'ROLE_USER';
        $this->lists = new ArrayCollection();
        $this->confirmed = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        $this->setGravatar($email);
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(?string $fb): self
    {
        $this->facebookId = $fb;
        return $this;
    }

    public function getGithubId(): ?string
    {
        return $this->githubId;
    }

    public function setGithubId(?string $github): self
    {
        $this->githubId = $github;
        return $this;
    }

    public function getBoards(): Collection
    {
        return $this->boards;
    }

    public function addBoard(Board $board): self
    {
        if (!$this->boards->contains($board)) {
            $this->boards[] = $board;
            $board->setUserId($this);
        }
        return $this;
    }

    public function removeBoard(Board $board): self
    {
        if ($this->boards->contains($board)) {
            $this->boards->removeElement($board);
            if ($board->getUserId() === $this) {
                $board->setUserId(null);
            }
        }
        return $this;
    }

    public function getConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;
        return $this;
    }

    public function getGravatar(): ?string
    {
        return $this->gravatar;
    }

    public function setGravatar(string $email): self
    {
        $grav_url =
            "https://www.gravatar.com/avatar/" .
            md5(strtolower(trim($email))) .
            "?d=https://todone.local/images/placeholder.png&s=500";
        $this->gravatar = $grav_url;
        return $this;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    public function getUsername()
    {
        return $this->email;
    }
}
