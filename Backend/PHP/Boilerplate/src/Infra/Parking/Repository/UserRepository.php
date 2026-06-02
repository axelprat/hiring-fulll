<?php

namespace Fulll\Infra\Parking\Repository;

use Fulll\Domain\Parking\Entity\User;
use Fulll\Domain\Parking\ValueObject\UserId;
use Fulll\Infra\Parking\Exception\UserNotFoundException;

class UserRepository extends AbstractRepository
{

    public function findById(UserId $userId): User
    {
        $user = $this->genericFindById($userId->value);
        if ($user === null) {
            throw new UserNotFoundException(sprintf('User #%s not found', $userId->value));
        }

        return $user;
    }

    protected function getTableName(): string
    {
        return 'user_table';
    }

    protected function getEntityClass(): string
    {
        return User::class;
    }

    protected function hydrate(array $row): User
    {
        return new User(new UserId($row['id']));
    }
}