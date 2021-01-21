<?php

declare(strict_types=1);

namespace App\Application\Command\User;

use App\Application\Command\Command;

final class RegisterUser implements Command
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
