<?php

namespace App\Security;

use Twig\Environment;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class EmailVerification {
	
	private $request;
	private $twig;
	private $mailer;
	private $doctrine;
	private $security;
  
	
	public function __construct(RequestStack $request, \Swift_Mailer $mailer, Environment $twig, ManagerRegistry $doctrine, Security $security) {
		
		$this->request = $request->getCurrentRequest();
		$this->twig = $twig;
    $this->mailer = $mailer;
		$this->doctrine = $doctrine;
		$this->security = $security;
		
	}
	
	public function sendConfirmationEmail() {
		
		$user = $this->security->getUser();
		
		$message = (new \Swift_Message('Thanks for joining.'))
			->setSubject('Welcome to ToDone!. Confirm your email.')
			->setFrom('mail@videncrypt.com')
			->setTo('videncrypt@gmail.com')
			->setBody(
				$this->twig->render(
					'util/email/signup.twig',
					array(
						'fname' => $user->getFirstName(),
						'url' => 'https://todone.local/confirm?id=' . $user->getId() . '&hash=' . $user->getConfirmed()
					)
				),
			 	'text/html');
		
		$this->mailer->send($message);
		
	}
	
	
	public function confirmEmail($id, $hash) {
		
		$user = $this->doctrine->getRepository(User::class)->find($id);
		
		$confirm = $user->getConfirmed();
		
		if ($confirm == $hash) {
			
				$user->setConfirmed('1');
				$entityManager = $this->doctrine->getManager();
				$entityManager->persist($user);
				$entityManager->flush();
			
				$this->request->getSession()->getFlashBag()->add('email_success', '');
			
				return true;
			
		} else {
			
			$this->request->getSession()->getFlashBag()->add('email_failed', '');
			
			return false;
			
		}
	}
}