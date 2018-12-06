<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;

class FrontController extends AbstractController {

	public function home() {
		return $this->render('front/home.twig');}
	
	public function about() {
		return $this->render('front/about.twig');}
	
	public function contact(Request $request, \Swift_Mailer $mailer) {
		$form = $this->createForm(ContactType::class);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()) {
			$message = (new \Swift_Message('Hello Email'))
				->setSubject($form->getData()['subject'])
				->setFrom($form->getData()['email'])
				->setTo('videncrypt@gmail.com')
				->setBody($form->getData()['message'], 'text/html');
			$mailer->send($message);
			unset($form);
			$form = $this->createForm(ContactType::class);}
		return $this->render('front/contact.twig', [
			'contact' => $form->createView()]);}
	
	public function terms() {
		return $this->render('front/terms.twig');}
	
	public function privacy() {
		return $this->render('front/privacy.twig');}

}