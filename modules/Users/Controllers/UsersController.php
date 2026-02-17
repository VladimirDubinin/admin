<?php

declare(strict_types=1);

namespace Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Users\Forms\UserForm;
use Modules\Users\Models\User;

class UsersController extends Controller
{
    public function index(): View
    {
        $users = User::all();
        return view('admin.users.list', ['users' => $users]);
    }

    public function create(): View
    {
        return view('admin.users.user',
            [
                'form_url' => route('admin.users.get_form'),
                'back_url' => route('admin.users'),
            ]
        );
    }

    public function edit(int $id): View
    {
        return view('admin.users.user',
            [
                'form_url' => route('admin.users.get_form', ['id' => $id]),
                'back_url' => route('admin.users'),
            ]
        );
    }

    public function getForm(UserForm $userForm, int $id = 0): array
    {
        return $userForm->form($id)->toArray();
    }

    public function store(Request $request): array
    {
        // Сообщение для следующей страницы
        $request->session()->flash('success_message', 'Объект сохранен');
        return [
            'redirect_url' => route('admin.users'),
        ];
    }
}
