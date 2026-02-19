<?php

declare(strict_types=1);

namespace Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Forms\UserForm;
use Modules\Users\Models\User;
use Modules\Users\Services\UserService;

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
                'store_url' => route('admin.users.store'),
                'back_url' => route('admin.users'),
            ]
        );
    }

    public function edit(int $id): View
    {
        return view('admin.users.user',
            [
                'form_url' => route('admin.users.get_form', ['id' => $id]),
                'store_url' => route('admin.users.store'),
                'back_url' => route('admin.users'),
            ]
        );
    }

    public function getForm(UserForm $userForm, int $id = 0): array
    {
        return $userForm->form($id)->toArray();
    }

    public function store(Request $request, UserForm $userForm, UserService $userService): JsonResponse
    {
        $id = $request->input('id', 0);
        $form = $userForm->form($id);
        $form->validate();
        $fields = $form->getFieldsFromRequest();
        if ($id) {
            $userService->update($id, $fields);
        } else {
            $userService->create($fields);
        }

        return response()->json(['success' => true]);
    }
}
