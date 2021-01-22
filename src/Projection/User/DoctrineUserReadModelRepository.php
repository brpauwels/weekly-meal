<?php

declare(strict_types=1);

namespace App\Projection\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineUserReadModelRepository extends ServiceEntityRepository implements UserReadModelRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        return parent::__construct($registry, UserReadModel::class);
    }

    public function add(UserReadModel $userReadModel): void
    {
        $this->getEntityManager()->persist($userReadModel);
    }

    public function findOneByEmail(string $email): ?UserReadModel
    {
        return $this->findOneBy(['email' => $email]);
    }
}
