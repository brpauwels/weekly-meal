<?php

declare(strict_types=1);

namespace App\Domain\User;

use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

final class UserId implements AggregateRootId
{
    private UuidInterface $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function create(): UserId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $aggregateRootId): UserId
    {
        Assert::uuid($aggregateRootId);

        return new self(Uuid::fromString($aggregateRootId));
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }
}
