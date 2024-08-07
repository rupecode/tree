<?php

namespace App\Repositories;

use Aura\Sql\Exception\CannotBindValue;
use Aura\Sql\ExtendedPdo;

class TreeRepository
{
    public function __construct(private ExtendedPdo $pdo)
    {
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->pdo->fetchAll('SELECT * FROM tree ORDER BY id');
    }

    /**
     * @param int $parent
     * @param string $name
     * @param string $description
     * @return bool
     * @throws CannotBindValue
     */
    public function add(int $parent, string $name, string $description): bool
    {
        $stmt = $this->pdo->prepareWithValues(
            'INSERT INTO tree SET parent = :parent, name = :name, description = :description',
            ['parent' => $parent, 'name' => $name, 'description' => $description]
        );

        return $stmt->execute();
    }

    /**
     * @param int $parent
     * @return bool
     * @throws CannotBindValue
     */
    public function deleteChild(int $parent): bool
    {
        if ($parent === 0) {
            return false;
        }

        $stmt = $this->pdo->prepareWithValues(
            'DELETE FROM tree WHERE parent = :parent',
            ['parent' => $parent]
        );

        return $stmt->execute();
    }

    /**
     * @param int $id
     * @return bool
     * @throws CannotBindValue
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepareWithValues(
            'DELETE FROM tree WHERE id = :id',
            ['id' => $id]
        );

        return $stmt->execute();
    }

    /**
     * @param int $id
     * @return array
     */
    public function get(int $id): array
    {
        return $this->pdo->fetchOne('SELECT * FROM tree WHERE id = :id', ['id' => $id]);
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @return bool
     * @throws CannotBindValue
     */
    public function update(int $id, int $parent, string $name, string $description): bool
    {
        $stmt = $this->pdo->prepareWithValues(
            'UPDATE tree SET parent = :parent, name = :name, description = :description WHERE id = :id',
            ['parent' => $parent, 'name' => $name, 'description' => $description, 'id' => $id]
        );

        return $stmt->execute();
    }
}
