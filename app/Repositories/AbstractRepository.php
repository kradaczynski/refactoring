<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractRepository
{
    protected Model $model;

    public function save(array $data): void
    {
        $this->model->create($data);
    }

    public function update(int $id, array $data): void {
        $this->model->where('id', $id)->update($data);
    }

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function destroy(int $id): int {
        return $this->model->destroy($id);
    }
}
