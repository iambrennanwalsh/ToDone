<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Lists;

class DashController extends AbstractController {
	
	public function lists() {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Home');}
		
		$user = $this->getUser();
		$lists = $user->getLists();
		return $this->render('dash/lists.twig', ['lists' => $lists]);}
	
	public function profile() {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Home');}
		
		return $this->render('dash/profile.twig');}
	
}