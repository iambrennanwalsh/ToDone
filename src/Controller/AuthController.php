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
		
		return $this->render('auth/signup.twig', 
												 ['signup' => $form->createView()]);
	}

	public function login(AuthenticationUtils $authenticationUtils): Response {

		if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
      return $this->redirectToRoute('Home');}
			
		$error = $authenticationUtils->getLastAuthenticationError();

    return $this->render('auth/login.twig', ['error' => $error]);}

	public function forgot(Request $request, \Swift_Mailer $mailer) {
		$response = null;
		if(null !== $request->request->get('email')) {
			$email = $request->request->get('email');
			$em = $this->getDoctrine()->getManager();
			$user = $em->getRepository(User::class)->findOneBy(array('email' => $email));
			if($user) {
				$id = $user->getId();
				$password = $user->getPassword();
				$url = "<a href='https://bizplan.local/change?id=$id&hash=$password'>Click this link to reset your password.</a>";
				$message = (new \Swift_Message('Forgot Password'))
					->setSubject('Account Recovery')
					->setFrom('videncrypt@gmail.com')
					->setTo('videncrypt@gmail.com')
					->setBody("$url", 'text/html');
				$mailer->send($message);
				$response = "Great! Now check that email for further instructions!";
				return $this->render('auth/forgot.twig', ['response' => $response]);}
			$response = "We're sorry, that email wasn't connected to any of our users.";
		}

		return $this->render('auth/forgot.twig', ['response' => $response]);
	}
	
public function change(Request $request, \Swift_Mailer $mailer, UserPasswordEncoderInterface $passwordEncoder) {
	if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    return $this->redirectToRoute('Home');}

	$response = "We're sorry but that url wasn't valid";
	if(null !== $request->request->get('pass') && null !== $request->request->get('rpass')) {
		$id = $request->request->get('googleAnalytics');
		$pass = $request->request->get('pass');
		$rpass = $request->request->get('rpass');
		if($pass == $rpass) {
				$entityManager = $this->getDoctrine()->getManager();
				$user = $entityManager->getRepository(User::class)->find($id);
				if($user) {
						$pass = $passwordEncoder->encodePassword($user, $pass);
						$user->setPassword($pass);
						$entityManager->persist($user);
						$entityManager->flush();
						$message = (new \Swift_Message('Changed Password'))
							->setSubject('Your password has been changed.')
							->setFrom('videncrypt@gmail.com')
							->setTo('videncrypt@gmail.com')
							->setBody("If this wasn't you, then some shady stuffs goin down.", 'text/html');
						$mailer->send($message);
						return $this->redirectToRoute('Login');
				} else {$response = "Something wen't wrong.";}
		} else {
				return $this->render('auth/change.twig', ['id' => $id, 'response' => "The passwords didn't match. Try again."]);
		} 
	} elseif(null !== $request->query->get('id') && null !== $request->query->get('hash')) {
		$id = $request->query->get('id');
		$pass = $request->query->get('hash');
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository(User::class)->find($id);
		if($user) {
			$password = $user->getPassword();
			if ($pass == $password) {
				return $this->render('auth/change.twig', ['id' => $id]);
			}
		}
	} 
	
	return $this->redirectToRoute('Forgot', array('response' => $response));
}
}
