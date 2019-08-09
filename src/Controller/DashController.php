<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Board;

class DashController extends AbstractController
{
    public function boards()
    {
        return $this->render('dash/boards.twig');
    }

    public function board($slug)
    {
        $board = $this->getDoctrine()
            ->getRepository(Board::class)
            ->findOneBy(array('slug' => $slug));
        $this->denyAccessUnlessGranted('view', $board);
        return $this->render('dash/board.twig', [
            'board' => $board
        ]);
    }

    public function profile(Request $request)
    {
        return $this->render('dash/profile.twig');
    }
}
