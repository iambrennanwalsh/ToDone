<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Boards;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Security\CloseAccount;


class DashController extends AbstractController {
	
	
	public function boards() {
		
		return $this->render('dash/boards.twig');
		
	}
	
	
	public function list($slug) {
		$list = $this->getDoctrine()->getRepository(Lists::class)->find($slug);
		$this->denyAccessUnlessGranted('view', $list);
		return $this->render('dash/list.twig', [
			'list' => $list, 
		]);
	}
	
	
	public function profile(Request $request, CloseAccount $close) {
		
		if ($request->isMethod('post')) {
			$close->email();
			return new JsonResponse(true);
		}
		
		$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->getUser()->getEmail() ) ) ) . "?s=500";
		return $this->render('dash/profile.twig', ['grav' => $grav_url]);

	}
	
}