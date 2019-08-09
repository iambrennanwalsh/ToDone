<?php

namespace App\Security\Guard;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use KnpU\OAuth2ClientBundle\Client\Provider\GithubClient;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class OauthAuthenticator extends SocialAuthenticator
{
    private $clientRegistry;
    private $em;
    private $router;
    private $user;
    private $network;

    public function __construct(
        ClientRegistry $clientRegistry,
        EntityManagerInterface $em,
        RouterInterface $router
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
    }

    public function supports(Request $request)
    {
        if ($request->attributes->get('_route') === 'Github_Check') {
            $this->network = "github";
        } elseif ($request->attributes->get('_route') === 'Facebook_Check') {
            $this->network = "facebook";
        } else {
            return false;
        }
        return true;
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $this->user = $this->getClient()->fetchUserFromToken($credentials);
        if ($this->network == "github") {
            $user = $this->em
                ->getRepository(User::class)
                ->findOneBy(['githubId' => $this->user->getId()]);
            if ($user) {
                return $user;
            }
            $user = $this->em
                ->getRepository(User::class)
                ->findOneBy(['email' => $this->user->getEmail()]);
            if ($user) {
                $user->setGithubId($this->user->getId());
                $this->em->persist($user);
                $this->em->flush();
                return $user;
            }
        } else {
            $user = $this->em
                ->getRepository(User::class)
                ->findOneBy(['facebookId' => $this->user->getId()]);
            if ($user) {
                return $user;
            }
            $user = $this->em
                ->getRepository(User::class)
                ->findOneBy(['email' => $this->user->getEmail()]);
            if ($user) {
                $user->setFacebookId($this->user->getId());
                $this->em->persist($user);
                $this->em->flush();
                return $user;
            }
        }
    }

    private function getClient()
    {
        return $this->clientRegistry->getClient($this->network);
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        $providerKey
    ) {
        return new redirectResponse($this->router->generate('Boards'));
    }

    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ) {
        return new redirectResponse(
            $this->router->generate('Signup', [
                "oauth" => $this->network,
                "email" => $this->user->getEmail(),
                "id" => $this->user->getId(),
                "name" => $this->user->getName()
            ])
        );
    }

    public function start(
        Request $request,
        AuthenticationException $authException = null
    ) {
        return new RedirectResponse(
            '/login/',
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }
}
