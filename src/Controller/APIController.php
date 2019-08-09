<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;

class APIController extends AbstractController
{
    public function check_password(
        User $data,
        Request $request,
        UserPasswordEncoderInterface $encoder
    ) {
        $json = json_decode($request->getContent(), true);
        $status = $encoder->isPasswordValid($this->getUser(), $json['password'])
            ? true
            : false;
        return new JsonResponse(['status' => $status]);
    }
}
