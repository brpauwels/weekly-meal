<?php

declare(strict_types=1);

namespace App\Domain\User\Event;

use App\Domain\User\Email;
use App\Domain\User\UserId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class UserWasRegistered implements SerializablePayload
{
    private UserId $userId;
    private Email $email;

    public function __construct(UserId $userId, Email $email)
    {
        $this->userId = $userId;
        $this->email  = $email;
    }

    /**
     * @param array{id: string, email: string} $payload
     */
    public static function fromPayload(array $payload): SerializablePayload
    {
        return new self(UserId::fromString($payload['id']), Email::fromString($payload['email']));
    }

    /**
     * @return array{id: string, email: string}
     */
    public function toPayload(): array
    {
        return [
            'id'    => $this->userId->toString(),
            'email' => $this->email->toString(),
        ];
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
