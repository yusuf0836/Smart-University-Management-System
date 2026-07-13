<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilter
{
    public static function apply(
        Builder $query,
        Request $request,
        array $searchColumns = [],
        array $filterColumns = [],
        array $sortableColumns = []
    ) {
        // Search
        if ($request->filled('search') && !empty($searchColumns)) {

            $search = $request->search;

            $query->where(function ($q) use ($search, $searchColumns) {

                foreach ($searchColumns as $column) {

                    // Relationship Search
                    if (str_contains($column, '.')) {

                        [$relation, $field] = explode('.', $column, 2);

                        $q->orWhereHas($relation, function ($r) use ($field, $search) {
                            $r->where($field, 'like', "%{$search}%");
                        });

                    } else {

                        $q->orWhere($column, 'like', "%{$search}%");

                    }
                }

            });

        }

        // Filters
        foreach ($filterColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->$column);
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = strtolower($request->get('sort_order', 'desc'));

        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        if (!empty($sortableColumns) && in_array($sortBy, $sortableColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        // Pagination
        $perPage = (int) $request->get('per_page', 10);

        return $query->paginate($perPage);
    }
}