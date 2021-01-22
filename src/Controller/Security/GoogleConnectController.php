<?php

declare(strict_types=1);

namespace App\Controller\Security;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GoogleConnectController extends AbstractController
{
    #[Route('/connect/google', name: 'security.connect.google.start')]
    public function connect(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect(['profile', 'email'], []);
    }

    #[Route('/connect/google/check', name: 'security.connect.google.check')]
    public function connectCheck(): Response
    {
        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
