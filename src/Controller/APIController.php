<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\JsonResponse;


class APIController extends AbstractController {
	
	
	 public function encrypt_password(Users $data, Request $request, UserPasswordEncoderInterface $encoder) {
		 
			$json = json_decode($request->getContent(), true);
		 	$password = $encoder->encodePassword($this->getUser(), $json['password']);
			return new JsonResponse(['password' => $password]); 
		 
    }
	
	
	 public function check_password(Users $data, Request $request, UserPasswordEncoderInterface $encoder) {
		 
			$json = json_decode($request->getContent(), true);
			$status = $encoder->isPasswordValid($this->getUser(), $json['password']) ? true : false;
			return new JsonResponse(['status' => $status]); 
		 
    }
	
	public function mailer(Users $data, Request $request) {
		 
			$json = json_decode($request->getContent(), true);
			if ($json['template'] == "delete") {}
			return new JsonResponse(true); 
		 
    }
}