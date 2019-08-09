<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ContactType;
use App\Entity\Submission;
use App\Mailer\AdminMailer;

class FrontController extends AbstractController
{
    public function home()
    {
        return $this->render('front/home.twig');
    }

    public function about()
    {
        return $this->render('front/about.twig');
    }

    public function contact(Request $request, AdminMailer $mailer)
    {
        $submission = new Submission();
        $response = "";
        $form = $this->createForm(ContactType::class, $submission);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($submission);
            $em->flush();
            $response = $mailer->contactFormSubmission($submission);
            return new Response(json_encode($response));
        }
        return $this->render('front/contact.twig', array(
            'form' => $form->createView()
        ));
    }

    public function terms()
    {
        return $this->render('front/terms.twig');
    }

    public function privacy()
    {
        return $this->render('front/privacy.twig');
    }
}
