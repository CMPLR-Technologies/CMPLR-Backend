<?php

namespace App\Http\Misc\Helpers;

class Filters
{
    public static function searchBy($model, $filters)
    {
        if (!empty($filters)) {
            foreach ($filters as $key => $value)
                $model = $model->where($key, 'LIKE', "%{$value}%");
        }
        return $model;
    }


    public static function orSearchBy($model, $filters)
    {
        if (!empty($filters)) {
            $model = $model->where(function ($query) use ($filters) {
                foreach ($filters as $key => $value) {
                    $query = $query->orWhere($key, 'LIKE', "%{$value}%");
                }
            });
        }
        return $model;
    }


    public static function where($model, $filters)
    {
        if (!empty($filters)) {
            $model = $model->where(function ($query) use ($filters) {
                foreach ($filters as $key => $value) {
                    $query = $query->where($key, $value);
                }
            });
        }
        return $model;
    }



    public static function orderBy($model, $filter, $sort = 'asc')
    {
        if (!in_array($sort, ['asc', 'desc']))
            $sort = 'asc';

        if (!isset($filter) || $filter == 'none')
            $filter = 'id';

        $model = $model->orderBy($filter, $sort);

        return $model;
    }
}