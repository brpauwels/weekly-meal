<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Security;

use App\Application\Query\QueryBus;
use App\Application\Query\User\FindUserByEmail;
use App\Projection\User\UserReadModel;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use function sprintf;

final class AuthUserProvider implements UserProviderInterface
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function loadUserByUsername(string $username): AuthUser
    {
        $user = $this->getUser($username);

        return new AuthUser($user->getEmail());
    }

    public function refreshUser(UserInterface $user): AuthUser
    {
        $user = $this->getUser($user->getUsername());

        return new AuthUser($user->getEmail());
    }

    public function supportsClass(string $class): bool
    {
        return $class === AuthUser::class;
    }

    private function getUser(string $email): UserReadModel
    {
        $user = $this->queryBus->dispatch(new FindUserByEmail($email));

        if ($user === null) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $email));
        }

        return $user;
    }
}
