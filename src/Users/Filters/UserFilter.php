<?php

namespace Src\Users\Filters;

use App\Filters\QueryFilter;
use App\Forms\Inputs\InputText;
use App\Forms\Inputs\Select;
use Src\Users\Models\Role;

class UserFilter extends QueryFilter
{
    public function form(): void
    {
        $this->form = [
            'name' => (new InputText())
                ->setLabel('Имя')
                ->setValue($this->request->input('name'))
                ->setNameAndId('name')
                ->get(),

            'email' => (new InputText())
                ->setLabel('Email')
                ->setValue($this->request->input('email'))
                ->setNameAndId('email')
                ->get(),

            'roles' => (new Select())
                ->setLabel('Роль')
                ->setValue($this->request->input('roles'))
                ->setNameAndId('roles')
                ->defaultNothing()
                ->setItems(function () {
                    return Role::query()->select(['id', 'display_name AS name'])->get();
                })
                ->get(),
        ];
    }

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
