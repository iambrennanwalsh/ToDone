<?php

namespace App\Service;

use Twig\Environment;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;

class EmailVerifier {
	
	private $twig;
	private $mailer;
	private $doctrine;
  
	public function __construct(\Swift_Mailer $mailer, Environment $twig, ManagerRegistry $doctrine) {
		$this->twig = $twig;
    $this->mailer = $mailer;
		$this->doctrine = $doctrine;}
	
	public function email($id) {
		$entityManager = $this->doctrine->getManager();
		$user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
		//if ($user) {
			$code = $user->getConfirmed();
			$url = '/confirm?id=' . $id . '&hash=' . $code;
			$message = (new \Swift_Message('Thanks for joining.'))
				->setSubject('Welcome to ToDone!. Confirm your email.')
				->setFrom('mail@videncrypt.com')
				->setTo('videncrypt@gmail.com')
				->setBody(
				$this->twig->render(
					'utilities/email/signup.twig',
					array('fname' => $user->getFname(),
						'url' => $url)),
			 'text/html');
		$this->mailer->send($message);//}
	}
	
	public function confirm($id, $hash) {
		$user = $this->doctrine->getRepository(User::class)->find($id);
		$confirm = $user->getConfirmed();
		if ($confirm == $hash) {
				$user->setConfirmed('1');
				$entityManager = $this->doctrine->getManager();
				$entityManager->persist($user);
				$entityManager->flush();
				return true;
		} else {
			return false;}}
}