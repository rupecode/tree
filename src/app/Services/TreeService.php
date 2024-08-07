<?php

namespace App\Services;

use App\Repositories\TreeRepository;
use BlueM\Tree;

class TreeService
{
    public function __construct(private TreeRepository $treeRepository)
    {
    }

    public function getTree(): Tree
    {
        $data = $this->treeRepository->getAll();

        $tree = new Tree($data);

        return $tree;
    }

    public function add(int $id, string $name, string $description): void
    {
        $this->treeRepository->add($id, $name, $description);
    }

    public function delete(int $id): void
    {
        $this->treeRepository->deleteChild($id);
        $this->treeRepository->delete($id);
    }

    public function get(int $id): array
    {
        return $this->treeRepository->get($id);
    }

    public function update(int $id, int $parent, string $name, string $description): void
    {
        $this->treeRepository->update($id, $parent, $name, $description);
    }
}
