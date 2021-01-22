<?php

declare(strict_types=1);

namespace App\Projection\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="projection_user")
 */
class UserReadModel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private string $id;

    /** @ORM\Column(type="string", unique=true) */
    private string $email;

    public function __construct(string $id, string $email)
    {
        $this->id    = $id;
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
