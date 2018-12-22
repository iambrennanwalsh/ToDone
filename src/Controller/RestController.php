<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lists;
use App\Entity\User;

class RestController extends AbstractController {
	
	public function getList(Request $request) {
		$user = $this->getUser();
		$do = $request->query->get('do');
		
		if ($do == 'list') {
			$list = $request->query->get('list');
			$list = explode('/', $list);
			$list = array_pop($list);
			$return =  $this->getDoctrine()->getRepository(Lists::class)->findBy(array('userid' => $user->getId(), 'id' => $list));}
		
		elseif($do == 'lists') {
			$return = $this->getDoctrine()->getRepository(Lists::class)->findBy(array('userid' => $user->getId()));}
		
		$normalizer = new ObjectNormalizer();
		$normalizer->setIgnoredAttributes(array('userid'));
		$encoder = new JsonEncoder();
		$serializer = new Serializer(array($normalizer), array($encoder));
		$jsonContent = $serializer->serialize($return, 'json');		
		return JsonResponse::fromJsonString($jsonContent);
	}
	
	public function modList(Request $request) {
		$user = $this->getUser();
		$entityManager = $this->getDoctrine()->getManager();
		$data = json_decode($request->getContent(), true);
		$do =  $data['do'];
		
		if ($do == 'delete') {
			$list = $this->getDoctrine()->getRepository(Lists::class)->find($data['list']['id']);
			$entityManager->remove($list);
			$entityManager->flush();
			return new JsonResponse('idkyet');}
		
		elseif ($do == 'add') {
			$list = new Lists();
			$list->setUserid($user);
			$list->setName($data['title']);
			$list->setDescription($data['desc']);
			$list->setCreated(date("F j, Y"));
			$list->setModified(date("F j, Y"));
			$list->setTotal(0);
			$list->setCompleted(0);
			$entityManager->persist($list);
    	$entityManager->flush();
			$list = ['id' => $list->getId(), 'name' => $data['title'], 'description' => $data['desc'], 'created' => date("F j, Y"), 'modified' => date("F j, Y"), 'total' => 0, 'completed' => 0];
			return new JsonResponse($list);}
	}
	
	public function modTask(Request $request) {
		$data = json_decode($request->getContent(), true);
		$entityManager = $this->getDoctrine()->getManager();
		$do = $data['do'];
		$list = $this->getDoctrine()->getRepository(Lists::class)->find($data['list']);
		$tasks = $list->getTasks();
		$tasksarray = explode(' - ', $tasks);
		
		if($do == 'check') {
			$task = $tasksarray[$data['task']];
			$replacement = $data['change'];
			$v = $list->getCompleted();
			if ($replacement == 1) {
				$list->setCompleted($v + 1);}
			else {
				$list->setCompleted($v - 1);}
			$replacement = substr($task, 0, -1).$replacement;
			$tasksarray[$data['task']] = $replacement;
			$replacement = implode(' - ', $tasksarray);
			$replacement = trim($replacement, " - ");
			$list->setTasks($replacement);
			$entityManager->persist($list);
			$entityManager->flush();	
			return new JsonResponse($data);}
		
		elseif($do == 'delete') {
			$status = $tasksarray[$data['task']][-1];
			if($status == 1) {
				$v = $list->getCompleted();
				$list->setCompleted($v - 1);}
			$v = $list->getTotal();
			$list->setTotal($v - 1);
			unset($tasksarray[$data['task']]);
			$replacement = implode(' - ', $tasksarray);
			$replacement = trim($replacement, " - ");
			$list->setTasks($replacement);
			$entityManager->persist($list);
			$entityManager->flush();
			return new JsonResponse($data);}
		
		elseif($do == 'add') {
			$tasksarray[] =  $data['task'] . ' => 0';
			$replacement = implode(' - ', $tasksarray);
			$replacement = trim($replacement, " - ");
			$list->setTasks($replacement);
			$v = $list->getTotal();
			$list->setTotal($v + 1);
			$entityManager->persist($list);
			$entityManager->flush();
			$return = [$data['task'], 0];
			return new JsonResponse($return);}
		
	}
}