<?php

namespace Fulll\Infra\Parking\Repository;

use PDO;
use PDOStatement;

abstract class AbstractRepository
{
    private ?PDO $pdo = null;

    protected function getPdo(): PDO {
        if ($this->pdo === null) {
            // Usually Symfony and Doctrine help us here and there should be a lot more of security and dependency injection.
            $host = filter_input(INPUT_ENV, 'DB_HOST', FILTER_SANITIZE_SPECIAL_CHARS);
            $user = filter_input(INPUT_ENV, 'DB_USER', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_ENV, 'DB_PASSWORD');
            $database = filter_input(INPUT_ENV, 'DB_DATABASE', FILTER_SANITIZE_SPECIAL_CHARS);

            // Sorry for postgres lovers but to ease up the exercise I stayed on what I already know ;)
            $dsn = "mysql:host=$host;dbname=$database";
            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return $this->pdo;
    }

    protected function genericFindById(int $id): ?object
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
        return $this->fetchOne($sql, ['id' => $id]);
    }

    protected function fetchOne(string $sql, array $params = []): mixed
    {
        $stmt = $this->prepareQuery($sql, $params);
        $row = $stmt->fetch();

        return false === $row ? null : $this->hydrate($row);
    }

    protected function fetchAll(string $sql, array $params = []): mixed
    {
        $stmt = $this->prepareQuery($sql, $params);

        return array_map(
            $this->hydrate(...),
            $stmt->fetchAll()
        );
    }

    protected function prepareQuery(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }


    abstract protected function getTableName(): string;
    abstract protected function getEntityClass(): string;
    abstract protected function hydrate(array $row): object;
}