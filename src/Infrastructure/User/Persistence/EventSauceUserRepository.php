<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Persistence;

use App\Domain\User\User;
use App\Domain\User\UserRepository;
use EventSauce\EventSourcing\ConstructingAggregateRootRepository;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\MessageRepository;

final class EventSauceUserRepository implements UserRepository
{
    private ConstructingAggregateRootRepository $aggregateRootRepository;

    public function __construct(
        MessageRepository $messageRepository,
        MessageDispatcher $dispatcher = null,
        MessageDecorator $decorator = null
    ) {
        $this->aggregateRootRepository = new ConstructingAggregateRootRepository(
            User::class,
            $messageRepository,
            $dispatcher,
            $decorator
        );
    }

    public function add(User $user): void
    {
        $this->aggregateRootRepository->persist($user);
    }
}
