<?php

namespace App\Service;

use Twig\Environment;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

class EmailVerifier {
	
	private $twig;
	private $mailer;
	private $doctrine;
	private $security;
  
	public function __construct(\Swift_Mailer $mailer, Environment $twig, ManagerRegistry $doctrine, Security $security) {
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
					'utilities/email/signup.twig',
					array(
						'fname' => $user->getFname(),
						'url' => '/confirm?id=' . $user->getId() . '&hash=' . $user->getConfirmed())),
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
				return true;
		} else {
			return false;
		}
	}
}