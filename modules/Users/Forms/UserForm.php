<?php

declare(strict_types=1);

namespace Modules\Users\Forms;

use App\Forms\AbstractForm;
use App\Forms\Inputs\InputEmail;
use App\Forms\Inputs\InputPassword;
use App\Forms\Inputs\Select;
use App\Forms\Inputs\InputText;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Modules\Users\Models\Role;
use modules\Users\Models\User;

class UserForm extends AbstractForm
{
    public function form(int $userId = 0): self
    {
        if (!empty($userId)) {
            $this->entityData = User::query()->find($userId);
        }

        $this->form = [
            'id' => !empty($this->entityData->id) ? (int) $this->entityData->id : 0,

            'name' => (new InputText())
                ->setLabel('Имя')
                ->setValidationRule('required')
                ->setValue($this->getFieldValue('name.value'))
                ->setNameAndId('name.value')
                ->get(),

            'email' => (new InputEmail())
                ->setLabel('Email')
                ->setValidationRule([
                    'required',
                    Rule::unique('users', 'email')->ignore($userId),
                    'email',
                ])
                ->setValue($this->getFieldValue('email.value'))
                ->setNameAndId('email.value')
                ->get(),

            'password' => (new InputPassword())
                ->setLabel('Пароль')
                ->setValidationRule('nullable|min:8')
                ->setNameAndId('password.value')
                ->get(),

            'roles' => (new Select())
                ->setLabel('Роль')
                ->setValidationRule('required')
                ->setValue($this->getSelectedRoles())
                ->setNameAndId('roles.value')
                ->setItems(function () {
                    return Role::query()->select(['id', 'display_name AS name'])->get();
                })
                ->get(),
        ];

        if (!empty($this->entityData)) {
            $this->form['created_at'] = $this->entityData->created_at;
            $this->form['updated_at'] = $this->entityData->updated_at;
        }

        return $this;
    }

    protected function getFieldsDefinition(): array
    {
        return config('forms.user');
    }

    private function getSelectedRoles(): array|Collection
    {
        if (empty($this->entityData)) {
            return [];
        }

        return $this->entityData->roles->pluck('id');
    }

    public function validationMessages(): array
    {
        return [
            'email.value.unique' => 'Этот адрес электронной почты уже занят',
            'email.value.required' => 'Поле Email обязательно для заполнения',
            'name.value.required' => 'Поле Имя обязательно для заполнения',
            'roles.value.required' => 'Укажите роль пользователя',
            'password.value.min' => 'Пароль должен содержать минимум 8 символов',
        ];
    }
}
