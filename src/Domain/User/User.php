<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\Event\UserWasRegistered;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;

final class User implements AggregateRoot
{
    use AggregateRootBehaviour;

    private UserId $id;
    private Email $email;

    public static function register(UserId $userId, Email $email): self
    {
        $user = new self($userId);
        $user->recordThat(new UserWasRegistered($userId, $email));

        return $user;
    }

    public function applyUserWasRegistered(UserWasRegistered $event): void
    {
        $this->id    = $event->getUserId();
        $this->email = $event->getEmail();
    }
}
