<?php

namespace App\Repository;

use App\Entity\User;
use App\Exception\UserNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function remove(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    public function getByUsername(string $username): User
    {
        $user = $this->findOneByUsername($username);

        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function getById(int $id): User
    {
        $user = $this->find($id);

        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
