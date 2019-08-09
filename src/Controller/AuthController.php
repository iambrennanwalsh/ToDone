<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\Guard\UserAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Entity\User;
use App\Form\SignupType;
use App\Form\ForgotType;
use App\Form\ResetType;
use App\Mailer\UserMailer;
use App\Security\EmailVerification;

class AuthController extends AbstractController
{
    public function signup(
        Request $request,
        UserAuthenticator $authenticator,
        GuardAuthenticatorHandler $guardHandler
    ) {
        $user = new User();
        $oauth = false;
        if ($request->query->get("oauth")) {
            $oauth = true;
            $user->setConfirmed(true);
            $user->setEmail($request->query->get("email"));
            $user->setFirstName(explode(" ", $request->query->get("name"))[0]);
            $user->setLastName(explode(" ", $request->query->get("name"))[1]);
            if ($request->query->get("oauth") == "facebook") {
                $user->setFacebookId($request->query->get("id"));
            } elseif ($request->query->get("oauth") == "github") {
                $user->setGithubId($request->query->get("id"));
            }
        }
        $form = $this->createForm(SignupType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush($user);
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $errors = "";
            foreach ($form as $fieldName => $formField) {
                if ($formField->getErrors() != "") {
                    $errors .=
                        "<b>$fieldName</b>: " .
                        $formField->getErrors() .
                        "<br>";
                }
            }
            $errors = "<p>" . str_replace("ERROR", "", $errors) . "</p>";
            $this->addFlash("danger", $errors);
        }
        return $this->render('auth/signup.twig', [
            'form' => $form->createView(),
            'oauth' => $oauth,
            'user' => $user
        ]);
    }

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error) {
            $this->addFlash("danger", $error->getMessageKey());
        }
        return $this->render('auth/login.twig');
    }

    public function forgot(Request $request, UserMailer $mailer)
    {
        $form = $this->createForm(ForgotType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $repository = $this->getDoctrine()->getRepository(User::class);
            $email = $repository->findOneBy(array('email' => $data['user']));
            $phone = $repository->findOneBy(array('phone' => $data['user']));
            if ($email || $phone) {
                $user = $email ? $email : $phone;
                $mailer->resetPassword($user);
                $this->addFlash(
                    "success",
                    "Great! Now check your email (" .
                        $user->getEmail() .
                        ") for further instructions!"
                );
            } else {
                $this->addFlash(
                    "danger",
                    "We're sorry, that email wasn't connected to any of our users."
                );
            }
        }
        return $this->render('auth/forgot.twig', [
            'form' => $form->createView()
        ]);
    }

    public function change(
        Request $request,
        UserAuthenticator $authenticator,
        GuardAuthenticatorHandler $guardHandler
    ) {
        $form = $this->createForm(ResetType::class);
        $form->handleRequest($request);
        if ($request->query->get('id') && $request->query->get('hash')) {
            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->find($request->query->get('id'));
            if ($user && $user->getPassword() == $request->query->get('hash')) {
                if ($form->isSubmitted() && $form->isValid()) {
                    $data = $form->getData();
                    $user->setPassword($data['password']);
                    $this->getDoctrine()
                        ->getManager()
                        ->flush($user);
                    $this->addFlash(
                        'success',
                        'Your password has been changed succesfully.'
                    );
                    return $guardHandler->authenticateUserAndHandleSuccess(
                        $user,
                        $request,
                        $authenticator,
                        'main'
                    );
                } else {
                    return $this->render('auth/reset.twig', [
                        'form' => $form->createView()
                    ]);
                }
            }
        }
        $this->addFlash('danger', 'Sorry something went wrong.');
        return $this->redirectToRoute('Forgot');
    }

    public function confirm(Request $request, UserMailer $mailer)
    {
        if ($request->query->get('id') && $request->query->get('hash')) {
            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->find($request->query->get('id'));
            if ($user && $user->getPassword() == $request->query->get('hash')) {
                $user->setConfirmed(true);
                $this->getDoctrine()
                    ->getManager()
                    ->flush($user);
                $this->addFlash(
                    'success',
                    'Your email has been verified. Thanks.'
                );
            } else {
                $this->addFlash(
                    'danger',
                    'That link expired, or there is a problem on our end.'
                );
            }
        } elseif ($request->query->get('resend')) {
            $mailer->confirmEmail($this->getUser());
            $this->addFlash(
                'success',
                'The verification email has been resent. Check your inbox.'
            );
        }
        $url = $request->headers->get('referer');
        if (!$url) {
            $url = $this->generateUrl('Home');
        }
        return $this->redirect($url);
    }
}
