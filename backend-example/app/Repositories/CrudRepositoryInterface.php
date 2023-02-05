<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface CrudRepositoryInterface
{
    public function create(array $attributes): Model;

    public function setModel(Model $model): self;

    public function getModel(): Model;

    public function update(array $attributes): bool;

    public function delete(): bool;
}
