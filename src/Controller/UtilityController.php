<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lists;
use App\Entity\User;
use App\Service\EmailVerifier;		
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UtilityController extends AbstractController {

	public function addList(Request $request) {
		$data = json_decode($request->getContent(), true);
		$user = $this->getUser();
		$list = new Lists();
		$list->setUserid($user);
		dump($data);
		dump($_REQUEST);
		$list->setName($request->request->get('title'));
		$list->setDescription($request->request->get('message'));
		$list->setCreated(time());
		$list->setModified(time());
		$entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($list);
    $entityManager->flush();
		$response = new JsonResponse(array('id' => $list->getId()));
		return $response;
	}
	
	public function deleteList(Request $request) {
		$data = json_decode($request->getContent(), true);
		$list = $this->getDoctrine()->getRepository(Lists::class)->find($data['id']);
		$entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($list);
    $entityManager->flush();
		return new JsonResponse($_REQUEST);
	}
	
	public function checkIt(Request $request) {
		$data = json_decode($request->getContent(), true);
		$list = $this->getDoctrine()->getRepository(Lists::class)->find($data['listid']);
		$tasks = $list->getTasks(); // 's' => 0 - 's' => 1 - s => 0 - g => 0
		$tasksarray = explode(' - ', $tasks); // ["'s' => 0", "'s' => 1", "s => 0", "g => 0"]
		$task = $tasksarray[$data['id']]; // "s => 0"
		$replacement = $data['change'];
		$final = substr($task, 0, -1).$replacement;
		$tasksarray[$data['id']] = $final;
		$finale = implode(' - ', $tasksarray);
		$list->setTasks($finale);
		$entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($list);
    $entityManager->flush();
		return new JsonResponse($data);
	}
	
	public function deleteIt(Request $request) {
		$data = json_decode($request->getContent(), true);
		$list = $this->getDoctrine()->getRepository(Lists::class)->find($data['listid']);
		$tasks = $list->getTasks(); 
		$tasksarray = explode(' - ', $tasks);
		unset($tasksarray[$data['id']]);
		$finale = implode(' - ', $tasksarray);
		$list->setTasks($finale);
		$entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($list);
    $entityManager->flush();
		return new JsonResponse($data);
	}
	
	public function addTask(Request $request) {
		$task = $request->request->get('newtask');
		$id = $request->request->get('id');
		$modified = $request->request->get('modified');
		$list = $this->getDoctrine()->getRepository(Lists::class)->find($id);
		$currentTasks = $list->getTasks();
		if($task == '') {
		$task = ' ';}
		if (null != $currentTasks) {
		$tasks = $currentTasks . ' - ' . $task . ' => 0';}
		else {
		$tasks = $task . ' => 0';
		}
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
				return $this->redirectToRoute('Home', array('confirm' => 'true'));}
		return $this->redirectToRoute('Home', array('confirm' => 'false'));
	} elseif(null !== $request->query->get('resend')) {
			$user = $this->getUser();
			$id = $user->getId();
			$verifier->email($id);
			return $this->redirectToRoute('Lists', array('sent' => 'true'));
	}
	
		}
	
	public function getLists(Request $request) {
		$user = $this->getUser();
		$lists = $this->getDoctrine()->getRepository(Lists::class)->findBy(array('userid' => $user->getId()));
		$normalizer = new ObjectNormalizer();
		$normalizer->setIgnoredAttributes(array('userid'));
		$encoder = new JsonEncoder();
		$serializer = new Serializer(array($normalizer), array($encoder));
		$jsonContent = $serializer->serialize($lists, 'json');		
		return JsonResponse::fromJsonString($jsonContent);
	}
}