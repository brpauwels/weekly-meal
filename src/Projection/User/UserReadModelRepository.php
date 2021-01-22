<?php

declare(strict_types=1);

namespace App\Projection\User;

interface UserReadModelRepository
{
    public function add(UserReadModel $userReadModel): void;

    public function findOneByEmail(string $email): ?UserReadModel;
}
