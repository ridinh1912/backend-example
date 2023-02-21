<?php

namespace App\Http\Controllers\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
trait HasCrud
{
    protected function _create(Model $model): JsonResponse
    {
        return $this->respondCreated($model->getResource());
    }

    protected function _update(Model $model): JsonResponse
    {
        return $this->respondOk($model->refresh()->getResource());
    }

    protected function _show(Model $model): JsonResponse
    {
        return $this->respondOk($model->getResource());
    }

    protected function _index(Request $request): LengthAwarePaginator
    {
        return $this->repository->index($request);
    }

    protected function _respondIndex(Request $request, LengthAwarePaginator $items, $resource)
    {
        return $this->respondOk(
            [
                'items' => $resource->toArray($request),
                'total' => $items->total(),
                'perPage' => $items->perPage(),
                'count' => $items->count(),
            ]
        );
    }

    protected function _delete()
    {
        return $this->respondAccepted();
    }
}
