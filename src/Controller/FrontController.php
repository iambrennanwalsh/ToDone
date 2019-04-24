<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class FrontController extends AbstractController {

	
	public function home() {
		return $this->render('front/home.twig');}
	
	
	public function about() {
		return $this->render('front/about.twig');}
	
	
	public function contact(Request $request, \Swift_Mailer $mailer) {
		
		if ($request->isMethod('post')) {
			
			$message = (new \Swift_Message('Hello Email'))
				->setSubject("New Message: " . $request->request->get('subject'))
				->setFrom($request->request->get('email'))
				->setTo('videncrypt@gmail.com')
				->setBody($request->request->get('message'), 'text/html');
			$mailer->send($message);
			
		}
		
		return $this->render('front/contact.twig');
	
	}
	
	
	public function terms() {
		return $this->render('front/terms.twig');}
	
	
	public function privacy() {
		return $this->render('front/privacy.twig');}

}