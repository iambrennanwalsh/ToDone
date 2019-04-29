<?php

namespace App\Security;

use Twig\Environment;
use App\Entity\Users;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Common\Persistence\ManagerRegistry;

class CloseAccount {
	
	private $request;
	private $twig;
	private $mailer;
	private $user;
	private $doctrine;
	
	public function __construct(RequestStack $request, \Swift_Mailer $mailer, Environment $twig, Security $security, ManagerRegistry $doctrine) {
		
		$this->request = $request->getCurrentRequest();
		$this->twig = $twig;
    $this->mailer = $mailer;
		$this->doctrine = $doctrine;
		$this->security = $security;
		
	}
	
	public function email() {
		
		$user = $this->security->getUser();
		
		$message = (new \Swift_Message('Close Account.'))
			->setSubject('Close your todone.io account.')
			->setFrom('mail@videncrypt.com')
			->setTo('videncrypt@gmail.com') // $this->user->getEmail()
			->setBody(
				$this->twig->render(
					'util/email/close.twig',
					array(
						'fname' => $user->getFirstName(),
						'url' => 'https://todone.local/close?id=' . $user->getId() . '&hash=' . $user->getPassword()
					)
				),
			 	'text/html');
		
		$this->mailer->send($message);
		
	}
	
	
	public function confirmEmail($id, $hash) {
		
		$user = $this->doctrine->getRepository(Users::class)->find($id);
		
		$confirm = $user->getPassword();
		
		if ($confirm == $hash) { return true; } 
		
		return false;
	}
}