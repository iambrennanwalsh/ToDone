<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Form\SignupType;
use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\EmailVerifier;

class AuthController extends AbstractController {
   	
	public function signup(Request $request, UserPasswordEncoderInterface $passwordEncoder, EmailVerifier $verifier) {
  	if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Home');
		}        		
    $user = new User();
    $form = $this->createForm(SignupType::class, $user);
    $form->handleRequest($request);	
    if($form->isSubmitted() && $form->isValid()){
			$entityManager = $this->getDoctrine()->getManager();
			$username = $entityManager->getRepository(User::class)->findOneBy(['username' => $user->getUsername()]);
			$email = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
      if ($username && $email) {
				return $this->render('auth/signup.twig', 
														 ['signup' => $form->createView(), 
															'errors' => 'The provided username and email are already in use.']);
			} elseif ($username) {
				return $this->render('auth/signup.twig', 
														 ['signup' => $form->createView(), 
															'errors' => 'The chosen username is taken.']);
			} elseif ($email) {
				return $this->render('auth/signup.twig', 
														 ['signup' => $form->createView(), 
															'errors' => 'The provided email is already in use.']);
			} else {
    		$password = $passwordEncoder->encodePassword($user, $user->getPassword());
				$user->setPassword($password);
				$entityManager->persist($user);
				$entityManager->flush();
				$verifier->email($user->getId());
				$token = new UsernamePasswordToken($user, $password, 'main', $user->getRoles());
				$this->get('security.token_storage')->setToken($token);
				$this->get('session')->set('_security_main', serialize($token));
    		return $this->redirectToRoute('Lists');
			}
		}
		return $this->render('auth/signup.twig', 
												 ['signup' => $form->createView()]);
	}

	public function login(AuthenticationUtils $authenticationUtils): Response {

		if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
      return $this->redirectToRoute('Home');}
			
		$error = $authenticationUtils->getLastAuthenticationError();

    return $this->render('auth/login.twig', ['error' => $error]);}
	
}
