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
			$list->setTasklist(array());
			$entityManager->persist($list);
    	$entityManager->flush();
			$list = ['id' => $list->getId(), 'name' => $data['title'], 'description' => $data['desc'], 'created' => date("F j, Y"), 'modified' => date("F j, Y"), 'total' => 0, 'completed' => 0];
			return new JsonResponse($list);}
		
		elseif ($do == 'edit') {
			$list = $this->getDoctrine()->getRepository(Lists::class)->find($data['list']);
			$list->setName($data['title']);
			$list->setDescription($data['desc']);
			$entityManager->persist($list);
			$entityManager->flush();
			return new JsonResponse($list);
		}
	}
	
	public function modTask(Request $request) {
		$data = json_decode($request->getContent(), true);
		$entityManager = $this->getDoctrine()->getManager();
		$do = $data['do'];
		$list = $this->getDoctrine()->getRepository(Lists::class)->find($data['list']);
		$tasklist = $list->getTasklist();

		if($do == 'check') {
			$task = $tasklist[$data['task']];
			$replacement = $data['change'];
			$tasklist[$data['task']]['status'] = $replacement; 
			$completed = $list->getCompleted();
			if ($replacement == 1) {
				$list->setCompleted($completed + 1);}
			else {
				$list->setCompleted($completed - 1);}
			$list->setTasklist($tasklist);
			$entityManager->persist($list);
			$entityManager->flush();	
			return new JsonResponse($data);}
		
		elseif($do == 'delete') {
			$status = $tasklist[$data['task']]['status'];
			if($status == 1) {
				$completed = $list->getCompleted();
				$list->setCompleted($completed - 1);}
			$total = $list->getTotal();
			$list->setTotal($total - 1);
			unset($tasklist[$data['task']]);
			$list->setTasklist($tasklist);
			$entityManager->persist($list);
			$entityManager->flush();
			return new JsonResponse($data);}
		
		elseif($do == 'add') {
			$tasklist[] = ["name" => $data['task'], "status" => 0];	
			$list->setTasklist($tasklist);
			$total = $list->getTotal();
			$list->setTotal($total + 1);
			$entityManager->persist($list);
			$entityManager->flush();
			$return = ['name' => $data['task'], 'status' => 0];
			return new JsonResponse($return);}
		
		elseif($do == 'sort') {
			$list->setTasklist($data['new']);
			$entityManager->persist($list);
			$entityManager->flush();
			return new JsonResponse(' ');
		}
	}
}