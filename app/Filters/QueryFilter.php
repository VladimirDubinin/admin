<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    protected array $filterableFields = [];

    protected Builder $builder;

    public function __construct(
        protected Request $request,
    )
    {
        $this->form();
    }

    abstract public function form(): void;

    /** Метод возвращает массив формы фильтра @return array */
    public function toArray(): array
    {
        return $this->filterableFields;
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
        $fields = $this->request->only(array_keys($this->filterableFields));

        return array_filter(
            array_map('trim', $fields)
        );
    }
}
