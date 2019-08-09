<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OauthController extends AbstractController
{
    public function githubConnect(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('github')
            ->redirect(['user', 'user:email']);
    }

    public function githubCheck()
    {
    }

    public function facebookConnect(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('facebook')
            ->redirect(['public_profile', 'email']);
    }

    public function facebookCheck()
    {
    }
}
