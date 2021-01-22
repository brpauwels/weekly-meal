<?php

declare(strict_types=1);

namespace App\Application\Query\User;

use App\Application\Query\Query;

final class FindUserByEmail implements Query
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
