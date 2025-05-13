<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

/**
 * Author: Aziz
 */

class BaseService
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model::latest()->get();
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function find(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data): Model
    {
        $model = $this->model->find($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        $model = $this->model->find($id);
        return $model->delete();
    }
}
