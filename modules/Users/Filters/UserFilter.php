<?php

namespace Modules\Users\Filters;

use App\Filters\QueryFilter;

class UserFilter extends QueryFilter
{
    protected array $filterableFields = ['name', 'email', 'roles'];

    public function name(string $value): void
    {
        $this->builder->where('name', 'like', "%{$value}%");
    }

    public function email(string $value): void
    {
        $this->builder->where('email', 'like', "%{$value}%");
    }

    public function roles(int $value): void
    {
        $this->builder->whereHas('roles', function ($query) use ($value) {
            $query->where('id', $value);
        });
    }
}
