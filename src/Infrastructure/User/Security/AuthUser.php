<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Security;

use JsonSerializable;
use Symfony\Component\Security\Core\User\UserInterface;

final class AuthUser implements UserInterface, JsonSerializable
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return '';
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email,
        ];
    }
}
