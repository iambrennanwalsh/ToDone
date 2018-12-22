<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Lists;
use App\Entity\User;
use App\Service\EmailVerifier;

class UtilityController extends AbstractController {

	public function contactForm(Request $request, \Swift_Mailer $mailer) {
		
		$message = (new \Swift_Message('Hello Email'))
				->setSubject($request->request->get('subject'))
				->setFrom($request->request->get('email'))
				->setTo('videncrypt@gmail.com')
				->setBody($request->request->get('message'), 'text/html');
			$mailer->send($message);
		
		return new JsonResponse($_REQUEST);
	}
	
	public function confirmEmail(Request $request, EmailVerifier $verifier) {
		if(null !== $request->query->get('id') && null !== $request->query->get('hash')) {
			$id = $request->query->get('id');
			$hash = $request->query->get('hash');
			$response = $verifier->confirm($id, $hash);
			if ($response) {
				return $this->redirectToRoute('Home', array('confirm' => 'true'));}
		return $this->redirectToRoute('Home', array('confirm' => 'false'));
	} elseif(null !== $request->query->get('resend')) {
			$user = $this->getUser();
			$id = $user->getId();
			$verifier->email($id);
			return $this->redirectToRoute('Lists', array('sent' => 'true'));
	}
	
		}
	
}