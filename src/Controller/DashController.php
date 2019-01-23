<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Lists;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DashController extends AbstractController {
	
	public function lists(EventDispatcherInterface $eventDispatcher) {
		
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Login');}
		
		$eventDispatcher->dispatch('event.finna');
		$user = $this->getUser();
		$lists = $user->getLists();
		return $this->render('dash/lists.twig', ['lists' => $lists]);
	}
	
	public function list($slug) {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Login');}
		$list = $this->getDoctrine()->getRepository(Lists::class)->find($slug);
		$this->denyAccessUnlessGranted('view', $list);
		return $this->render('dash/list.twig', ['list' => $list]);
	}
	
	public function profile(Request $request) {
		
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    	return $this->redirectToRoute('Login');}
		
		if ($request->request->get('pass') !== null) {
			return $this->redirectToRoute('Close', array('pass' => $request->request->get('pass')));}
		
		$user = $this->getUser();
		$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->getEmail() ) ) ) . "?s=500";
		return $this->render('dash/profile.twig', ['grav' => $grav_url]);}
}
 //UserPasswordEncoderInterface $passwordEncoder
			//if ($passwordEncoder->isPasswordValid($user, $request->request->get('pass'))) {
