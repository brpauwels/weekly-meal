<?php

declare(strict_types=1);

namespace App\Domain\User;

use Webmozart\Assert\Assert;

final class Email
{
    private string $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function fromString(string $email): self
    {
        Assert::email($email);

        return new self($email);
    }

    public function toString(): string
    {
        return $this->email;
    }
}
