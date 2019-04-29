<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Controller\APIController;
use App\Doctrine\UpdateSubscriber;
	
/**
 * A user.
 * @ApiResource(
 *			collectionOperations={
 *						"get"={"method"="GET"},
 *						"post"={"method"="POST"}
 *      },
 *     	itemOperations={
 *						"get"={"method"="GET"},
 *						"put"={"method"="PUT"},
 *						"delete"={"method"="DELETE"},
 *            "check_password"={"route_name"="check_password"},
 *            "encrypt_password"={"route_name"="encrypt_password"},
 *            "mailer"={"route_name"="mailer"}
 *			}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
	
class Users implements UserInterface {
	
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
     * @var string The hashed password
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
     * @ORM\OneToMany(targetEntity="App\Entity\Boards", mappedBy="userid", cascade={"all"}, orphanRemoval=true)
		 * @ApiSubresource
     */
    private $boards;
		
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $confirmed;

	
    public function __construct() {
			$this->roles[] = 'ROLE_USER';
			$this->lists = new ArrayCollection();
			$this->confirmed = mt_rand(1000000000, 10000000000); }

	
    public function getId(): int {
        return $this->id; }

	
    public function getPhone(): string {
        return $this->phone; }

    public function setPhone(string $phone): self {
        $this->phone = $phone;
        return $this; }
	
	
		public function getEmail(): string {
        return $this->email; }

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this; }

	
    public function getRoles(): array {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles); }

    public function setRoles(array $roles): self {
        $this->roles = $roles;
        return $this; }

	
    public function getPassword(): string {
        return $this->password; }

    public function setPassword(string $password): self {
        $this->password = $password;
        return $this; }


    public function getFirstName(): string {
        return $this->firstName; }

    public function setFirstName(string $firstName): self {
        $this->firstName = $firstName;
        return $this; }
	

    public function getLastName(): string {
        return $this->lastName; }

    public function setLastName(string $lastName): self {
        $this->lastName = $lastName;
        return $this; }

	
    public function getCountry(): string {
        return $this->country; }

    public function setCountry(string $country): self {
        $this->country = $country;
        return $this; }

	
    public function getGender(): string {
        return $this->gender; }

    public function setGender(string $gender): self {
        $this->gender = $gender;
        return $this; }
		
		
		
    public function getBoards(): Collection {
        return $this->boards; }

    public function addList(Boards $board): self {
        if (!$this->boards->contains($board)) {
            $this->boards[] = $board;
            $board->setUserid($this); }
        return $this; }

    public function removeBoard(Boards $board): self {
        if ($this->boards->contains($board)) {
            $this->boards->removeElement($board);
            // set the owning side to null (unless already changed)
            if ($board->getUserid() === $this) {
                $board->setUserid(null); } }
        return $this; }

	
    public function getConfirmed(): string {
        return $this->confirmed; }

    public function setConfirmed(string $confirmed): self {
        $this->confirmed = $confirmed;
        return $this; }
	
	
		public function getSalt() {}

    public function eraseCredentials() {}
	
		public function getUsername() {
			return $this->email;
		}
		
		
}
