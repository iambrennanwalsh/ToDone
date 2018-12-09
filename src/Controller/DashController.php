<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashController extends AbstractController {
	
	public function lists() {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Home');}

		return $this->render('dash/lists.twig');}
	
	public function profile() {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Home');}
		
		return $this->render('dash/profile.twig');}
	
}