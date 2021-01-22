<?php

declare(strict_types=1);

namespace App\Projection\User;

use App\Domain\User\Event\UserWasRegistered;
use App\Projection\Projector;
use EventSauce\EventSourcing\EventHandlingMessageConsumer;

final class UserProjector extends EventHandlingMessageConsumer implements Projector
{
    private UserReadModelRepository $userReadModelRepository;

    public function __construct(UserReadModelRepository $userReadModelRepository)
    {
        $this->userReadModelRepository = $userReadModelRepository;
    }

    public function handleUserWasRegistered(UserWasRegistered $event): void
    {
        $userReadModel = new UserReadModel($event->getUserId()->toString(), $event->getEmail()->toString());
        $this->userReadModelRepository->add($userReadModel);
    }
}
