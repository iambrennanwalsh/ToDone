<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;

class FrontController extends AbstractController {

	public function home(Request $request) {
		if(null !== $request->query->get('confirm') && false !== $request->query->get('confirm')) {
			return $this->render('front/home.twig', [
				'modal' => true,
				'value'=> $request->query->get('confirm')]);}
		
		return $this->render('front/home.twig');}
	
	public function about() {
		return $this->render('front/about.twig');}
	
	public function contact() {
		return $this->render('front/contact.twig');}
	
	public function terms() {
		return $this->render('front/terms.twig');}
	
	public function privacy() {
		return $this->render('front/privacy.twig');}

}