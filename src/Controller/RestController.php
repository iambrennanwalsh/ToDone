<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Lists;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RestController extends AbstractController {
	
	public function getUsers(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
		$user = $this->getUser();
	
		if (null !== $request->query->get('do')) {
			$normalizer = new ObjectNormalizer();
			$encoder = new JsonEncoder();
			$serializer = new Serializer(array($normalizer), array($encoder));
			$normalizer->setIgnoredAttributes(array('lists'));
			$jsonContent = $serializer->serialize($user, 'json');		
			return JsonResponse::fromJsonString($jsonContent);}
		
		else {
			$data = json_decode($request->getContent(), true);
			
			$oldpass = $data['oldpass'];
			if ($passwordEncoder->isPasswordValid($user, $data['oldpass'])) {
				$user->setUsername($data['user']['username']);
				$user->setEmail($data['user']['email']);
				$user->setFname($data['user']['fname']);
				$user->setLname($data['user']['lname']);
				$user->setCountry($data['user']['country']);
				$user->setGender($data['user']['gender']);
			if ($data['newpass'] !== "") {
				$user->setPassword($passwordEncoder->encodePassword($user, $data['newpass']));
			}
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->persist($user);
				$entityManager->flush();	
			}
		}
			return new JsonResponse('');
	}
	
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
			$tasklist[$data['task']]['status'] = $data['change'];
			if($data['change'] == 0) {
				$list->setCompleted($list->getCompleted() - 1);} 
			else {
				$list->setCompleted($list->getCompleted() + 1);}
			$list->setTasklist($tasklist);
			$entityManager->flush();	
			return new JsonResponse(true);}
		
		elseif($do == 'delete') {
			if($tasklist[$data['task']]['status'] == 1) {
				$list->setCompleted($list->getCompleted() - 1);}
			$list->setTotal($list->getTotal() - 1);
			unset($tasklist[$data['task']]);
			$tasklist = array_values($tasklist);
			$list->setTasklist($tasklist);
			$entityManager->flush();
			return new JsonResponse(true);}
		
		elseif($do == 'add') {
			$tasklist = new ArrayCollection($tasklist);
			$tasklist->add(["name" => $data['task'], "status" => 0]);
			$list->setTasklist($tasklist->toArray());
			$list->setTotal($list->getTotal() + 1);
			$entityManager->flush();
			return new JsonResponse(true);}
		
		elseif($do == 'sort') {
			$list->setTasklist($data['new']);
			$entityManager->persist($list);
			$entityManager->flush();
			return new JsonResponse('');}
	}
	
	public function deleteUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, TokenStorageInterface $tokenStorage) {
		$user = $this->getUser();
		$data = json_decode($request->getContent(), true);
		$do =  $data['do'];
		
		if ($do == 'check') {
			$pass = $data['pass'];
			if ($passwordEncoder->isPasswordValid($user, $pass)) {
				return new JsonResponse(['status' => true]);}
			else {
				return new JsonResponse(['status' => false]);} }
		
		if ($do == 'delete') {
			$lists = $this->getDoctrine()->getRepository(Lists::class)->findBy(array('userid' => $user->getId()));	
			$entityManager = $this->getDoctrine()->getManager();
			for ($i=0; $i<count($lists); $i++) {
				$list = $lists[$i];
				$entityManager->remove($list);
			}
			$this->get('session')->invalidate();
			$entityManager->remove($user);
			$entityManager->flush();
			$tokenStorage->setToken(null);
			return new JsonResponse(true);}
	}
				
}