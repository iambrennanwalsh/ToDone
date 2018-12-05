<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController {

	public function home() {
		return $this->render('front/home.twig');}
	
	public function about() {
		return $this->render('front/about.twig');}
	
	public function contact() {
		return $this->render('front/contact.twig');}

}