<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Security;

use App\Application\Command\CommandBus;
use App\Application\Command\User\RegisterUser;
use App\Application\Query\QueryBus;
use App\Application\Query\User\FindUserByEmail;
use App\Projection\User\UserReadModel;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use function assert;
use function strtr;

final class GoogleAuthenticator extends SocialAuthenticator
{
    private ClientRegistry $clientRegistry;
    private CommandBus $commandBus;
    private QueryBus $queryBus;
    private RouterInterface $router;

    public function __construct(
        ClientRegistry $clientRegistry,
        CommandBus $commandBus,
        QueryBus $queryBus,
        RouterInterface $router
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->commandBus     = $commandBus;
        $this->queryBus       = $queryBus;
        $this->router         = $router;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse(
            $this->router->generate('security.login'),
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === 'security.connect.google.check';
    }

    public function getCredentials(Request $request): AccessTokenInterface
    {
        return $this->fetchAccessToken($this->getGoogleClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider): AuthUser
    {
        $googleUser = $this->getGoogleClient()
                           ->fetchUserFromToken($credentials);
        assert($googleUser instanceof GoogleUser);

        $email = $googleUser->getEmail();

        if (null === $email) {
            throw new AuthenticationException('Email is required');
        }

        $existingUser = $this->queryBus->dispatch(new FindUserByEmail($email));
        if (null !== $existingUser) {
            assert($existingUser instanceof UserReadModel);

            return new AuthUser($existingUser->getEmail());
        }

        $this->commandBus->dispatch(new RegisterUser($email));

        return new AuthUser($email);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): Response
    {
        $targetUrl = $this->router->generate('home');

        return new RedirectResponse($targetUrl);
    }

    private function getGoogleClient(): OAuth2ClientInterface
    {
        return $this->clientRegistry->getClient('google');
    }
}
