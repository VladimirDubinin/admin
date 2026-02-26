<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    protected array $filterableFields = [];

    protected array $filterParams = [];

    protected Builder $builder;

    public function __construct(
        protected Request $request,
    )
    {}

    public function setParams(array $filterParams): self
    {
        $this->filterParams = $filterParams;
        return $this;
    }

    public function apply(Builder $builder): void
    {
        $this->builder = $builder;

        foreach ($this->fields() as $field => $value) {
            $method = Str::camel($field);
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], (array) $value);
            }
        }
    }

    protected function fields(): array
    {
        $fields = !empty($this->filterParams)
            ? $this->filterParams
            : $this->request->only($this->filterableFields);

        return array_filter(
            array_map('trim', $fields)
        );
    }
}
