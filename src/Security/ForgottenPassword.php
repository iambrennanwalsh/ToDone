<?php

namespace App\Security;

use Twig\Environment;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	
class ForgottenPassword {
	
	private $twig;
	private $mailer;
	private $doctrine;
	private $user;
	private $encoder;
	
	public function __construct(\Swift_Mailer $mailer, Environment $twig, ManagerRegistry $doctrine, UserPasswordEncoderInterface $encoder) {
		
		$this->twig = $twig;
    $this->mailer = $mailer;
		$this->doctrine = $doctrine->getManager();
		$this->encoder = $encoder;
		
	}
	
	
	public function checkUser($info) {
		
		$repo = $this->doctrine->getRepository(User::class);
		$email = $repo->findOneBy(array('email' => $info));
		$phone = $repo->findOneBy(array('phone' => $info));
		if ($email || $phone) {
			
			if ($email) {
				$this->user = $email;
			}
		
			elseif($phone) {
				$this->user = $phone;
			}
			
			$this->sendEmail();
			
			return "Great! Now check that email for further instructions!";
			
		}
		
		return "We're sorry, that email wasn't connected to any of our users.";
		
	}
	
	
	public function sendEmail() {
		
		$id = $this->user->getId();
		$password = $this->user->getPassword();
		
		$url = "https://todone.local/change?id=$id&hash=$password";
				
		$message = (new \Swift_Message('Forgot Password'))
			->setSubject('Account Recovery')
			->setFrom('videncrypt@gmail.com')
			->setTo('videncrypt@gmail.com')
			->setBody($this->twig->render(
				'util/email/forgot.twig',
				array(
					'fname' => $this->user->getFirstName(),
					'url' => $url
				)
			),
			'text/html'
		);
				
		$this->mailer->send($message);
		
	}
	
	
	public function checkLink($id, $pass) {
		
		if ($id) {
			
			$this->user = $this->doctrine->getRepository(User::class)->find($id);
			
			if($this->user && $pass == $this->user->getPassword()) {
			
				return true;	
			
			}
		} 
		
		return false;
		
	}
	
	
	public function changePassword($id, $pass, $confirm) {
		
		$this->user = $this->doctrine->getRepository(User::class)->find($id);
			
		if($this->user) {
			
			if($pass == $confirm) {
				
				$this->user->setPassword($this->encoder->encodePassword($this->user, $pass));
				
				$this->doctrine->persist($this->user);
				$this->doctrine->flush();
				
				$this->sendConfirmationEmail();
				
				return true;
				
			}
			
			return "The passwords didn't match.";
			
		}
			
		return "Something went wrong.";
	}
	
	
	public function sendConfirmationEmail() {
		
		$message = (new \Swift_Message('Changed Password'))
			->setSubject('Your password has been changed.')
			->setFrom('videncrypt@gmail.com')
			->setTo('videncrypt@gmail.com')
			->setBody($this->twig->render(
				'util/email/passwordChanged.twig'),
			 	'text/html');
		
		$this->mailer->send($message);
		
	}
	
}
