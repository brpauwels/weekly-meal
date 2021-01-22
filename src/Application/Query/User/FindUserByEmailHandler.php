<?php

declare(strict_types=1);

namespace App\Application\Query\User;

use App\Application\Query\QueryHandler;
use App\Projection\User\UserReadModel;
use App\Projection\User\UserReadModelRepository;

final class FindUserByEmailHandler implements QueryHandler
{
    private UserReadModelRepository $userReadModelRepository;

    public function __construct(UserReadModelRepository $userReadModelRepository)
    {
        $this->userReadModelRepository = $userReadModelRepository;
    }

    public function __invoke(FindUserByEmail $query): ?UserReadModel
    {
        return $this->userReadModelRepository->findOneByEmail($query->getEmail());
    }
}
