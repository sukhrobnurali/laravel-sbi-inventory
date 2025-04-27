<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    protected Product $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->with('category')->get();
    }

    public function find(int $id)
    {
        return $this->model->with('category')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $entity = $this->find($id);
        $entity->update($data);
        return $entity;
    }

    public function delete(int $id): bool
    {
        return (bool)$this->model->destroy($id);
    }
}
