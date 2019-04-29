<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Entity\Users;
use App\Security\UserRegistration;
use App\Security\ForgottenPassword;
use App\Security\EmailVerification;


class AuthController extends AbstractController {
   	
	
	public function signup(Request $request, UserRegistration $registration, EmailVerification $verification) {
		
		if ($request->isMethod('post')) {
			
  		$user = $registration->registerUser($request->request->get('user'));
			
			$token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
			$this->get('security.token_storage')->setToken($token);
			$this->get('session')->set('_security_main', serialize($token));
			
			$verification->sendConfirmationEmail($user->getId());
			
			return $this->render('dash/boards.twig'); }	
		
		return $this->render('auth/signup.twig');
		
	}
	
	
	
	public function login(AuthenticationUtils $authenticationUtils): Response {
		
		$error = $authenticationUtils->getLastAuthenticationError();
		
    return $this->render('auth/login.twig', [
        'error' => $error ]);
		
	}

	
	
	public function forgot(Request $request, ForgottenPassword $forgot) {
					
		if ($request->isMethod('post')) {
			
			$response = $forgot->checkUser($request->request->get('user'));
			
			return $this->render('auth/forgot.twig', ['response' => $response]);
			
		}
			
		return $this->render('auth/forgot.twig');
	}
	
	
	
	public function change(Request $request, ForgottenPassword $forgot) {
		
		if ($request->isMethod('post') && $request->request->get('id')) {
			
			$response = $forgot->changePassword($request->request->get('id'), $request->request->get('password'), $request->request->get('confirm'));
			
			if ($response === true) {
			
				return $this->redirectToRoute('Login');
				
			}
			
			return $this->redirectToRoute('Forgot', array('response' => $response));
			
		} 
		
		elseif ($forgot->checkLink($request->query->get('id'), $request->query->get('hash'))) {
			
			return $this->render('auth/change.twig', ['id' => $request->query->get('id')]);
			
		}
		
		$response = "We're sorry but that url wasn't valid";
		
		return $this->redirectToRoute('Forgot', array('response' => $response));
		
	}
	
	
	
	public function confirm(Request $request, EmailVerification $verification) {
		
		if($request->query->get('id') && $request->query->get('hash')) {
			
			$response = $verification->confirmEmail($request->query->get('id'), $request->query->get('hash'));
			
			return $this->redirectToRoute('Home', array('confirm' => $response));
			
		}
		
		elseif ($request->query->get('resend')) {
			
			$verification->sendConfirmationEmail();
			
			return $this->redirectToRoute($request->query->get('route'), array('sent' => 'true'));
			
		} 
		
		return $this->redirectToRoute('Home');
		
	}

}
