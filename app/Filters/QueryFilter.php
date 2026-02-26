<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    protected array $filterParams;

    protected Builder $builder;

    public function __construct(array $filterParams)
    {
        $this->filterParams = $filterParams;
    }

    public function apply(Builder $builder): void
    {
        $this->builder = $builder;

        foreach ($this->filterParams as $field => $value) {
            $method = Str::camel($field);
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], (array) $value);
            }
        }
    }
}
