<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lists;
use App\Entity\User;
use App\Service\EmailVerifier;

class UtilityController extends AbstractController {

	public function addList(Request $request) {
		$user = $this->getUser();
		$list = new Lists();
		$list->setUserid($user);
		$list->setName($request->request->get('title'));
		$list->setDescription($request->request->get('message'));
		$list->setCreated(time());
		$list->setModified(time());
		$entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($list);
    $entityManager->flush();
		return new JsonResponse($_REQUEST);
	}
	
	public function deleteList(Request $request) {
		$data = json_decode($request->getContent(), true);
		$user = $this->getUser();
		$list = $this->getDoctrine()->getRepository(Lists::class)->find($data['id']);
		$entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($list);
    $entityManager->flush();
		return new JsonResponse($_REQUEST);
	}
	
	public function addTask(Request $request) {
		$task = $request->request->get('newtask');
		$id = $request->request->get('id');
		$modified = $request->request->get('modified');
		dump($task);
		dump($id);
		dump($modified);
		$list = $this->getDoctrine()->getRepository(Lists::class)->find($id);
		$currentTasks = $list->getTasks();
		$tasks = $currentTasks . ',' . $task;
		$list->setTasks($tasks);
		$entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($list);
    $entityManager->flush();
		return new JsonResponse($_REQUEST);
	}

	public function contactForm(Request $request, \Swift_Mailer $mailer) {
		
		$message = (new \Swift_Message('Hello Email'))
				->setSubject($request->request->get('subject'))
				->setFrom($request->request->get('email'))
				->setTo('videncrypt@gmail.com')
				->setBody($request->request->get('message'), 'text/html');
			$mailer->send($message);
		
		return new JsonResponse($_REQUEST);
	}
	
	public function confirmEmail(Request $request, EmailVerifier $verifier) {
		if(null !== $request->query->get('id') && null !== $request->query->get('hash')) {
			$id = $request->query->get('id');
			$hash = $request->query->get('hash');
			$response = $verifier->confirm($id, $hash);
			if ($response) {
				return $this->redirectToRoute('Home', array('confirm' => 'true'));}}
		return $this->redirectToRoute('Home', array('confirm' => 'false'));
	}
	
		}