<?php

namespace App\Shared\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    protected array $form = [];

    protected Builder $builder;

    public function __construct(
        protected Request $request,
    )
    {
        $this->form();
    }

    /** Метод должен заполнять массив формы */
    abstract public function form(): void;

    /** Метод возвращает массив формы фильтра @return array */
    public function toArray(): array
    {
        return $this->form;
    }

    /**
     * Метод добавляет в построитель запроса условия в соответствии с параметрами фильтра
     * Ключу поля в форме фильтра должен соответствовать метод в camelCase
     *
     * @param Builder $builder
     * @return void
     */
    public function apply(Builder $builder): void
    {
        $this->builder = $builder;

        foreach ($this->fields() as $field => $value) {
            $method = Str::camel($field);
            if (method_exists($this, $method) && !empty($value)) {
                call_user_func_array([$this, $method], (array) $value);
            }
        }
    }

    /**
     * Метод возвращает массив значений полей фильтра из реквеста
     *
     * @return array
     */
    public function fields(): array
    {
        $fields = $this->request->only(array_keys($this->form));

        return array_filter(
            array_map('trim', $fields)
        );
    }
}
