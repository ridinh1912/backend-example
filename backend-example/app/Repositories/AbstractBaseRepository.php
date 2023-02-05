<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Traits\CrudRepository;

class AbstractBaseRepository implements CrudRepositoryInterface
{
    use CrudRepository;

    const PER_PAGE_LIMITS = [
    ];

    public function index(Request $request): LengthAwarePaginator
    {
        $query = $this->_buildIndexQuery($request);

        return $this->_pagination($request, $query);
    }

    private function _buildIndexQuery(Request $request): Builder
    {
        $baseQuery = $this->model->newQuery();

        $orderBy = $request->input('orderBy', 'created_at');
        $orderDirection = $request->input('orderDirection', 'desc');

        $baseQuery->orderBy($orderBy, $orderDirection);

        if ($request->input('whereAfter')) {
            foreach ($request->input('whereAfter') as $key => $values) {
                $baseQuery->where(function ($query) use ($key, $values) {
                    $query->where($key, '<=', $values)
                        ->orWhereNull($key);
                });
            }
        }

        if ($request->input('where')) {
            $baseQuery->where($request->input('where'));
        }

        if ($request->input('whereIn')) {
            foreach ($request->input('whereIn') as $key => $values) {
                $baseQuery->whereIn($key, $values);
            }
        }

        if (is_array($request->input('whereNull'))) {
            foreach ($request->input('whereNull') as $column) {
                $baseQuery->whereNull($column);
            }
        }

        if (is_array($request->input('whereNotNull'))) {
            foreach ($request->input('whereNotNull') as $column) {
                $baseQuery->whereNotNull($column);
            }
        }

        if (is_array($request->input('whereNotEmpty'))) {
            foreach ($request->input('whereNotEmpty') as $column) {
                $baseQuery->where($column, '<>', '');
            }
        }

        if (is_array($request->input('whereHas'))) {
            foreach ($request->input('whereHas') as $relationship => $where) {
                $baseQuery->whereHas($relationship, function ($query) use ($where) {
                    $query->where($where);
                });
            }
        }

        if (is_array($request->input('whereDoesntHave'))) {
            foreach ($request->input('whereDoesntHave') as $relationship => $where) {
                $baseQuery->whereDoesntHave($relationship, function ($query) use ($where) {
                    $query->where($where);
                });
            }
        }

        if ($request->input('has')) {
            foreach ((array) $request->input('has') as $relationship) {
                $baseQuery->has($relationship);
            }
        }

        if ($request->input('doesntHave')) {
            foreach ((array) $request->input('doesntHave') as $relationship) {
                $baseQuery->doesntHave($relationship);
            }
        }

        if ($request->input('search') && $request->input('searchIn')) {
            $baseQuery->where(function ($query) use ($request) {
                foreach ($request->input('searchIn') as $key => $columns) {
                    if (is_array($columns)) {
                        $query->orWhereHas($key, function ($query) use ($request, $columns) {
                            $query->where(function ($query) use ($request, $columns) {
                                foreach ($columns as $column) {
                                    $query->orWhere($column, 'like', '%'.$request->input('search').'%');
                                }
                            });
                        });
                    } else {
                        $query->orWhere($columns, 'like', '%'.$request->input('search').'%');
                    }
                }
            });
        }

        if ($request->input('addSelect')) {
            foreach ((array) $request->input('addSelect') as $addSelect) {
                $baseQuery->addSelect($addSelect);
            }
        }

        if ($groupsBy = $request->input('groupBy')) {
            if ($groupsBy) {
                foreach ($groupsBy as $groupBy) {
                    $baseQuery->groupBy($groupBy);
                }
            } else {
                $baseQuery->groupBy($groupsBy);
            }
        }

        return $baseQuery;
    }

    private function _pagination(Request $request, Builder $baseQuery): LengthAwarePaginator
    {
        $perPage = $request->input(
            'per_page',
            $this::PER_PAGE ?? 15
        );

        return $baseQuery->paginate($perPage);
    }
}
