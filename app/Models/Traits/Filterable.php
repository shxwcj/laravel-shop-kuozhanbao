<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait Filterable
{
    /**
     * @param $query
     * @param null $input
     */
    public function scopeFilter($query, $input = null)
    {
        $input = $input && is_array($input) ? $input : request()->query();

        foreach ($input as $key => $value) {
            if (is_null($value)) {
                continue;
            }

            $method = 'filter' . Str::studly($key);

            if (method_exists($this, $method)) {
                call_user_func([$this, $method], $query, $value, $key);
            } elseif ($this->isFilterable($key)) {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }
    }

    public function isFilterable(string $key)
    {
        return defined('static::FILTERABLE') && in_array($key, constant('static::FILTERABLE'));
    }

    public function filterOrderBy($query, $value)
    {
        $segments = \explode(',', $value);

        foreach ($segments as $segment) {
            list($key, $direction) = array_pad(explode(':', $segment), 2, 'desc');

            $query->orderBy($key, $direction);
        }
    }
}