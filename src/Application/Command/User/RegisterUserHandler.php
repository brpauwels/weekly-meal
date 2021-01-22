<?php

declare(strict_types=1);

namespace App\Application\Command\User;

use App\Application\Command\CommandHandler;
use App\Domain\User\Email;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;

final class RegisterUserHandler implements CommandHandler
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(RegisterUser $command): void
    {
        $user = User::register(UserId::create(), Email::fromString($command->getEmail()));
        $this->userRepository->add($user);
    }
}
