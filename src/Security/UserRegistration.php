<?php

namespace App\Security;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\User;

class UserRegistration {
	
	private $info;
	private $registry;
	private $encoder;
	private $user;
	private $encodedPassword;
	
	public function __construct(ManagerRegistry $registry, UserPasswordEncoderInterface $encoder) {
		$this->registry = $registry->getManager();
		$this->encoder = $encoder;
		$this->user = new User();
	}
	
	public function registerUser($info) {
		$this->user->setPhone($info['phone']);
		$this->user->setEmail($info['email']);
		$this->user->setFirstName($info['fname']);
		$this->user->setLastName($info['lname']);
		$this->user->setCountry($info['country']);
		$this->user->setGender($info['gender']);
		$this->user->setPassword($this->encoder->encodePassword($this->user, $this->info['password']));
		$this->registry->persist($this->user);
		$this->registry->flush();
		return $this->user;
	}
	
}