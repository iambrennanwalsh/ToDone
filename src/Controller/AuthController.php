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

class AuthController extends AbstractController {
   	
	public function signup(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
            		
  	if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Home');}
            		
    $user = new User();
    $form = $this->createForm(SignupType::class, $user);
    $form->handleRequest($request);
            		
    if($form->isSubmitted() && $form->isValid()){
    	$password = $passwordEncoder->encodePassword($user, $user->getPassword());
      $user->setPassword($password);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($user);
      $entityManager->flush();
      $token = new UsernamePasswordToken($user, $password, 'main', $user->getRoles());
      $this->get('security.token_storage')->setToken($token);
   		$this->get('session')->set('_security_main', serialize($token));
    	return $this->redirectToRoute('Lists');}
            		
		return $this->render('auth/signup.twig', ['signup' => $form->createView()]);}

	public function login(AuthenticationUtils $authenticationUtils): Response {

		if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
      return $this->redirectToRoute('Home');}
			
		$error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('auth/login.twig', ['last_username' => $lastUsername, 'error' => $error]);}
	
}
