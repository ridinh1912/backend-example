<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

trait CrudRepository
{
    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create(Arr::only($attributes, $this->getColumns()));
    }

    public function update(array $attributes): bool
    {
        return $this->model->update(Arr::only($attributes, $this->getColumns()));
    }

    public function delete(): bool
    {
        return $this->getModel()->delete();
    }

    private function getColumns()
    {
        return Schema::getColumnListing($this->model->getTable());
    }
}
