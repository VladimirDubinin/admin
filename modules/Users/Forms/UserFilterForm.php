<?php

declare(strict_types=1);

namespace Modules\Users\Forms;

use App\Forms\AbstractForm;
use App\Forms\Inputs\InputEmail;
use App\Forms\Inputs\Select;
use App\Forms\Inputs\InputText;
use Illuminate\Http\Request;
use Modules\Users\Models\Role;

class UserFilterForm extends AbstractForm
{
    public function form(): self
    {
        $request = app(Request::class);

        $this->form = [
            'name' => (new InputText())
                ->setLabel('Имя')
                ->setValidationRule('string|nullable')
                ->setValue($request->input('name'))
                ->setNameAndId('name')
                ->get(),

            'email' => (new InputEmail())
                ->setLabel('Email')
                ->setValidationRule('email|nullable')
                ->setValue($request->input('email'))
                ->setNameAndId('email')
                ->get(),

            'roles' => (new Select())
                ->setLabel('Роль')
                ->setValue($request->input('roles'))
                ->setValidationRule('nullable')
                ->setNameAndId('roles')
                ->defaultNothing()
                ->setItems(function () {
                    return Role::query()->select(['id', 'display_name AS name'])->get();
                })
                ->get(),
        ];

        return $this;
    }
}
